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

<div id="gear-right">
	<i class="icon-cogs icon-2x icon-light"></i>
</div>
<form action="" method="post">
	<div id="tool_customization">
		<p>
			{l s='The customization tool allows you to make color and font changes in your theme.' mod='uhu_setting'}
		</p>
		<div class="list-tools">
			<p id="theme-title">
			  {l s='Color theme' mod='uhu_setting'} 
			  <i class="icon-caret-down pull-right"></i> 
			</p>
		</div>
		{if isset($themes)}
			<ul id="color-box">
				{foreach $themes as $theme}
					<li class="{$theme|escape:'htmlall':'UTF-8'}" style="background-color: {$colors[$theme@index]}"></li>
				{/foreach}
			</ul>
		{/if}

		<div class="list-tools">
			<p id="slider-title">
			  {l s='Style theme' mod='uhu_setting'} 
			  <i class="icon-caret-up pull-right"></i> 
			</p>
		</div>
			<div id="slider-box" style="display: none; padding-top: 0;">
				<p>{l s='Best Sale' mod='uhu_setting'}</p>
				<input type="radio" id="cp1901_show" name="cp1901_type" value="show"> Show <input type="radio" id="cp1901_hide" name="cp1901_type" value="hide"> Hide 
				<p>{l s='Information' mod='uhu_setting'}</p>
				<input type="radio" id="info_show" name="info_type" value="show"> Show <input type="radio" id="info_hide" name="info_type" value="hide"> Hide 
				<p>{l s='Facebook Fans' mod='uhu_setting'}</p>
				<input type="radio" id="fb_show" name="fb_type" value="show"> Show <input type="radio" id="fb_hide" name="fb_type" value="hide"> Hide 
				<p>{l s='Reassure Block' mod='uhu_setting'}</p>
				<input type="radio" id="re_show" name="re_type" value="show"> Show <input type="radio" id="re_hide" name="re_type" value="hide"> Hide 
			</div>

		{if $theme_type == 'full'}
		<div class="list-tools">
			<p id="adver-title">
			  {l s='Advertising' mod='uhu_setting'} 
			  <i class="icon-caret-up pull-right"></i> 
			</p>
		</div>
			<div id="adver-box" style="display: none; padding-top: 0;">
				<p>{l s='Image Slider' mod='uhu_setting'}</p>
				<input type="radio" id="slider_bx" name="slider_type" value="bx"> Bxslider <input type="radio" id="slider_cy" name="slider_type" value="cy"> Cycle2
				<p>{l s='Featured Product' mod='uhu_setting'}</p>
				<input type="radio" id="featured_mu" name="featured_type" value="multi"> Multi lines <input type="radio" id="featured_bx" name="featured_type" value="slider"> With slider
				<p>{l s='Advertising Block' mod='uhu_setting'}</p>
				<input type="radio" id="gj9561_show" name="gj9561_type" value="show"> Show adv 6&nbsp;&nbsp;&nbsp;<input type="radio" id="gj9561_hide" name="gj9561_type" value="hide"> Hide <br>
				<input type="radio" id="gj9551_show" name="gj9551_type" value="show"> Show adv 5&nbsp;&nbsp;&nbsp;<input type="radio" id="gj9551_hide" name="gj9551_type" value="hide"> Hide <br>
				<input type="radio" id="gj9541_show" name="gj9541_type" value="show"> Show adv 4&nbsp;&nbsp;&nbsp;<input type="radio" id="gj9541_hide" name="gj9541_type" value="hide"> Hide <br>
				<input type="radio" id="gj9531_show" name="gj9531_type" value="show"> Show adv 3&nbsp;&nbsp;&nbsp;<input type="radio" id="gj9531_hide" name="gj9531_type" value="hide"> Hide<br>
				<input type="radio" id="gj9521_show" name="gj9521_type" value="show"> Show adv 2&nbsp;&nbsp;&nbsp;<input type="radio" id="gj9521_hide" name="gj9521_type" value="hide"> Hide<br>
				<input type="radio" id="gj9511_show" name="gj9511_type" value="show"> Show adv 1&nbsp;&nbsp;&nbsp;<input type="radio" id="gj9511_hide" name="gj9511_type" value="hide"> Hide<br>
			</div>
		{/if}

		<div class="list-tools">
			<p id="background-title">
			  {l s='Background' mod='uhu_setting'} 
			  <i class="icon-caret-up pull-right"></i> 
			</p>
		</div>
			<ul id="background-box" class="colorbox" style="display: none;">
				<li class="nomargin hiddable">
					<label>Body</label>
					<input type="hidden" name="body_bg" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="body_bg" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_body_bg" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Page</label>
					<input type="hidden" name="page_bg" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="page_bg" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_page_bg" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Head</label>
					<input type="hidden" name="header_bg" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="header_bg" value="#000" style="background-color: #000; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_header_bg" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Foot</label>
					<input type="hidden" name="footer_bg" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="footer_bg" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_footer_bg" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Title</label>
					<input type="hidden" name="headings_bgcolor" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="headings_bgcolor" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_headings_bgcolor" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Menu</label>
					<input type="hidden" name="menu_bgcolor" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="menu_bgcolor" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_menu_bgcolor" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Button</label>
					<input type="hidden" name="button_bgcolor" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="button_bgcolor" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_button_bgcolor" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Cart</label>
					<input type="hidden" name="cart_iconbg" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="cart_iconbg" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_cart_iconbg" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
			</ul>

		<div class="list-tools">
			<p id="text-title">
			  {l s='Text' mod='uhu_setting'} 
			  <i class="icon-caret-up pull-right"></i> 
			</p>
		</div>
			<ul id="text-box" class="colorbox" style="display: none;">
				<li class="nomargin hiddable">
					<label>Text</label>
					<input type="hidden" name="body_Textcolor0" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="body_Textcolor0" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_body_Textcolor0" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Head</label>
					<input type="hidden" name="header_text" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="header_text" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_header_text" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Foot</label>
					<input type="hidden" name="footer_text" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="footer_text" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_footer_text" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Menu</label>
					<input type="hidden" name="menu_color" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="menu_color" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_menu_color" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Title</label>
					<input type="hidden" name="headings_color" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="headings_color" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_headings_color" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Info</label>
					<input type="hidden" name="product_des" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="product_des" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_product_des" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Price</label>
					<input type="hidden" name="product_price" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="product_price" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_product_price" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Button</label>
					<input type="hidden" name="button_color" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="button_color" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_button_color" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
			</ul>

		<div class="list-tools">
			<p id="link-title">
			  {l s='Link' mod='uhu_setting'} 
			  <i class="icon-caret-up pull-right"></i> 
			</p>
		</div>
			<ul id="link-box" class="colorbox" style="display: none;">
				<li class="nomargin hiddable">
					<label>Link</label>
					<input type="hidden" name="body_Linkcolor0" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="body_Linkcolor0" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_body_Linkcolor0" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Head</label>
					<input type="hidden" name="header_link" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="header_link" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_header_link" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Foot</label>
					<input type="hidden" name="footer_link" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="footer_link" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_footer_link" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
				<li class="nomargin hiddable">
					<label>Title</label>
					<input type="hidden" name="product_title" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="product_title" value="transparent" style="background-color: transparent; color: white;">
					<span style="cursor: pointer; background-color: transparent;" id="icp_product_title" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
				</li>
			</ul>

		<div class="list-tools">
			<p id="logo-title">
			  {l s='Logo' mod='uhu_setting'} 
			  <i class="icon-caret-up pull-right"></i> 
			</p>
		</div>
			<div id="logo-box" class="colorbox" style="display: none;">
				<input type="radio" id="logo_type_image" name="logo_type" value="image" checked="checked"> image &nbsp;&nbsp;
				<input type="radio" id="logo_type_text" name="logo_type" value="text"> text
				<p id="logo_title">Logo Text</p>
				<select name="logo_size" id="logo_size">
					<option value="15px"> 15px &nbsp;</option><option value="16px" > 16px &nbsp;</option><option value="17px" > 17px &nbsp;</option><option value="18px" > 18px &nbsp;</option><option value="19px" > 19px &nbsp;</option><option value="20px" > 20px &nbsp;</option><option value="21px" > 21px &nbsp;</option><option value="22px" > 22px &nbsp;</option><option value="23px" > 23px &nbsp;</option><option value="24px" > 24px &nbsp;</option><option value="25px" > 25px &nbsp;</option><option value="26px" > 26px &nbsp;</option><option value="27px" > 27px &nbsp;</option><option value="28px" > 28px &nbsp;</option><option value="29px" > 29px &nbsp;</option><option value="30px" > 30px &nbsp;</option><option value="31px" > 31px &nbsp;</option><option value="32px" > 32px &nbsp;</option><option value="33px" > 33px &nbsp;</option><option value="34px" > 34px &nbsp;</option><option value="35px" > 35px &nbsp;</option><option value="36px" > 36px &nbsp;</option><option value="37px" > 37px &nbsp;</option><option value="38px" > 38px &nbsp;</option><option value="39px" > 39px &nbsp;</option><option value="40px" > 40px &nbsp;</option><option value="41px" > 41px &nbsp;</option><option value="42px" > 42px &nbsp;</option><option value="43px" > 43px &nbsp;</option><option value="44px" > 44px &nbsp;</option><option value="45px" > 45px &nbsp;</option><option value="46px" > 46px &nbsp;</option><option value="47px" > 47px &nbsp;</option><option value="48px" > 48px &nbsp;</option><option value="49px" > 49px &nbsp;</option><option value="50px" > 50px &nbsp;</option><option value="51px" > 51px &nbsp;</option><option value="52px" > 52px &nbsp;</option><option value="53px" > 53px &nbsp;</option><option value="54px" > 54px &nbsp;</option><option value="55px" > 55px &nbsp;</option><option value="56px" > 56px &nbsp;</option><option value="57px" > 57px &nbsp;</option><option value="58px" > 58px &nbsp;</option><option value="59px" > 59px &nbsp;</option><option value="60px" > 60px &nbsp;</option><option value="61px" > 61px &nbsp;</option><option value="62px" > 62px &nbsp;</option><option value="63px" > 63px &nbsp;</option><option value="64px" > 64px &nbsp;</option><option value="65px" > 65px &nbsp;</option><option value="66px" > 66px &nbsp;</option><option value="67px" > 67px &nbsp;</option><option value="68px" > 68px &nbsp;</option><option value="69px" > 69px &nbsp;</option><option value="70px" > 70px &nbsp;</option><option value="71px" > 71px &nbsp;</option><option value="72px" > 72px &nbsp;</option><option value="73px" > 73px &nbsp;</option><option value="74px" > 74px &nbsp;</option><option value="75px" > 75px &nbsp;</option><option value="76px" > 76px &nbsp;</option><option value="77px" > 77px &nbsp;</option><option value="78px" > 78px &nbsp;</option><option value="79px" > 79px &nbsp;</option><option value="80px" > 80px &nbsp;</option>
				</select>
				<select name="logo_font" id="logo_font">
					<option value="Abel"> Abel </option><option value="ABeeZee">ABeeZee</option><option value="Abel">Abel</option><option value="Abril Fatface">Abril Fatface</option><option value="Aclonica">Aclonica</option><option value="Acme">Acme</option><option value="Actor">Actor</option><option value="Adamina">Adamina</option><option value="Advent Pro">Advent Pro</option><option value="Aguafina Script">Aguafina Script</option><option value="Akronim">Akronim</option><option value="Aladin">Aladin</option><option value="Aldrich">Aldrich</option><option value="Alegreya">Alegreya</option><option value="Alegreya SC">Alegreya SC</option><option value="Alex Brush">Alex Brush</option><option value="Alfa Slab One">Alfa Slab One</option><option value="Alice">Alice</option><option value="Alike">Alike</option><option value="Alike Angular">Alike Angular</option><option value="Allan">Allan</option><option value="Allerta">Allerta</option><option value="Allerta Stencil">Allerta Stencil</option><option value="Allura">Allura</option><option value="Almendra">Almendra</option><option value="Almendra SC">Almendra SC</option><option value="Amarante">Amarante</option><option value="Amaranth">Amaranth</option><option value="Amatic SC">Amatic SC</option><option value="Amethysta">Amethysta</option><option value="Andada">Andada</option><option value="Andika">Andika</option><option value="Angkor">Angkor</option><option value="Annie Use Your Telescope">Annie Use Your Telescope</option><option value="Anonymous Pro">Anonymous Pro</option><option value="Antic">Antic</option><option value="Antic Didone">Antic Didone</option><option value="Antic Slab">Antic Slab</option><option value="Anton">Anton</option><option value="Arapey">Arapey</option><option value="Arbutus">Arbutus</option><option value="Arbutus Slab">Arbutus Slab</option><option value="Architects Daughter">Architects Daughter</option><option value="Archivo Black">Archivo Black</option><option value="Archivo Narrow">Archivo Narrow</option><option value="Arimo">Arimo</option><option value="Arizonia">Arizonia</option><option value="Armata">Armata</option><option value="Artifika">Artifika</option><option value="Arvo">Arvo</option><option value="Asap">Asap</option><option value="Asset">Asset</option><option value="Astloch">Astloch</option><option value="Asul">Asul</option><option value="Atomic Age">Atomic Age</option><option value="Aubrey">Aubrey</option><option value="Audiowide">Audiowide</option><option value="Autour One">Autour One</option><option value="Average">Average</option><option value="Averia Gruesa Libre">Averia Gruesa Libre</option><option value="Averia Libre">Averia Libre</option><option value="Averia Sans Libre">Averia Sans Libre</option><option value="Averia Serif Libre">Averia Serif Libre</option><option value="Bad Script">Bad Script</option><option value="Balthazar">Balthazar</option><option value="Bangers">Bangers</option><option value="Basic">Basic</option><option value="Battambang">Battambang</option><option value="Baumans">Baumans</option><option value="Bayon">Bayon</option><option value="Belgrano">Belgrano</option><option value="Belleza">Belleza</option><option value="BenchNine">BenchNine</option><option value="Bentham">Bentham</option><option value="Berkshire Swash">Berkshire Swash</option><option value="Bevan">Bevan</option><option value="Bigshot One">Bigshot One</option><option value="Bilbo">Bilbo</option><option value="Bilbo Swash Caps">Bilbo Swash Caps</option><option value="Bitter">Bitter</option><option value="Black Ops One">Black Ops One</option><option value="Bokor">Bokor</option><option value="Bonbon">Bonbon</option><option value="Boogaloo">Boogaloo</option><option value="Bowlby One">Bowlby One</option><option value="Bowlby One SC">Bowlby One SC</option><option value="Brawler">Brawler</option><option value="Bree Serif">Bree Serif</option><option value="Bubblegum Sans">Bubblegum Sans</option><option value="Bubbler One">Bubbler One</option><option value="Buda">Buda</option><option value="Buenard">Buenard</option><option value="Butcherman">Butcherman</option><option value="Butterfly Kids">Butterfly Kids</option><option value="Cabin">Cabin</option><option value="Cabin Condensed">Cabin Condensed</option><option value="Cabin Sketch">Cabin Sketch</option><option value="Caesar Dressing">Caesar Dressing</option><option value="Cagliostro">Cagliostro</option><option value="Calligraffitti">Calligraffitti</option><option value="Cambo">Cambo</option><option value="Candal">Candal</option><option value="Cantarell">Cantarell</option><option value="Cantata One">Cantata One</option><option value="Cantora One">Cantora One</option><option value="Capriola">Capriola</option><option value="Cardo">Cardo</option><option value="Carme">Carme</option><option value="Carrois Gothic">Carrois Gothic</option><option value="Carrois Gothic SC">Carrois Gothic SC</option><option value="Carter One">Carter One</option><option value="Caudex">Caudex</option><option value="Cedarville Cursive">Cedarville Cursive</option><option value="Ceviche One">Ceviche One</option><option value="Changa One">Changa One</option><option value="Chango">Chango</option><option value="Chau Philomene One">Chau Philomene One</option><option value="Chela One">Chela One</option><option value="Chelsea Market">Chelsea Market</option><option value="Chenla">Chenla</option><option value="Cherry Cream Soda">Cherry Cream Soda</option><option value="Cherry Swash">Cherry Swash</option><option value="Chewy">Chewy</option><option value="Chicle">Chicle</option><option value="Chivo">Chivo</option><option value="Cinzel">Cinzel</option><option value="Cinzel Decorative">Cinzel Decorative</option><option value="Coda">Coda</option><option value="Coda Caption">Coda Caption</option><option value="Codystar">Codystar</option><option value="Combo">Combo</option><option value="Comfortaa">Comfortaa</option><option value="Coming Soon">Coming Soon</option><option value="Concert One">Concert One</option><option value="Condiment">Condiment</option><option value="Content">Content</option><option value="Contrail One">Contrail One</option><option value="Convergence">Convergence</option><option value="Cookie">Cookie</option><option value="Copse">Copse</option><option value="Corben">Corben</option><option value="Courgette">Courgette</option><option value="Cousine">Cousine</option><option value="Coustard">Coustard</option><option value="Covered By Your Grace">Covered By Your Grace</option><option value="Crafty Girls">Crafty Girls</option><option value="Creepster">Creepster</option><option value="Crete Round">Crete Round</option><option value="Crimson Text">Crimson Text</option><option value="Crushed">Crushed</option><option value="Cuprum">Cuprum</option><option value="Cutive">Cutive</option><option value="Damion">Damion</option><option value="Dancing Script">Dancing Script</option><option value="Dangrek">Dangrek</option><option value="Dawning of a New Day">Dawning of a New Day</option><option value="Days One">Days One</option><option value="Delius">Delius</option><option value="Delius Swash Caps">Delius Swash Caps</option><option value="Delius Unicase">Delius Unicase</option><option value="Della Respira">Della Respira</option><option value="Devonshire">Devonshire</option><option value="Didact Gothic">Didact Gothic</option><option value="Diplomata">Diplomata</option><option value="Diplomata SC">Diplomata SC</option><option value="Doppio One">Doppio One</option><option value="Dorsa">Dorsa</option><option value="Dosis">Dosis</option><option value="Dr Sugiyama">Dr Sugiyama</option><option value="Droid Sans">Droid Sans</option><option value="Droid Sans Mono">Droid Sans Mono</option><option value="Droid Serif">Droid Serif</option><option value="Duru Sans">Duru Sans</option><option value="Dynalight">Dynalight</option><option value="EB Garamond">EB Garamond</option><option value="Eagle Lake">Eagle Lake</option><option value="Eater">Eater</option><option value="Economica">Economica</option><option value="Electrolize">Electrolize</option><option value="Emblema One">Emblema One</option><option value="Emilys Candy">Emilys Candy</option><option value="Engagement">Engagement</option><option value="Enriqueta">Enriqueta</option><option value="Erica One">Erica One</option><option value="Esteban">Esteban</option><option value="Euphoria Script">Euphoria Script</option><option value="Ewert">Ewert</option><option value="Exo">Exo</option><option value="Expletus Sans">Expletus Sans</option><option value="Fanwood Text">Fanwood Text</option><option value="Fascinate">Fascinate</option><option value="Fascinate Inline">Fascinate Inline</option><option value="Fasthand">Fasthand</option><option value="Federant">Federant</option><option value="Federo">Federo</option><option value="Felipa">Felipa</option><option value="Fenix">Fenix</option><option value="Finger Paint">Finger Paint</option><option value="Fjord One">Fjord One</option><option value="Flamenco">Flamenco</option><option value="Flavors">Flavors</option><option value="Fondamento">Fondamento</option><option value="Fontdiner Swanky">Fontdiner Swanky</option><option value="Forum">Forum</option><option value="Francois One">Francois One</option><option value="Fredericka the Great">Fredericka the Great</option><option value="Fredoka One">Fredoka One</option><option value="Freehand">Freehand</option><option value="Fresca">Fresca</option><option value="Frijole">Frijole</option><option value="Fugaz One">Fugaz One</option><option value="GFS Didot">GFS Didot</option><option value="GFS Neohellenic">GFS Neohellenic</option><option value="Galdeano">Galdeano</option><option value="Galindo">Galindo</option><option value="Gentium Basic">Gentium Basic</option><option value="Gentium Book Basic">Gentium Book Basic</option><option value="Geo">Geo</option><option value="Geostar">Geostar</option><option value="Geostar Fill">Geostar Fill</option><option value="Germania One">Germania One</option><option value="Give You Glory">Give You Glory</option><option value="Glass Antiqua">Glass Antiqua</option><option value="Glegoo">Glegoo</option><option value="Gloria Hallelujah">Gloria Hallelujah</option><option value="Goblin One">Goblin One</option><option value="Gochi Hand">Gochi Hand</option><option value="Gorditas">Gorditas</option><option value="Goudy Bookletter 1911">Goudy Bookletter 1911</option><option value="Graduate">Graduate</option><option value="Gravitas One">Gravitas One</option><option value="Great Vibes">Great Vibes</option><option value="Griffy">Griffy</option><option value="Gruppo">Gruppo</option><option value="Gudea">Gudea</option><option value="Habibi">Habibi</option><option value="Hammersmith One">Hammersmith One</option><option value="Handlee">Handlee</option><option value="Hanuman">Hanuman</option><option value="Happy Monkey">Happy Monkey</option><option value="Headland One">Headland One</option><option value="Henny Penny">Henny Penny</option><option value="Herr Von Muellerhoff">Herr Von Muellerhoff</option><option value="Holtwood One SC">Holtwood One SC</option><option value="Homemade Apple">Homemade Apple</option><option value="Homenaje">Homenaje</option><option value="IM Fell DW Pica">IM Fell DW Pica</option><option value="IM Fell DW Pica SC">IM Fell DW Pica SC</option><option value="IM Fell Double Pica">IM Fell Double Pica</option><option value="IM Fell Double Pica SC">IM Fell Double Pica SC</option><option value="IM Fell English">IM Fell English</option><option value="IM Fell English SC">IM Fell English SC</option><option value="IM Fell French Canon">IM Fell French Canon</option><option value="IM Fell French Canon SC">IM Fell French Canon SC</option><option value="IM Fell Great Primer">IM Fell Great Primer</option><option value="IM Fell Great Primer SC">IM Fell Great Primer SC</option><option value="Iceberg">Iceberg</option><option value="Iceland">Iceland</option><option value="Imprima">Imprima</option><option value="Inconsolata">Inconsolata</option><option value="Inder">Inder</option><option value="Indie Flower">Indie Flower</option><option value="Inika">Inika</option><option value="Irish Grover">Irish Grover</option><option value="Istok Web">Istok Web</option><option value="Italiana">Italiana</option><option value="Italianno">Italianno</option><option value="Jacques Francois">Jacques Francois</option><option value="Jacques Francois Shadow">Jacques Francois Shadow</option><option value="Jim Nightshade">Jim Nightshade</option><option value="Jockey One">Jockey One</option><option value="Jolly Lodger">Jolly Lodger</option><option value="Josefin Sans">Josefin Sans</option><option value="Josefin Slab">Josefin Slab</option><option value="Judson">Judson</option><option value="Julee">Julee</option><option value="Julius Sans One">Julius Sans One</option><option value="Junge">Junge</option><option value="Jura">Jura</option><option value="Just Another Hand">Just Another Hand</option><option value="Just Me Again Down Here">Just Me Again Down Here</option><option value="Kameron">Kameron</option><option value="Karla">Karla</option><option value="Kaushan Script">Kaushan Script</option><option value="Kelly Slab">Kelly Slab</option><option value="Kenia">Kenia</option><option value="Khmer">Khmer</option><option value="Knewave">Knewave</option><option value="Kotta One">Kotta One</option><option value="Koulen">Koulen</option><option value="Kranky">Kranky</option><option value="Kreon">Kreon</option><option value="Kristi">Kristi</option><option value="Krona One">Krona One</option><option value="La Belle Aurore">La Belle Aurore</option><option value="Lancelot">Lancelot</option><option value="Lato">Lato</option><option value="League Script">League Script</option><option value="Leckerli One">Leckerli One</option><option value="Ledger">Ledger</option><option value="Lekton">Lekton</option><option value="Lemon">Lemon</option><option value="Life Savers">Life Savers</option><option value="Lilita One">Lilita One</option><option value="Limelight">Limelight</option><option value="Linden Hill">Linden Hill</option><option value="Lobster">Lobster</option><option value="Lobster Two">Lobster Two</option><option value="Londrina Outline">Londrina Outline</option><option value="Londrina Shadow">Londrina Shadow</option><option value="Londrina Sketch">Londrina Sketch</option><option value="Londrina Solid">Londrina Solid</option><option value="Lora">Lora</option><option value="Love Ya Like A Sister">Love Ya Like A Sister</option><option value="Loved by the King">Loved by the King</option><option value="Lovers Quarrel">Lovers Quarrel</option><option value="Luckiest Guy">Luckiest Guy</option><option value="Lusitana">Lusitana</option><option value="Lustria">Lustria</option><option value="Macondo">Macondo</option><option value="Macondo Swash Caps">Macondo Swash Caps</option><option value="Magra">Magra</option><option value="Maiden Orange">Maiden Orange</option><option value="Mako">Mako</option><option value="Marcellus">Marcellus</option><option value="Marcellus SC">Marcellus SC</option><option value="Marck Script">Marck Script</option><option value="Marko One">Marko One</option><option value="Marmelad">Marmelad</option><option value="Marvel">Marvel</option><option value="Mate">Mate</option><option value="Mate SC">Mate SC</option><option value="Maven Pro">Maven Pro</option><option value="McLaren">McLaren</option><option value="Meddon">Meddon</option><option value="MedievalSharp">MedievalSharp</option><option value="Medula One">Medula One</option><option value="Megrim">Megrim</option><option value="Meie Script">Meie Script</option><option value="Merienda One">Merienda One</option><option value="Merriweather">Merriweather</option><option value="Metal">Metal</option><option value="Metal Mania">Metal Mania</option><option value="Metamorphous">Metamorphous</option><option value="Metrophobic">Metrophobic</option><option value="Michroma">Michroma</option><option value="Miltonian">Miltonian</option><option value="Miltonian Tattoo">Miltonian Tattoo</option><option value="Miniver">Miniver</option><option value="Miss Fajardose">Miss Fajardose</option><option value="Modern Antiqua">Modern Antiqua</option><option value="Molengo">Molengo</option><option value="Molle">Molle</option><option value="Monofett">Monofett</option><option value="Monoton">Monoton</option><option value="Monsieur La Doulaise">Monsieur La Doulaise</option><option value="Montaga">Montaga</option><option value="Montez">Montez</option><option value="Montserrat">Montserrat</option><option value="Montserrat Alternates">Montserrat Alternates</option><option value="Montserrat Subrayada">Montserrat Subrayada</option><option value="Moul">Moul</option><option value="Moulpali">Moulpali</option><option value="Mountains of Christmas">Mountains of Christmas</option><option value="Mr Bedfort">Mr Bedfort</option><option value="Mr Dafoe">Mr Dafoe</option><option value="Mr De Haviland">Mr De Haviland</option><option value="Mrs Saint Delafield">Mrs Saint Delafield</option><option value="Mrs Sheppards">Mrs Sheppards</option><option value="Muli">Muli</option><option value="Mystery Quest">Mystery Quest</option><option value="Neucha">Neucha</option><option value="Neuton">Neuton</option><option value="News Cycle">News Cycle</option><option value="Niconne">Niconne</option><option value="Nixie One">Nixie One</option><option value="Nobile">Nobile</option><option value="Nokora">Nokora</option><option value="Norican">Norican</option><option value="Nosifer">Nosifer</option><option value="Nothing You Could Do">Nothing You Could Do</option><option value="Noticia Text">Noticia Text</option><option value="Nova Cut">Nova Cut</option><option value="Nova Flat">Nova Flat</option><option value="Nova Mono">Nova Mono</option><option value="Nova Oval">Nova Oval</option><option value="Nova Round">Nova Round</option><option value="Nova Script">Nova Script</option><option value="Nova Slim">Nova Slim</option><option value="Nova Square">Nova Square</option><option value="Numans">Numans</option><option value="Nunito">Nunito</option><option value="Odor Mean Chey">Odor Mean Chey</option><option value="Old Standard TT">Old Standard TT</option><option value="Oldenburg">Oldenburg</option><option value="Oleo Script">Oleo Script</option><option value="Open Sans">Open Sans</option><option value="Open Sans Condensed">Open Sans Condensed</option><option value="Oranienbaum">Oranienbaum</option><option value="Orbitron">Orbitron</option><option value="Oregano">Oregano</option><option value="Orienta">Orienta</option><option value="Original Surfer">Original Surfer</option><option value="Oswald">Oswald</option><option value="Over the Rainbow">Over the Rainbow</option><option value="Overlock">Overlock</option><option value="Overlock SC">Overlock SC</option><option value="Ovo">Ovo</option><option value="Oxygen">Oxygen</option><option value="Oxygen Mono">Oxygen Mono</option><option value="PT Mono">PT Mono</option><option value="PT Sans">PT Sans</option><option value="PT Sans Caption">PT Sans Caption</option><option value="PT Sans Narrow">PT Sans Narrow</option><option value="PT Serif">PT Serif</option><option value="PT Serif Caption">PT Serif Caption</option><option value="Pacifico">Pacifico</option><option value="Parisienne">Parisienne</option><option value="Passero One">Passero One</option><option value="Passion One">Passion One</option><option value="Patrick Hand">Patrick Hand</option><option value="Patua One">Patua One</option><option value="Paytone One">Paytone One</option><option value="Peralta">Peralta</option><option value="Permanent Marker">Permanent Marker</option><option value="Petit Formal Script">Petit Formal Script</option><option value="Petrona">Petrona</option><option value="Philosopher">Philosopher</option><option value="Piedra">Piedra</option><option value="Pinyon Script">Pinyon Script</option><option value="Plaster">Plaster</option><option value="Play">Play</option><option value="Playball">Playball</option><option value="Playfair Display">Playfair Display</option><option value="Podkova">Podkova</option><option value="Poiret One">Poiret One</option><option value="Poller One">Poller One</option><option value="Poly">Poly</option><option value="Pompiere">Pompiere</option><option value="Pontano Sans">Pontano Sans</option><option value="Port Lligat Sans">Port Lligat Sans</option><option value="Port Lligat Slab">Port Lligat Slab</option><option value="Prata">Prata</option><option value="Preahvihear">Preahvihear</option><option value="Press Start 2P">Press Start 2P</option><option value="Princess Sofia">Princess Sofia</option><option value="Prociono">Prociono</option><option value="Prosto One">Prosto One</option><option value="Puritan">Puritan</option><option value="Quando">Quando</option><option value="Quantico">Quantico</option><option value="Quattrocento">Quattrocento</option><option value="Quattrocento Sans">Quattrocento Sans</option><option value="Questrial">Questrial</option><option value="Quicksand">Quicksand</option><option value="Qwigley">Qwigley</option><option value="Racing Sans One">Racing Sans One</option><option value="Radley">Radley</option><option value="Raleway">Raleway</option><option value="Raleway Dots">Raleway Dots</option><option value="Rammetto One">Rammetto One</option><option value="Ranchers">Ranchers</option><option value="Rancho">Rancho</option><option value="Rationale">Rationale</option><option value="Redressed">Redressed</option><option value="Reenie Beanie">Reenie Beanie</option><option value="Revalia">Revalia</option><option value="Ribeye">Ribeye</option><option value="Ribeye Marrow">Ribeye Marrow</option><option value="Righteous">Righteous</option><option value="Rochester">Rochester</option><option value="Rock Salt">Rock Salt</option><option value="Rokkitt">Rokkitt</option><option value="Romanesco">Romanesco</option><option value="Ropa Sans">Ropa Sans</option><option value="Rosario">Rosario</option><option value="Rosarivo">Rosarivo</option><option value="Rouge Script">Rouge Script</option><option value="Ruda">Ruda</option><option value="Ruge Boogie">Ruge Boogie</option><option value="Ruluko">Ruluko</option><option value="Ruslan Display">Ruslan Display</option><option value="Russo One">Russo One</option><option value="Ruthie">Ruthie</option><option value="Rye">Rye</option><option value="Sail">Sail</option><option value="Salsa">Salsa</option><option value="Sancreek">Sancreek</option><option value="Sansita One">Sansita One</option><option value="Sarina">Sarina</option><option value="Satisfy">Satisfy</option><option value="Scada">Scada</option><option value="Schoolbell">Schoolbell</option><option value="Seaweed Script">Seaweed Script</option><option value="Sevillana">Sevillana</option><option value="Seymour One">Seymour One</option><option value="Shadows Into Light">Shadows Into Light</option><option value="Shadows Into Light Two">Shadows Into Light Two</option><option value="Shanti">Shanti</option><option value="Share">Share</option><option value="Shojumaru">Shojumaru</option><option value="Short Stack">Short Stack</option><option value="Siemreap">Siemreap</option><option value="Sigmar One">Sigmar One</option><option value="Signika">Signika</option><option value="Signika Negative">Signika Negative</option><option value="Simonetta">Simonetta</option><option value="Sirin Stencil">Sirin Stencil</option><option value="Six Caps">Six Caps</option><option value="Skranji">Skranji</option><option value="Slackey">Slackey</option><option value="Smokum">Smokum</option><option value="Smythe">Smythe</option><option value="Sniglet">Sniglet</option><option value="Snippet">Snippet</option><option value="Sofadi One">Sofadi One</option><option value="Sofia">Sofia</option><option value="Sonsie One">Sonsie One</option><option value="Sorts Mill Goudy">Sorts Mill Goudy</option><option value="Source Code Pro">Source Code Pro</option><option value="Source Sans Pro">Source Sans Pro</option><option value="Special Elite">Special Elite</option><option value="Spicy Rice">Spicy Rice</option><option value="Spinnaker">Spinnaker</option><option value="Spirax">Spirax</option><option value="Squada One">Squada One</option><option value="Stalinist One">Stalinist One</option><option value="Stardos Stencil">Stardos Stencil</option><option value="Stint Ultra Condensed">Stint Ultra Condensed</option><option value="Stint Ultra Expanded">Stint Ultra Expanded</option><option value="Stoke">Stoke</option><option value="Sue Ellen Francisco">Sue Ellen Francisco</option><option value="Sunshiney">Sunshiney</option><option value="Supermercado One">Supermercado One</option><option value="Suwannaphum">Suwannaphum</option><option value="Swanky and Moo Moo">Swanky and Moo Moo</option><option value="Syncopate">Syncopate</option><option value="Tangerine">Tangerine</option><option value="Taprom">Taprom</option><option value="Telex">Telex</option><option value="Tenor Sans">Tenor Sans</option><option value="The Girl Next Door">The Girl Next Door</option><option value="Tienne">Tienne</option><option value="Tinos">Tinos</option><option value="Titan One">Titan One</option><option value="Titillium Web">Titillium Web</option><option value="Trade Winds">Trade Winds</option><option value="Trocchi">Trocchi</option><option value="Trochut">Trochut</option><option value="Trykker">Trykker</option><option value="Tulpen One">Tulpen One</option><option value="Ubuntu">Ubuntu</option><option value="Ubuntu Condensed">Ubuntu Condensed</option><option value="Ubuntu Mono">Ubuntu Mono</option><option value="Ultra">Ultra</option><option value="Uncial Antiqua">Uncial Antiqua</option><option value="Underdog">Underdog</option><option value="UnifrakturCook">UnifrakturCook</option><option value="UnifrakturMaguntia">UnifrakturMaguntia</option><option value="Unkempt">Unkempt</option><option value="Unlock">Unlock</option><option value="Unna">Unna</option><option value="VT323">VT323</option><option value="Varela">Varela</option><option value="Varela Round">Varela Round</option><option value="Vast Shadow">Vast Shadow</option><option value="Vibur">Vibur</option><option value="Vidaloka">Vidaloka</option><option value="Viga">Viga</option><option value="Voces">Voces</option><option value="Volkhov">Volkhov</option><option value="Vollkorn">Vollkorn</option><option value="Voltaire">Voltaire</option><option value="Waiting for the Sunrise">Waiting for the Sunrise</option><option value="Wallpoet">Wallpoet</option><option value="Walter Turncoat">Walter Turncoat</option><option value="Warnes">Warnes</option><option value="Wellfleet">Wellfleet</option><option value="Wire One">Wire One</option><option value="Yanone Kaffeesatz">Yanone Kaffeesatz</option><option value="Yellowtail">Yellowtail</option><option value="Yeseva One">Yeseva One</option><option value="Yesteryear">Yesteryear</option><option value="Zeyada">Zeyada</option>
				</select>
				<input type="hidden" name="logo_color" data-text="hidden" data-hex="true" class="colorpicker mColorPicker" id="logo_color" value="transparent" style="background-color: transparent; color: white;">
				<span style="cursor: pointer; background-color: transparent;" id="icp_logo_color" class="colorpicker mColorPickerTrigger" data-mcolorpicker="true">&nbsp;</span>
			</div>

		<div class="btn-tools">
			<button type="submit" class="btn btn-1" id="reset" name="resetLiveConfigurator">{l s='Reset' mod='uhu_setting'}</button>
			{if $theme_save}
			<button type="submit" class="btn btn-2" name="submitLiveConfigurator">{l s='Save' mod='uhu_setting'}</button>
			{/if}
		</div>
		<div id="block-advertisement">
			{l s='Over 300+ items can be changed in the back office!' mod='uhu_setting'}
		</div>
	</div>
</form>

<script type="text/javascript">
	var screenbg='{$front_screenbg|escape:'htmlall':'UTF-8'}';
	var pagebg='{$front_pagebg|escape:'htmlall':'UTF-8'}';
	var headerbg='{$front_headerbg|escape:'htmlall':'UTF-8'}';
	var footerbg='{$front_footerbg|escape:'htmlall':'UTF-8'}';
	var headings_bg='{$front_headingscolor|escape:'htmlall':'UTF-8'}'; 
	var bgcolor_menu='{$front_menubarbgcolor|escape:'htmlall':'UTF-8'}'; 
	var all_buttons='{$front_buttons|escape:'htmlall':'UTF-8'}';
	var cart_iconbg='{$front_carticon|escape:'htmlall':'UTF-8'}';

	var all_textcolor='{$front_textcolor|escape:'htmlall':'UTF-8'}';
	var header_text='{$front_headertext|escape:'htmlall':'UTF-8'}';
	var footer_text='{$front_footertext|escape:'htmlall':'UTF-8'}';
	var color_menu='{$front_menubartext|escape:'htmlall':'UTF-8'}';
	var headings_title='{$front_headingstext|escape:'htmlall':'UTF-8'}';
	var product_des='{$front_productdes|escape:'htmlall':'UTF-8'}';
	var product_price='{$front_productprice|escape:'htmlall':'UTF-8'}';

	var all_linkcolor='{$front_linkcolor|escape:'htmlall':'UTF-8'}';
	var header_link='{$front_headerlink|escape:'htmlall':'UTF-8'}';
	var footer_link='{$front_footerlink|escape:'htmlall':'UTF-8'}';
	var product_title='{$front_producttitle|escape:'htmlall':'UTF-8'}';
	    
	var all_icon='{$front_icon|escape:'htmlall':'UTF-8'}';
	var head_icon='{$front_headericon|escape:'htmlall':'UTF-8'}';
	var foot_icon='{$front_footericon|escape:'htmlall':'UTF-8'}';
	var cart_icon='{$front_carticon|escape:'htmlall':'UTF-8'}';
</script>

{literal}
<script type="text/javascript">
$.fn.mColorPicker.defaults={imageFolder:'{$module_dir}/../img/admin/',swatches: ["#ffffff","#ffff00","#00ff00","#00ffff","#0000ff","#ff00ff","#ff0000","#4c2b11","#3b3b3b","#000000"]};

function bind_css(cssid, selectors, cssfind){
	$('#'+cssid).bind('change',function(){
		$(selectors).css(cssfind,$(this).val());
		$.cookie(cssid,$(this).val());
	});	
	if ($.cookie(cssid)){
		$(selectors).css(cssfind,$.cookie(cssid));
		$('#icp_'+cssid).css('backgroundColor',$.cookie(cssid));
		$('#'+cssid).val($.cookie(cssid));
	}
}  

function change_font(cssid, linkid, selectors){	
	$('#'+cssid).change(function(){
		var gfont=$("option:selected",this).val();
		$.cookie(cssid,gfont);
		if($('head').find('link#'+linkid).length<1){
			$('head').append('<link id="'+linkid+'" href="" rel="stylesheet" type="text/css"/>');
		}
		$('link#'+linkid).attr({href:'http://fonts.googleapis.com/css?family='+gfont});
		$(selectors).css({'font-family':gfont});
	});
	if($.cookie(cssid)){
		if($('head').find('link#'+linkid).length<1){
			$('head').append('<link id="'+linkid+'" href="" rel="stylesheet" type="text/css"/>');
		}
		$('link#'+linkid).attr({href:'http://fonts.googleapis.com/css?family='+$.cookie(cssid)});$(selectors).css({'font-family':$.cookie(cssid)});
	}
}  

function change_size(cssid, selectors){
	$('#'+cssid).change(function(){
		var value=$("option:selected",this).val();
		$(selectors).css({'fontSize':value});
		$.cookie(cssid,value);
	});
	if($.cookie(cssid)){
		$(selectors).css({
			'fontSize':$.cookie(cssid)
		});
	}
}
  
jQuery(document).ready(
	function($)
	{
		if($.cookie("logo")){
			if($.cookie("logo")=="text"){
				$("#logo_image").removeClass("display").addClass("hidden");
				$("#logo_text").removeClass("hidden").addClass("display");
				$('#logo_type_text').attr("checked","checked");
				$('#logo_type_image').removeAttr("checked");
			}
			if($.cookie("logo")=="image"){
				$("#logo_image").removeClass("hidden").addClass("display");
				$("#logo_text").removeClass("display").addClass("hidden");
				$('#logo_type_image').attr("checked","checked");
				$('#logo_type_text').removeAttr("checked");
			}
		}
	
		bind_css('body_bg', 'body', 'background-color');
		bind_css('page_bg', '#columns', 'background-color');
		bind_css('header_bg', headerbg, 'background-color');
		bind_css('footer_bg', footerbg, 'background-color');
		bind_css('headings_bgcolor', headings_bg, 'background-color');
		bind_css('menu_bgcolor', bgcolor_menu, 'background-color');
		bind_css('button_bgcolor', all_buttons, 'background-color');
		bind_css('cart_iconbg', cart_iconbg, 'background-color');
		
		bind_css('body_Textcolor0', all_textcolor, 'color');
		bind_css('header_text', header_text, 'color');
		bind_css('footer_text', footer_text, 'color');
		bind_css('menu_color', color_menu, 'color');
		bind_css('headings_color', headings_title, 'color');
		bind_css('product_des', product_des, 'color');
		bind_css('product_price', product_price, 'color');
		bind_css('button_color', all_buttons, 'color');

		bind_css('body_Linkcolor0', all_linkcolor, 'color');
		bind_css('header_link', header_link, 'color');
		bind_css('footer_link', footer_link, 'color');
		bind_css('product_title', product_title, 'color');
		
		bind_css('all_icon', all_icon, 'color');
		bind_css('head_icon', head_icon, 'color');
		bind_css('foot_icon', foot_icon, 'color');
		bind_css('cart_icon', cart_icon, 'color');

		bind_css('logo_color', 'a#logo_text', 'color');	
		change_size('logo_size', '#header_logo a#logo_text');
		change_font('logo_font', 'link_logo', '#header_logo a#logo_text');
	}
);
</script>
{/literal}
