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

<div id="uhu_qt_reassure" class="col-xs-12 col-sm-{$totalgrid|escape:'htmlall':'UTF-8'}">
	<ul>
		{section name=loop loop=$reassure_number} 
		<li class="col-xs-12 col-sm-{$itemgrid|escape:'htmlall':'UTF-8'}">
			<a href="{$reassure_link_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}">
				{if $icon}
				<i class="{$reassure_image_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}"></i><span class="text">{$reassure_text_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}</span>
				{else}
				<img src="{$imgurl|escape:'htmlall':'UTF-8'}{$reassure_image_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}" alt="" /><span class="text">{$reassure_text_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}</span>
				{/if}
			</a>
		</li>
		{/section}
	</ul>
</div>
