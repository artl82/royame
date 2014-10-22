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

{* uhupage v4.16.07 *}
{if $page_name == "index"}
<!-- MODULE Block uhu_gj_9511 -->
<div id="uhu_gj_9511" class="col-xs-12 col-sm-{$totalgrid|escape:'htmlall':'UTF-8'} col-md-{$totalgrid|escape:'htmlall':'UTF-8'}">
	<div class="block_content">
		<ul>
		{section name=loop loop=$adv_number} 
			<li class="col-xs-12 col-sm-{$adgrid|escape:'htmlall':'UTF-8'} col-md-{$adgrid|escape:'htmlall':'UTF-8'} ad{$smarty.section.loop.index|escape:'htmlall':'UTF-8'} {$zoom|escape:'htmlall':'UTF-8'}">
				<div class="image-container">
					<a href="{$adv_link_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}">
						<img class="img-responsive" src="{$adv_image_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}"  />
					</a>
					{if $zoom == 'rollimg' || $zoom == 'circleimg' || $zoom == 'upimg' || $zoom == 'downimg' || $zoom == 'rightimg' || $zoom == 'leftimg'}
						<a class="img_roll" href="{$adv_link_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}}" style="background-image:url({$adv_image_{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}})"></a>
					{/if}
				</div>	
			</li>
		{/section}	
		</ul>
	</div>	
</div>
<!-- /MODULE Block uhu_gj_9511 -->
{/if}