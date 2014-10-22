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

{* uhupage v4.16.7 *}

{if $page_name == "index"}
<!-- MODULE Block uhu_slider -->
<div id="uhu_gd_9503" class="col-xs-12 col-md-{$totalgrid|escape:'htmlall':'UTF-8'}">
	<div class="block_content">
		<ul id="uhu_gd_9503_sider" class="cycle-slideshow" data-cycle-slides="li" 
			data-cycle-fx=scrollHorz
			data-cycle-timeout="{$slider_time|escape:'htmlall':'UTF-8'}"
			data-cycle-prev=".cycle-prev"
			data-cycle-next=".cycle-next"
			>
		{section name=loop loop=$slider_number} 
		
			{if isset($slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_show) AND $slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_show == 'true'}

				<li class="slide{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}">
					<img class="img-responsive" src="{$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_image}"  />
					{if {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_title}}
					<h1 class="sliding-title{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}" style="{if {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_title_font}}font: {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_title_font};{/if}">
						{$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_title}
					</h1>
					{/if}					
					
					{if isset($slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_text)}
					<p class="sliding-text{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}" style="{if {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_text_font}}font: {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_text_font};{/if}">
						{$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_text}
					</p>
					{/if}

					{if {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_link}}
					<span class="sliding-link{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}" style="{if {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_link_font}}font: {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_link_font};{/if}">
						{if {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_url}}<a href="{$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_url}">{/if}
						{$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_link|stripslashes}
						{if {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_url}}</a>{/if}
					</span>
					{/if}

					{if {$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_logo}}
					<img class="img-responsive logo sliding-logo{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}" src="{$imgurl|escape:'htmlall':'UTF-8'}{$slider{$smarty.section.loop.index|escape:'htmlall':'UTF-8'}_logo}"  />
					{/if}
					
					
					{if isset($products) AND $products AND $smarty.section.loop.index==2}
						<dl class="prd_content col-xs-{$productgrid|escape:'htmlall':'UTF-8'} col-sm-{$productgrid|escape:'htmlall':'UTF-8'} col-md-{$productgrid|escape:'htmlall':'UTF-8'}" style="{if {$position_newproduct_top|escape:'htmlall':'UTF-8'}}top: {$position_newproduct_top|escape:'htmlall':'UTF-8'};{/if} {if {$position_newproduct_left|escape:'htmlall':'UTF-8'}}left: {$position_newproduct_left|escape:'htmlall':'UTF-8'};{/if}">
						{foreach from=$products item=product name=myLoop}
							<dd class="col-xs-{$pgrid|escape:'htmlall':'UTF-8'} col-sm-{$pgrid|escape:'htmlall':'UTF-8'} col-md-{$pgrid|escape:'htmlall':'UTF-8'} sliding_product_{$smarty.foreach.myLoop.iteration|escape:'htmlall':'UTF-8'} {if $smarty.foreach.myLoop.iteration%{$pline|escape:'htmlall':'UTF-8'} == 1}first_item_of_line{/if}">
								<a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|escape:'htmlall':'UTF-8'}" class="product_image">
									<img class="img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html'}" />
									{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<span class="label"><i class="icon-{$awesome|escape:'htmlall':'UTF-8'}"></i><span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></span>{/if}								
								</a>
							</dd>
						{/foreach}
						</dl>
					{/if}
				</li>
			{/if}
			
		{/section}
		</ul>
		<div id="progress"></div>
		<div class="bx-control">
			<span class="cycle-prev"><i class="icon-{$awesome_prev|escape:'htmlall':'UTF-8'}"></i></span>
			<span class="cycle-next"><i class="icon-{$awesome_next|escape:'htmlall':'UTF-8'}"></i></span>
		</div>
	</div>
</div>
<script type="text/javascript">
    slideshow = $( '.cycle-slideshow' );
	slideshow.on( 'cycle-initialized cycle-before', function( e, opts ) {
		$(this).find('.sliding-title0').css({ display:'none', top:'{$slider0_title_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider0_title_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });				
		$(this).find('.sliding-title1').css({ display:'none', top:'{$slider1_title_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider1_title_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		$(this).find('.sliding-title2').css({ display:'none', top:'{$slider2_title_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider2_title_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		
		$(this).find('.sliding-text0').css({ display:'none', top:'{$slider0_text_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider0_text_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		$(this).find('.sliding-text1').css({ display:'none', top:'{$slider1_text_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider1_text_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		$(this).find('.sliding-text2').css({ display:'none', top:'{$slider2_text_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider2_text_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });

		$(this).find('.sliding-logo0').css({ display:'none', top:'{$slider0_logo_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider0_logo_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		$(this).find('.sliding-logo1').css({ display:'none', top:'{$slider1_logo_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider1_logo_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		$(this).find('.sliding-logo2').css({ display:'none', top:'{$slider2_logo_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider2_logo_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		
		$(this).find('.sliding-link0').css({ display:'none', top:'{$slider0_link_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider0_link_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		$(this).find('.sliding-link1').css({ display:'none', top:'{$slider1_link_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider1_link_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });
		$(this).find('.sliding-link2').css({ display:'none', top:'{$slider2_link_topbefore|escape:'htmlall':'UTF-8'}', left:'{$slider2_link_leftbefore|escape:'htmlall':'UTF-8'}', opacity:0 });

		var perline = {$pline|escape:'htmlall':'UTF-8'};
		if (perline=='4')
		{
			var dd = {$dd_adjust|escape:'htmlall':'UTF-8'};
			var left_d1_0 = 0;
			var top_d1_0 = 0;
			var left_d2_0 = dd + $('.prd_content dd').width();
			var top_d2_0 = 0;
			var left_d3_0 = 2 * (dd + $('.prd_content dd').width());
			var top_d3_0 = 0;
			var left_d4_0 = 3 * (dd + $('.prd_content dd').width());
			var top_d4_0 = 0;

			dd = $('.prd_content dd').width();
			var left_d1_1 = left_d1_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var top_d1_1 = top_d1_0 + Math.floor( Math.random() * 2  * dd ) - dd;

			var left_d2_1 = left_d2_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var top_d2_1 = top_d2_0 + Math.floor( Math.random() * 2  * dd ) - dd;

			var left_d3_1 = left_d3_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var top_d3_1 = top_d3_0 + Math.floor( Math.random() * 2  * dd ) - dd;

			var left_d4_1 = left_d4_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var top_d4_1 = top_d4_0 + Math.floor( Math.random() * 2  * dd ) - dd;
		}
		else
		{
			var dd = slideshow.height() / {$dd_adjust|escape:'htmlall':'UTF-8'};
			var left_d1_0 = 0;
			var top_d1_0 = 0;
			var left_d2_0 = dd;
			var top_d2_0 = 0;
			var left_d3_0 = 0;
			var top_d3_0 = dd;
			var left_d4_0 = dd;
			var top_d4_0 = dd;

			var left_d1_1 = left_d1_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var top_d1_1 = top_d1_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var left_d2_1 = left_d2_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var top_d2_1 = top_d2_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var left_d3_1 = left_d3_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var top_d3_1 = top_d3_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var left_d4_1 = left_d4_0 + Math.floor( Math.random() * 2  * dd ) - dd;
			var top_d4_1 = top_d4_0 + Math.floor( Math.random() * 2  * dd ) - dd;
		}
		
			
		$(this).find('.sliding_product_1').css({ display:'none', left:left_d1_1+'px', top:top_d1_1+'px', opacity:0}); 
		$(this).find('.sliding_product_2').css({ display:'none', left:left_d2_1+'px', top:top_d2_1+'px', opacity:0}); 
		$(this).find('.sliding_product_3').css({ display:'none', left:left_d3_1+'px', top:top_d3_1+'px', opacity:0}); 
		$(this).find('.sliding_product_4').css({ display:'none', left:left_d4_1+'px', top:top_d4_1+'px', opacity:0}); 
		
		
	});
	slideshow.on( 'cycle-initialized cycle-after', function( e, opts ) {
		$(this).find('.sliding-title0').css({ display: 'block' }).delay(50).animate({ top:'{$slider0_title_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider0_title_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });
		$(this).find('.sliding-title1').css({ display: 'block' }).delay(50).animate({ top:'{$slider1_title_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider1_title_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });
		$(this).find('.sliding-title2').css({ display: 'block' }).delay(50).animate({ top:'{$slider2_title_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider2_title_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });

		$(this).find('.sliding-text0').css({ display: 'block' }).delay(50).animate({ top:'{$slider0_text_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider0_text_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });
		$(this).find('.sliding-text1').css({ display: 'block' }).delay(50).animate({ top:'{$slider1_text_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider1_text_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });
		$(this).find('.sliding-text2').css({ display: 'block' }).delay(50).animate({ top:'{$slider2_text_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider2_text_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });

		$(this).find('.sliding-logo0').css({ display: 'block' }).delay(50).animate({ top:'{$slider0_logo_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider0_logo_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });
		$(this).find('.sliding-logo1').css({ display: 'block' }).delay(50).animate({ top:'{$slider1_logo_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider1_logo_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });
		$(this).find('.sliding-logo2').css({ display: 'block' }).delay(50).animate({ top:'{$slider2_logo_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider2_logo_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });

		$(this).find('.sliding-link0').css({ display: 'block' }).delay(50).animate({ top:'{$slider0_link_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider0_link_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });
		$(this).find('.sliding-link1').css({ display: 'block' }).delay(50).animate({ top:'{$slider1_link_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider1_link_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });
		$(this).find('.sliding-link2').css({ display: 'block' }).delay(50).animate({ top:'{$slider2_link_topafter|escape:'htmlall':'UTF-8'}', left:'{$slider2_link_leftafter|escape:'htmlall':'UTF-8'}', opacity: 1 }, { duration: 'slow', easing: "easeOutBack" });

		var perline = {$pline|escape:'htmlall':'UTF-8'};
		if (perline=='4')
		{
			var dd = {$dd_adjust|escape:'htmlall':'UTF-8'};
			var left_d1_0 = 0;
			var top_d1_0 = 0;
			var left_d2_0 = dd + $('.prd_content dd').width();
			var top_d2_0 = 0;
			var left_d3_0 = 2 * (dd + $('.prd_content dd').width());
			var top_d3_0 = 0;
			var left_d4_0 = 3 * (dd + $('.prd_content dd').width());
			var top_d4_0 = 0;
		}
		else
		{
			var dd = slideshow.height() / {$dd_adjust|escape:'htmlall':'UTF-8'};
			var left_d1_0 = 0;
			var top_d1_0 = 0;
			var left_d2_0 = dd;
			var top_d2_0 = 0;
			var left_d3_0 = 0;
			var top_d3_0 = dd;
			var left_d4_0 = dd;
			var top_d4_0 = dd;
		}
			
		$(this).find('.sliding_product_1').css({ display:'block'}).delay(50).animate({ left:left_d1_0+'px', top:top_d1_0+'px', opacity:1}, { duration: 'slow', easing: "jswing" });
		$(this).find('.sliding_product_2').css({ display:'block'}).delay(50).animate({ left:left_d2_0+'px', top:top_d2_0+'px', opacity:1}, { duration: 'slow', easing: "jswing" });
		$(this).find('.sliding_product_3').css({ display:'block'}).delay(50).animate({ left:left_d3_0+'px', top:top_d3_0+'px', opacity:1}, { duration: 'slow', easing: "jswing" });
		$(this).find('.sliding_product_4').css({ display:'block'}).delay(50).animate({ left:left_d4_0+'px', top:top_d4_0+'px', opacity:1}, { duration: 'slow', easing: "jswing" });

	});
</script>
<!-- /MODULE Block uhu_slider -->
{/if}