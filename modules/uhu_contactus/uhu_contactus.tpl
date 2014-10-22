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

{* uhupage v4.16.4 *}

<!-- MODULE uhu_contactus -->
<div id="uhu_qt_contactus" class="footer-block col-xs-12 col-sm-{$totalgrid|escape:'htmlall':'UTF-8'}">
	{if $title == 'yes'}<p class="title_block">{l s='Contact us' mod='uhu_contactus'}</p>{/if}
	{if $logo <> ''}<p class="logo"><img class="img-responsive" src="{$imgurl|escape:'htmlall':'UTF-8'}{$logo|escape:'htmlall':'UTF-8'}" alt="" /></p>{/if}
	<ul>
		{if $company != ''}<li><i class="icon-building"></i>{$company|escape:'htmlall':'UTF-8'}</li>{/if}
		{if $address != ''}<li><i class="icon-map-marker"></i>{$address|escape:'htmlall':'UTF-8'}</li>{/if}
		{if $phone != ''}<li><i class="icon-phone"></i>{$phone|escape:'htmlall':'UTF-8'}</li>{/if}
		{if $email != ''}<li><i class="icon-envelope-alt"></i>{mailto address=$email|escape:'htmlall':'UTF-8' encode="hex"}</li>{/if}
		<li style="margin:0;text-indent:-9999px;float:right; width:1px;">designed by uhupage</li>
	</ul>
</div>
<!-- /MODULE uhu_contactus -->
