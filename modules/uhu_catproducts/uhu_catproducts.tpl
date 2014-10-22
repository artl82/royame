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

<!-- MODULE Block uhu_catproducts -->
<script type="text/javascript" src="{$content_dir|escape:'htmlall':'UTF-8'}js/jquery/plugins/jquery.idTabs.js"></script>
<div id="uhu_tj_9502" class="col-xs-12 col-sm-{$totalgrid|escape:'htmlall':'UTF-8'} col-md-{$totalgrid|escape:'htmlall':'UTF-8'} products_block">

	<ul id="more_info_tabs" class="nav nav-tabs title_block">
		<li class="col-xs-12 col-sm-3 col-md-3 first active"><a data-toggle="tab" href="#idTab_{$category_number|escape:'htmlall':'UTF-8'}">{l s='New arrivals' mod='uhu_catproducts'}</a></li>
		{section name=cloop loop=$category_number}		
		<li class="col-xs-12 col-sm-3 col-md-3"><a data-toggle="tab" href="#idTab_{$smarty.section.cloop.index|escape:'htmlall':'UTF-8'}">{$title_{$smarty.section.cloop.index|escape:'htmlall':'UTF-8'}}</a></li>
		{/section}
	</ul>

	<div id="more_info_sheets" class="tab-content block_content align_justify">
	
		<ul id="idTab_{$category_number|escape:'htmlall':'UTF-8'}" class="idTab_{$category_number|escape:'htmlall':'UTF-8'} pd col-xs-12 col-sm-{$pdgrid|escape:'htmlall':'UTF-8'} col-md-{$pdgrid|escape:'htmlall':'UTF-8'} row tab-pane active">
			{if $products_new !== false}
			{foreach from=$products_new item=product name=myLoop}
				<li class="ajax_block_product {$csstype|escape:'htmlall':'UTF-8'} {if $smarty.foreach.myLoop.iteration % $nb_items_per_line == 1}first_item_of_line{/if}  col-xs-12 col-sm-{$productgrid|escape:'htmlall':'UTF-8'} col-md-{$productgrid|escape:'htmlall':'UTF-8'}">
					<div class="product-container">
					{if $title_pos=='top'}
						<h5 class="s_title_block"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
					{/if}
						<div class="product-image-container">
							<a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|escape:'htmlall':'UTF-8'}" class="product_image">
								<img class="img-responsive" src="{$link->getImageLink($product.link_rewrite|escape:'htmlall':'UTF-8', $product.id_image|escape:'htmlall':'UTF-8', 'large_default')}" />
								{if isset($product.new) && $product.new == 1}<span class="label"><i class="icon-{$ptype|escape:'htmlall':'UTF-8'}"></i><span>{l s='New' mod='uhu_catproducts'}</span></span>{/if}
							</a>
							<div class="quick-view">
								{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
									{if ($product.allow_oosp || $product.quantity > 0)}
										{if isset($static_token)}
											<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_catproducts'}" data-id-product="{$product.id_product|intval}">
												<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
											</a>
										{else}
											<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_catproducts'}" data-id-product="{$product.id_product|intval}">
												<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
											</a>
										{/if}						
									{else}
										<span class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default disabled">
											<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
										</span>
									{/if}
								{/if}
								<h5 class="s_title_block"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|truncate:32:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
							</div>
						</div>
						<div class="info">
						{if $title_pos=='bottom'}
							<h5 class="s_title_block"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
						{/if}
							<div class="product_desc">{$product.description_short|strip_tags|truncate:65:'...'|escape:'htmlall':'UTF-8'}</div>

							{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<p class="price_container"><span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></p>{else}<div style="height:21px;"></div>{/if}
							<a class="button" href="{$product.link|escape:'htmlall':'UTF-8'}" title="{l s='View' mod='uhu_catproducts'}">{l s='View' mod='uhu_catproducts'}</a>

							{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
								{if ($product.allow_oosp || $product.quantity > 0)}
									{if isset($static_token)}
										<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_catproducts'}" data-id-product="{$product.id_product|intval}">
											<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
										</a>
									{else}
										<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_catproducts'}" data-id-product="{$product.id_product|intval}">
											<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
										</a>
									{/if}						
								{else}
									<span class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default disabled">
										<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
									</span>
								{/if}
							{/if}
						</div>
					</div>
				</li>
			{/foreach}
			{else}
				<p>{l s='No new products at this time' mod='uhu_catproducts'}</p>
			{/if}
		</ul>
	
		{section name=cloop loop=$category_number}	
			<ul id="idTab_{$smarty.section.cloop.index|escape:'htmlall':'UTF-8'}" class="idTab_{$smarty.section.cloop.index|escape:'htmlall':'UTF-8'} pd col-xs-12 col-sm-{$pdgrid|escape:'htmlall':'UTF-8'} col-md-{$pdgrid|escape:'htmlall':'UTF-8'} row tab-pane">
			{if isset($products_{$smarty.section.cloop.index|escape:'htmlall':'UTF-8'}) AND $products_{$smarty.section.cloop.index|escape:'htmlall':'UTF-8'}}	
			{foreach from=$products_{$smarty.section.cloop.index|escape:'htmlall':'UTF-8'} item=product name=myLoop}
				<li class="ajax_block_product {$csstype|escape:'htmlall':'UTF-8'} {if $smarty.foreach.myLoop.iteration % $nb_items_per_line == 1}first_item_of_line{/if} col-xs-12 col-sm-{$productgrid|escape:'htmlall':'UTF-8'} col-md-{$productgrid|escape:'htmlall':'UTF-8'}">
				{if $title_pos=='top'}
					<h5 class="s_title_block"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
				{/if}
					<div class="product-image-container">
						<a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|escape:html:'UTF-8'}" class="product_image">
							<img class="img-responsive" src="{$link->getImageLink($product.link_rewrite|escape:'htmlall':'UTF-8', $product.id_image|escape:'htmlall':'UTF-8', 'large_default')}" />
							{if isset($product.new) && $product.new == 1}<span class="label"><i class="icon-{$ptype|escape:'htmlall':'UTF-8'}"></i><span>{l s='New' mod='uhu_catproducts'}</span></span>{/if}
						</a>
						<div class="quick-view">
							{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
								{if ($product.allow_oosp || $product.quantity > 0)}
									{if isset($static_token)}
										<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_catproducts'}" data-id-product="{$product.id_product|intval}">
											<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
										</a>
									{else}
										<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_catproducts'}" data-id-product="{$product.id_product|intval}">
											<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
										</a>
									{/if}						
								{else}
									<span class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default disabled">
										<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
									</span>
								{/if}
							{/if}
							<h5 class="s_title_block"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|truncate:32:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
						</div>
					</div>
				{if $title_pos=='bottom'}
					<h5 class="s_title_block"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h5>
				{/if}
					<div class="product_desc">{$product.description_short|strip_tags|truncate:65:'...'|escape:'htmlall':'UTF-8'}</div>
					<div class="info">
						{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<p class="price_container"><span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></p>{else}<div style="height:21px;"></div>{/if}
						<a class="button" href="{$product.link|escape:'htmlall':'UTF-8'}" title="{l s='View' mod='uhu_catproducts'}">{l s='View' mod='uhu_catproducts'}</a>

						{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
							{if ($product.allow_oosp || $product.quantity > 0)}
								{if isset($static_token)}
									<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_catproducts'}" data-id-product="{$product.id_product|intval}">
										<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
									</a>
								{else}
									<a class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='uhu_catproducts'}" data-id-product="{$product.id_product|intval}">
										<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
									</a>
								{/if}						
							{else}
								<span class="button button-rounded button-flat-highlight ajax_add_to_cart_button btn btn-default disabled">
									<i class="icon-shopping-cart"></i><i class="text">{l s='Add to cart' mod='uhu_catproducts'}</i>
								</span>
							{/if}
						{/if}
					</div>
				</li>
			{/foreach}
			{else}
				<p>{l s='No products in this Category' mod='uhu_catproducts'}</p>
			{/if}
			</ul>		
		{/section}
	</div>
</div>
<!-- /MODULE Block uhu_catproducts -->
