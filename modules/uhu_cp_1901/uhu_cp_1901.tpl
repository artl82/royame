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

<!-- MODULE Block uhu_cp_1901 -->
{if $waterfall == 'yes'}
<script type="text/javascript" src="{$module_dir|escape:'htmlall':'UTF-8'}js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="{$module_dir|escape:'htmlall':'UTF-8'}js/imagesloaded.pkgd.js"></script>
<script type="text/javascript">
	var $container = $('.block_masonry');
	$container.imagesLoaded( function() {
		$container.masonry({
			itemSelector: '.item_masonry'
		});
	});
</script>
{/if}
<div id="uhu_cp_1901" class="col-xs-12 col-sm-{$totalgrid|escape:'htmlall':'UTF-8'} col-md-{$totalgrid|escape:'htmlall':'UTF-8'} products_block">
	{if $titlepos <> 'li'}
	<h4 class="title_block"><i class="{$title_awesome|escape:'htmlall':'UTF-8'}"></i><span>{l s='Top sellers' mod='uhu_cp_1901'}<span></h4>
	{/if}
	{if $products !== false}
		<div class="block_content block_masonry">
			<ul style="row-fluid">
				{if $titlepos == 'li'}
				<li class="item_masonry title_block col-xs-12 col-sm-{$productgrid|escape:'htmlall':'UTF-8'} col-md-{$productgrid|escape:'htmlall':'UTF-8'} first_item_of_line">
					<div class="product-container">
						<img class="img-responsive" src="{$titlebkimg|escape:'htmlall':'UTF-8'}"  />
						<i class="{$title_awesome|escape:'htmlall':'UTF-8'}"></i>
						<span>{l s='Top sellers' mod='uhu_cp_1901'}</span>
					</div>
				</li>
				{/if}
			{foreach from=$products item=product name=myLoop}
				{if $titlepos == 'li'}
				<li class="item_masonry ajax_block_product col-xs-12 col-sm-{$productgrid|escape:'htmlall':'UTF-8'} col-md-{$productgrid|escape:'htmlall':'UTF-8'} {if $smarty.foreach.myLoop.iteration % $perline == 0}first_item_of_line{/if} {$csstype|escape:'htmlall':'UTF-8'}">
				{else}
				<li class="item_masonry ajax_block_product col-xs-12 col-sm-{$productgrid|escape:'htmlall':'UTF-8'} col-md-{$productgrid|escape:'htmlall':'UTF-8'} {if $smarty.foreach.myLoop.iteration % $perline == 1}first_item_of_line{/if} {$csstype|escape:'htmlall':'UTF-8'}">
				{/if}
					<div class="product-container">
						<div class="product-image-container">
							<a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|escape:'htmlall':'UTF-8'}" class="col-xs-{if $smarty.foreach.myLoop.iteration == 1 && $firstimggrid > 0}{$firstimggrid|escape:'htmlall':'UTF-8'}{else}{$imggrid|escape:'htmlall':'UTF-8'}{/if} col-md-{if $smarty.foreach.myLoop.iteration == 1 && $firstimggrid > 0}{$firstimggrid|escape:'htmlall':'UTF-8'}{else}{$imggrid|escape:'htmlall':'UTF-8'}{/if} product_image">
								<img class="img-responsive" src="{$link->getImageLink($product.link_rewrite|escape:'htmlall':'UTF-8', $product.id_image|escape:'htmlall':'UTF-8', 'large_default')}" />
								<span class="label"><i class="icon-{$awesome|escape:'htmlall':'UTF-8'}"></i><span>{$smarty.foreach.myLoop.iteration|escape:'htmlall':'UTF-8'}</span></span>
							</a>
							<div class="quick-view">
								<h5 class="s_title_block"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|truncate:32:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
								{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
									{if ($product.allow_oosp || $product.quantity > 0)}
										{if isset($static_token)}
											<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_cp_1901'}" data-id-product="{$product.id_product|intval}">
												<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_cp_1901'}</i>
											</a>
										{else}
											<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_cp_1901'}" data-id-product="{$product.id_product|intval}">
												<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_cp_1901'}</i>
											</a>
										{/if}						
									{else}
										<span class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default disabled">
											<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_cp_1901'}</i>
										</span>
									{/if}
								{/if}
							</div>
						</div>
						<div class="info col-xs-{if $smarty.foreach.myLoop.iteration == 1 && $firstimggrid > 0}{$firstinfogrid|escape:'htmlall':'UTF-8'}{else}{$infogrid|escape:'htmlall':'UTF-8'}{/if} col-md-{if $smarty.foreach.myLoop.iteration == 1 && $firstimggrid > 0}{$firstinfogrid|escape:'htmlall':'UTF-8'}{else}{$infogrid|escape:'htmlall':'UTF-8'}{/if}">
							<h5 class="s_title_block"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|truncate:32:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
							<div class="product_desc">{$product.description_short|strip_tags|escape:'htmlall':'UTF-8'}</div>

							{if $product.comments && $showcomment == 'yes'}
								{foreach from=$product.comments item=comment}
									{if $comment.content}
									<div class="comment clearfix">
										<div class="comment_author">
											<div class="star_content clearfix">
											{section name="i" start=0 loop=5 step=1}
												{if $comment.grade le $smarty.section.i.index}
													<div class="star"></div>
												{else}
													<div class="star star_on"></div>
												{/if}
											{/section}
											</div>
											<div class="comment_author_infos">
												<strong>{$comment.customer_name|escape:'html':'UTF-8'}</strong><br/>
												<em>{dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}</em>
											</div>
										</div>
										<div class="comment_details">
											<h5 class="s_title_block">{$comment.title|escape:'htmlall':'UTF-8'}</h5>
											<p>{$comment.content|escape:'html':'UTF-8'|nl2br}</p>
										</div>
									</div>
									{/if}
								{/foreach}
							{/if}
							
							<div>
								{if $showprice <> 'no'}
									{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<p class="price_container"><span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></p>{else}<div style="height:21px;"></div>{/if}
								{/if}

								<a class="button" href="{$product.link|escape:'htmlall':'UTF-8'}" title="{l s='View' mod='uhu_cp_1901'}">{l s='View' mod='uhu_cp_1901'}</a>

								{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
									{if ($product.allow_oosp || $product.quantity > 0)}
										{if isset($static_token)}
											<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_cp_1901'}" data-id-product="{$product.id_product|intval}">
												<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_cp_1901'}</i>
											</a>
										{else}
											<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_cp_1901'}" data-id-product="{$product.id_product|intval}">
												<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_cp_1901'}</i>
											</a>
										{/if}						
									{else}
										<span class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default disabled">
											<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_cp_1901'}</i>
										</span>
									{/if}
								{/if}
							</div>
						</div>
					</div>
				</li>
			{/foreach}
			
				{if $adverimg <> '' && $advergrid <> ''}
				<li class="item_masonry title_block col-xs-12 col-sm-{$advergrid|escape:'htmlall':'UTF-8'} col-md-{$advergrid|escape:'htmlall':'UTF-8'} last_item_of_line">
					<a href="{$adverlink|escape:'htmlall':'UTF-8'}">
					<img class="img-responsive" src="{$adverimg|escape:'htmlall':'UTF-8'}"  />
					</a>
				</li>
				{/if}
			
			
			</ul>
		</div>
	{else}
		<p>{l s='No best sellers' mod='uhu_cp_1901'}</p>
	{/if}
</div>	
<!-- /MODULE Block uhu_cp_1901 -->
