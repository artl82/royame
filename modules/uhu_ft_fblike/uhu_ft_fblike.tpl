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

{* uhupage v4.16.5 *}

<div id="uhu_ft_fblike" class="col-xs-12 col-sm-{$totalgrid|escape:'htmlall':'UTF-8'}">
	<h4 class="title_block">{l s='Facebook' mod="uhu_ft_fblike"}</h4>
	<div class="fb_info">
		<a href="{$myPage|escape:'htmlall':'UTF-8'}" target="_blank" class="fb_avatar"><img src="{$myLogo|escape:'htmlall':'UTF-8'}" alt="" /></a>
		<a href="{$myPage|escape:'htmlall':'UTF-8'}" target="_blank" class="fb_myname">{$myName|escape:'htmlall':'UTF-8'}</a>
		<a href="{$myPage|escape:'htmlall':'UTF-8'}" target="_blank" class="likeButton"><i class="icon-heart"></i>{l s='Like' mod='uhu_ft_fblike'}</a>
	</div>
	<div class="fb_likes">
		{$myLikes|escape:'htmlall':'UTF-8'} {l s='people like' mod='uhu_ft_fblike'} <a href="{$myPage|escape:'htmlall':'UTF-8'}" target="_blank">{$myName|escape:'htmlall':'UTF-8'}</a>.
	</div>
	<div class="fb_fans">
		<ul class="fb_followers">
			{section name=loop loop=$fans_number} 
			<li class="{if $perline>0}col-xs-12 col-sm-{12/$perline|escape:'htmlall':'UTF-8'}{/if} {if $smarty.section.loop.index%$perline == 0}first_item_of_line{/if}">
			{if $fans_link_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'} != ""}
				<a href="{$fans_link_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}" title="{$fans_name_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}" target="_blank"><img class="img-responsive" src="{$fans_image_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}" alt="" /></a>
			{else}
				<span title="{$fans_name_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}"><img class="img-responsive" src="{$fans_image_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}" alt="" /></span>
			{/if}
			<div class="fb_name">{$fans_name_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}</div>
			</li>
			{/section}
		</ul>
		{$error_message|escape:'htmlall':'UTF-8'}
	</div>
</div>
