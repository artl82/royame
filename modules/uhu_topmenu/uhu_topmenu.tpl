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

{* uhupage v4.16.6 *}

{if $MENU != ''}
	</div>

	<!-- Menu -->
	<div class="menu">
		<ul class="nav_item umenu">
			{if $showhome == 'true'}
			<li class="home">
				<a href="{$base_dir|escape:'htmlall':'UTF-8'}" class="roll"><span data-title="{l s='Home' mod='uhu_topmenu'}">{l s='Home' mod='uhu_topmenu'}</span></a>
			</li>
			{/if}
			{$MENU|replace:"Categories":"{l s='Categories' mod='uhu_topmenu'}"|replace:"Products":"{l s='Products' mod='uhu_topmenu'}"|replace:"Brands":"{l s='Brands' mod='uhu_topmenu'}"|replace:"About":"{l s='About' mod='uhu_topmenu'}"|replace:"Links":"{l s='Links' mod='uhu_topmenu'}"}
		</ul>
		<ul class="mobile tree dhtml">
			{$MENU_MOBILE|replace:"Categories":"{l s='Categories' mod='uhu_topmenu'}"}
		</ul>
		{* Javascript moved here to fix bug #PSCFI-151 *}
		<script type="text/javascript">
		// <![CDATA[
			// we hide the tree only if JavaScript is activated
			$('div#categories_block_left ul.dhtml').hide();
		// ]]>
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('div.nav_pop').css({
					'visibility':'hidden',
					'height':'0px'
				});
				
				$('.nav_item > li').mouseover(function(){
					var openMenu= $(this).children('div.nav_pop');
					$(this).children('div.nav_pop').css({
						'visibility':'visible',
						'height':'auto'
					});
				});
				
				$('.nav_item > li').mouseleave(function(){
					$('div.nav_pop').css({
						'visibility':'hidden',
						'height':'0px'

					})
				});
			});
		</script>
	<!--/ Menu -->
{/if}