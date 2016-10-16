<div class="payscoutinc-wrapper">
<img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/logo_payscout.png" alt="Payscout Inc" border="0" />
<p class="payscoutinc-intro">{l s='Start accepting payments through your PrestaShop store with Payscout Inc, the pioneering provider of ecommerce payment services.  Payscout Inc makes accepting payments safe, easy and affordable.' mod='payscoutinc'}</p>
<div class="payscoutinc-content">
	<div class="payscoutinc-leftCol">
		<h3>{l s='Why Choose Payscout?' mod='payscoutinc'}</h3>
		<ul>
			<li>{l s='Leading payment gateway since 2008 with 200,000+ active merchants' mod='payscoutinc'}</li>
			<li>{l s='Multiple currency acceptance' mod='payscoutinc'}</li>
			<li>{l s='FREE award-winning customer support via telephone, email and online chat' mod='payscoutinc'}</li>
			<li>{l s='FREE Virtual Terminal for mail order/telephone order transactions' mod='payscoutinc'}</li>
			<li>{l s='No Contracts or long term commitments ' mod='payscoutinc'}</li>			
			<li>{l s='Gateway and merchant account set up available' mod='payscoutinc'}</li>
			<li>{l s='Simple setup process' mod='payscoutinc'}
		</li>
		</ul>
		<ul class="none" style = "display: inline; font-size: 13px;">
			<li><a href="{$module_dir|escape:'htmlall':'UTF-8'}https://www.payscout.com/get-started/" target="_blank" class="payscoutinc-link">{l s='Sign up Now' mod='payscoutinc'}</a></li>
		</ul>
	</div>	
</div>

<form action="{$smarty.server.REQUEST_URI|escape:'htmlall':'UTF-8'}" method="post">
	<fieldset>
		
		{* Determine which currencies are enabled on the store and supported by Payscout Inc & list one credentials section per available currency *}
		{foreach from=$currencies item='currency'}
			{if (in_array($currency.iso_code, $available_currencies))}
            	
				{assign var='configuration_client_id_name' value="PAYSCOUT_INC_CLIENT_ID_"|cat:$currency.iso_code}
				{assign var='configuration_client_username_name' value="PAYSCOUT_INC_CLIENT_USERNAME_"|cat:$currency.iso_code}
                {assign var='configuration_client_password_name' value="PAYSCOUT_INC_CLIENT_PASSWORD_"|cat:$currency.iso_code}
                {assign var='configuration_client_token_name' value="PAYSCOUT_INC_CLIENT_TOKEN_"|cat:$currency.iso_code}
                <!--{${$configuration_client_id_name}} -->            
				<table>
					<tr>
						<td>
							<p>{l s='Credentials for' mod='payscoutinc'}<b> {$currency.iso_code}</b> {l s='currency' mod='payscoutinc'}</p>
							<label for="payscoutinc_clinet_id">{l s='Client ID' mod='payscoutinc'}:</label>
							<div class="margin-form" style="margin-bottom: 0px;"><input type="text" size="20" id="payscoutinc_client_id_{$currency.iso_code}" name="payscoutinc_client_id_{$currency.iso_code}" value="{${$configuration_client_id_name|escape:'htmlall':'UTF-8'}}" /></div>
                            
							<label for="payscoutinc_client_username">{l s='Username' mod='payscoutinc'}:</label>
							<div class="margin-form" style="margin-bottom: 0px;"><input type="text" size="20" id="payscoutinc_client_username_{$currency.iso_code}" name="payscoutinc_client_username_{$currency.iso_code}" value="{${$configuration_client_username_name|escape:'htmlall':'UTF-8'}}" /></div>
                            
                            <label for="payscoutinc_client_password">{l s='Password' mod='payscoutinc'}:</label>
							<div class="margin-form" style="margin-bottom: 0px;"><input type="text" size="20" id="payscoutinc_client_password_{$currency.iso_code}" name="payscoutinc_client_password_{$currency.iso_code}" value="{${$configuration_client_password_name|escape:'htmlall':'UTF-8'}}" /></div>
                            
                            <label for="payscoutinc_client_token">{l s='Client Token' mod='payscoutinc'}:</label>
							<div class="margin-form" style="margin-bottom: 0px;"><input type="text" size="20" id="payscoutinc_client_token_{$currency.iso_code}" name="payscoutinc_client_token_{$currency.iso_code}" value="{${$configuration_client_token_name|escape:'htmlall':'UTF-8'}}" /></div>
                            
						</td>
					</tr>
				</table><br />
				<hr size="1" style="background: #BBB; margin: 0; height: 1px;" noshade /><br />
			{/if}
		{/foreach}

		<label for="payscoutinc_mode"><img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/help.png" alt="" /> {l s='Environment:' mod='payscoutinc'}</label>
		<div class="margin-form" id="payscoutinc_mode">
			<input type="radio" name="payscoutinc_mode" value="0" style="vertical-align: middle;" {if !$PAYSCOUT_INC_SANDBOX && !$PAYSCOUT_INC_TEST_MODE}checked="checked"{/if} />
			<span>{l s='Live mode' mod='payscoutinc'}</span><br/>			
			<input type="radio" name="payscoutinc_mode" value="2" style="vertical-align: middle;" {if $PAYSCOUT_INC_SANDBOX}checked="checked"{/if} />
			<span>{l s='Test mode' mod='payscoutinc'}</span><br/>
		</div>
		<label for="payscoutinc_cards">{l s='Cards* :' mod='payscoutinc'}</label>
		<div class="margin-form" id="payscoutinc_cards">
			<input type="checkbox" name="payscoutinc_card_visa" {if $PAYSCOUT_INC_CARD_VISA}checked="checked"{/if} />
				<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/visa.gif" alt="visa" />
			<input type="checkbox" name="payscoutinc_card_mastercard" {if $PAYSCOUT_INC_CARD_MASTERCARD}checked="checked"{/if} />
				<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/mastercard.gif" alt="visa" />
			<input type="checkbox" name="payscoutinc_card_discover" {if $PAYSCOUT_INC_CARD_DISCOVER}checked="checked"{/if} />
				<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/discover.gif" alt="visa" />
			<input type="checkbox" name="payscoutinc_card_ax" {if $PAYSCOUT_INC_CARD_AX}checked="checked"{/if} />
				<img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/ax.gif" alt="visa" />
		</div>

		<label for="payscoutinc_hold_review_os">{l s='Order status:  "Hold for Review" ' mod='payscoutinc'}</label>
		<div class="margin-form">
			<select id="payscoutinc_hold_review_os" name="payscoutinc_hold_review_os">';
				
				{foreach from=$order_states item='os'}
                
                {if ((int)$os.id_order_state == $PAYSCOUT_INC_HOLD_REVIEW_OS)}
					<option value="{$os.id_order_state|intval}" selected="selected">{$os.name|stripslashes}</option>
                {else}       
                    <option value="{$os.id_order_state|intval}">{$os.name|stripslashes}</option>
                {/if}                      
				{/foreach}
			</select>
		</div>
		<br />
		<center>
			<input type="submit" name="submitModule" value="{l s='Update settings' mod='payscoutinc'}" class="button" />
		</center>
		<sub>{l s='* Subject to region' mod='payscoutinc'}</sub>
	</fieldset>
</form>
</div>
