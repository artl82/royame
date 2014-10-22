{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{* uhupage v4.16.04 *}

<!-- Block uhu_myaccount module -->
<div class="footer-block col-xs-12 col-sm-{$totalgrid|escape:'htmlall':'UTF-8'} myaccount">
	<h4 class="title_block">{l s='My account' mod='uhu_myaccount'}</h4>
	<div class="block_content">
		<ul class="bullet">
			<li><a href="{$link->getPageLink('my-account', true)|escape:'html'}" title="{l s='Manage my customer account' mod='uhu_myaccount'}" rel="nofollow">{l s='My account' mod='uhu_myaccount'}</a></li>
			<li><a href="{$link->getPageLink('history', true)|escape:'html'}" title="{l s='My orders' mod='uhu_myaccount'}" rel="nofollow">{l s='My orders' mod='uhu_myaccount'}</a></li>
			{if $returnAllowed}<li><a href="{$link->getPageLink('order-follow', true)|escape:'html'}" title="{l s='My returns' mod='uhu_myaccount'}" rel="nofollow">{l s='My merchandise returns' mod='uhu_myaccount'}</a></li>{/if}
			<li><a href="{$link->getPageLink('order-slip', true)|escape:'html'}" title="{l s='My credit slips' mod='uhu_myaccount'}" rel="nofollow">{l s='My credit slips' mod='uhu_myaccount'}</a></li>
			<li><a href="{$link->getPageLink('addresses', true)|escape:'html'}" title="{l s='My addresses' mod='uhu_myaccount'}" rel="nofollow">{l s='My addresses' mod='uhu_myaccount'}</a></li>
			<li><a href="{$link->getPageLink('identity', true)|escape:'html'}" title="{l s='Manage my personal information' mod='uhu_myaccount'}" rel="nofollow">{l s='My personal info' mod='uhu_myaccount'}</a></li>
			{if $voucherAllowed}<li><a href="{$link->getPageLink('discount', true)|escape:'html'}" title="{l s='My vouchers' mod='uhu_myaccount'}" rel="nofollow">{l s='My vouchers' mod='uhu_myaccount'}</a></li>{/if}
			{$HOOK_BLOCK_MY_ACCOUNT|escape:'html'}
			{if $is_logged}<li><a href="{$link->getPageLink('index')|escape:'html'}?mylogout" title="{l s='Sign out' mod='uhu_myaccount'}" rel="nofollow">{l s='Sign out' mod='uhu_myaccount'}</a></li>{/if}
		</ul>
	</div>
</div>
<!-- /Block uhu_myaccount module -->
