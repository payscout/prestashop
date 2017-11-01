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

if (!defined('_PS_VERSION_'))
exit;
// object module ($this) available
function upgrade_module_1_4_8($object)
{
$upgrade_version = '1.4.8';
$object->upgrade_detail[$upgrade_version] = array();
// Variables name for client id, client username, client password and client token have now the currency
if(Configuration::get('PAYSCOUT_INC_CLIENT_USERNAME') && Configuration::get('PAYSCOUT_INC_CLIENT_PASSWORD') && Configuration::get('PAYSCOUT_INC_CLIENT_TOKEN'))
{
$currencies = Currency::getCurrencies(false, true);
foreach ($currencies as $currency)
{
if(in_array($currency['iso_code'], $object->inc_available_currencies))
{
$configuration_client_username_name = 'PAYSCOUT_INC_CLIENT_USERNAME'.$currency['iso_code'];
$configuration_client_password_name = 'PAYSCOUT_INC_CLIENT_PASSWORD'.$currency['iso_code'];
$configuration_client_token_name = 'PAYSCOUT_INC_CLIENT_TOKEN'.$currency['iso_code'];

Configuration::updateValue($configuration_client_username_name, Configuration::get('PAYSCOUT_INC_CLIENT_USERNAME'));
Configuration::updateValue($configuration_client_password_name, Configuration::get('PAYSCOUT_INC_CLIENT_PASSWORD'));
Configuration::updateValue($configuration_client_token_name, Configuration::get('PAYSCOUT_INC_CLIENT_TOKEN'));
}
}
}

Configuration::deleteByName('PAYSCOUT_INC_CLIENT_USERNAME');
Configuration::deleteByName('PAYSCOUT_INC_CLIENT_PASSWORD');
Configuration::deleteByName('PAYSCOUT_INC_CLIENT_TOKEN');
Configuration::updateValue('PAYSCOUT_INC', $upgrade_version);
return true;
}