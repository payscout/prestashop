<?php
/**
* 2007-2016 PrestaShop SA
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

include(dirname(__FILE__). '/../../config/config.inc.php');
include(dirname(__FILE__). '/../../init.php');
// will include backward file /
include(dirname(__FILE__). '/payscoutinc.php');
$payscoutinc = new PayscoutInc();
// Does the cart exist and is valid? /
$cart = Context::getContext()->cart;
if (!Tools::getIsset(Tools::getValue('x_invoice_num'))){
    Logger::addLog('Missing x_invoice_num', 4);
    die('An unrecoverable error occured: Missing parameter');
}
if (!Validate::isLoadedObject($cart)){
    Logger::addLog('Cart loading failed for cart '. Tools::getValue('x_invoice_num'), 4);
    die('An unrecoverable error occured with the cart '. Tools::getValue('x_invoice_num'));
}

if ($cart->id != Tools::getValue('x_invoice_num')){
    Logger::addLog('Conflict between cart id order and customer cart id');
    die('An unrecoverable conflict error occured with the cart '. (int) Tools::getValue('x_invoice_num'));
}

$customer = new Customer((int)$cart->id_customer);
$invoiceAddress = new Address((int)$cart->id_address_invoice);
$currency = new Currency((int)$cart->id_currency);

if (!Validate::isLoadedObject($customer) || !Validate::isLoadedObject($invoiceAddress) && !Validate::isLoadedObject($currency)){
    Logger::addLog('Issue loading customer, address and/or currency data');
    die('An unrecoverable error occured while retrieving you data');
}
$params = array('pass_through' => (int)Tools::getValue('x_invoice_num'), 'initial_amount' => number_format((float)$cart->getOrderTotal(true, 3), 2, '.', ''), 'expiration_month' => Tools::safeOutput(Tools::getValue('x_exp_date_m')), 'expiration_year' => Tools::safeOutput(Tools::getValue('x_exp_date_y')), 'billing_address_line_1' => trim(Tools::safeOutput($invoiceAddress->address1.' '.$invoiceAddress->address2)), 'billing_postal_code' => Tools::safeOutput($invoiceAddress->postcode), 'billing_city' => Tools::safeOutput($invoiceAddress->city), 'billing_country' => Tools::safeOutput($invoiceAddress->country), 'billing_first_name' => Tools::safeOutput($customer->firstname), 'billing_last_name' => Tools::safeOutput($customer->lastname), 'currency' => $currency->iso_code, 'client_username' => Tools::safeOutput(Configuration::get('PAYSCOUT_INC_CLIENT_USERNAME_'.$currency->iso_code)), 'client_password' => Tools::safeOutput(Configuration::get('PAYSCOUT_INC_CLIENT_PASSWORD_'.$currency->iso_code)), 'client_token' => Tools::safeOutput(Configuration::get('PAYSCOUT_INC_CLIENT_TOKEN_'.$currency->iso_code)), 'account_number' => Tools::safeOutput(Tools::getValue('x_card_num')), 'cvv2' => Tools::safeOutput(Tools::getValue('x_card_code')));
$postString = '';
foreach ($params as $key => $value){
    $postString .= $key.'='.urlencode($value).'&';
}
$postString = trim($postString, '&'); 
$url = 'https://'.(Configuration::get('PAYSCOUT_INC_SANDBOX') ? 'gateway' : 'gateway').'.payscout.com/api/process';
// Do the CURL request ro Payscout Inc 
$request = curl_init($url);
curl_setopt($request, CURLOPT_HEADER, 0);
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($request, CURLOPT_POSTFIELDS, $postString);
curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($request, CURLOPT_SSL_VERIFYHOST, false);
$postResponse = curl_exec($request);
if (curl_error($request)) {
    $msg =  'CURL ERROR: ' . curl_errno($request) . '::' . curl_error($request);
    Logger::addLog($msg, 4);
    die('Gateway returned a malformed response, aborted.');
} elseif ($postResponse)
$response = (array)Tools::jsonDecode($postResponse);
curl_close($request);

$message = "";
$transaction_id = '';
$payment_status = '';
$result_code = '';
$amount = $params['initial_amount'];

if(isset($response['transaction_id']) && trim($response['transaction_id'])!= "") $transaction_id = $response['transaction_id'];
if(isset($response['result_code']) && trim($response['result_code'])!= "") $result_code = $response['result_code'];
if(isset($response['status']) && trim($response['status'])!= "") $payment_status = $response['status'];
if(isset($response['message']) && trim($response['message'])!= "") $message = $response['message'];
if(isset($response['raw_message']) && trim($response['raw_message'])!= "") $message = $response['raw_message'];
if (isset($response['result_code']) && $response['result_code'] != '00'){
    Logger::addLog($message, 4);
    die($message);
}

$payment_method = 'Payscout Inc (Credit Card)';
switch ($result_code) // Response code
{
    case '00': // Payment accepted
    $response['card_number'] = Tools::getValue('x_card_num');
    $response['card_type'] = 'N/A';
    $response['owner_name'] = Tools::safeOutput($customer->firstname.' '.$customer->lastname);
    $payscoutinc->setTransactionDetail($response);
    $payscoutinc->validateOrder($cart->id, Configuration::get('PS_OS_PAYMENT'),(float)$amount,$payment_method, $message, null, null, false, $customer->secure_key);
    break ;
    default:
    $error_message = $message;
    $checkout_type = Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order';
    $url = _PS_VERSION_ >= '1.5' ? 'index.php?controller='.$checkout_type.'&' : $checkout_type.'.php?';
    $url .= 'step=3&cgv=1&incerror=1&message='.$error_message;

if (!isset($_SERVER['HTTP_REFERER']) || strstr($_SERVER['HTTP_REFERER'], 'order'))
    Tools::redirect($url);
else if (strstr($_SERVER['HTTP_REFERER'], '?'))
    Tools::redirect($_SERVER['HTTP_REFERER'].'&incerror=1&message='.$error_message, '');
else
    Tools::redirect($_SERVER['HTTP_REFERER'].'?incerror=1&message='.$error_message, '');
    exit;
}

$url = 'index.php?controller=order-confirmation&';
if (_PS_VERSION_ < '1.5')
    $url = 'order-confirmation.php?';
$auth_order = new Order($payscoutinc->currentOrder);
Tools::redirect($url.'id_module='.(int)$payscoutinc->id.'&id_cart='.(int)$cart->id.'&key='.$auth_order->secure_key);