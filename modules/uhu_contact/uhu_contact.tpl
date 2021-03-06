{*
* 2007-2013 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{* uhupage v4.16.4 *}

<!-- MODULE Block uhu_contact -->
<div id="contact-link">
	<a href="{$link->getPageLink('contact', true)|escape:'html':'UTF-8'}" title="{l s='Contact Us' mod='uhu_contact'}">{l s='Contact Us' mod='uhu_contact'}</a>
</div>
<span class="shop-phone">
	{if $shop_telnumber <> ''}
		<i class="icon-phone"></i><h5 class="telnumber">{$shop_telnumber|escape:'htmlall':'UTF-8'}</h5>
	{/if}
	{if $shop_email <> ''}
		<i class="icon-envelope"></i><h5 class="email">{$shop_email|escape:'htmlall':'UTF-8'}</h5>
	{/if}
	{if $logged}
		<i class="icon-signin"></i><a href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html'}" title="{l s='Log me out' mod='uhu_contact'}"><h5>{l s='Log out' mod='uhu_contact'}</h5></a>
	{else}
		<i class="icon-signout"></i><a href="{$link->getPageLink('my-account', true)|escape:'html'}"><h5>{l s='Log in' mod='uhu_contact'}</p></h5></a>
	{/if}	
</span>
<!-- /MODULE Block uhu_contact -->
