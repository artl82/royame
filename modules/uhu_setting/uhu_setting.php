<?php
/*
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
*/


/* v4.16.17 */

if (!defined('_PS_VERSION_'))
	exit;

class Uhu_setting extends Module
{
	public function __construct()
	{
		$this->name = 'uhu_setting';
		$this->tab = 'others';
		$this->version = '4.16.17';
		$this->bootstrap = true;
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Theme configurator';
		$this->description = $this->l('Change the color or image for your background.');
	}

	public function install()
	{
		Configuration::updateValue('uhu_css_2012_front_panel', 0);
		Configuration::updateValue('uhu_css_2012_column', 0);
		Configuration::updateValue('PS_UHU_THEME', 'theme1');
		Configuration::updateValue('uhu_responsive', 0);

		Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'theme` SET `responsive` = \'1\', `default_left_column` = \'1\', `default_right_column` = \'0\', `product_per_page` = \'12\' WHERE name = \'uhu-bootstrap\'');

		$theme_id = Db::getInstance()->getValue('SELECT id_theme FROM '._DB_PREFIX_.'theme WHERE name=\'uhu-bootstrap\'');

		$tmp_meta = array();
		$metas_xml = array();
		$new_theme = new Theme();
		$new_theme->id = $theme_id;
		$metas = Db::getInstance()->executeS('SELECT id_meta FROM '._DB_PREFIX_.'meta');
		foreach ($metas as $meta)
		{
			$tmp_meta['id_meta'] = (int)$meta['id_meta'];
			$tmp_meta['left'] = 0;
			$tmp_meta['right'] = 0;
			$metas_xml[] = $tmp_meta;
		}
		$new_theme->updateMetas($metas_xml, true);

		Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'theme_meta` SET `left_column` = \'1\' WHERE id_theme='.$theme_id.' AND (id_meta = \'2\' OR id_meta = \'5\' OR id_meta = \'6\' OR id_meta = \'8\' OR id_meta = \'9\' OR id_meta = \'22\' OR id_meta = \'28\')');

		Configuration::updateValue('uhu_responsive', 1);

		$this->loadConfigFile('yes');

		if (!parent::install() ||
			!$this->registerHook('displayHeader') ||
			!$this->registerHook('displayFooter') ||
			!$this->registerHook('displayBackOfficeHeader'))
			return false;

		return true;
	}

	public function uninstall()
	{
		Configuration::deleteByName('uhu_css_2012_front_panel');
		Configuration::deleteByName('uhu_css_2012_column');
		Configuration::deleteByName('uhu_responsive');

		if (!parent::uninstall())
			return false;
		return true;
	}

	public function getContent()
	{
		$this->_html = '';

		$this->postProcess();

		if (Configuration::get('uhu_css_2012_column') == '0')
		{
			Configuration::updateValue('uhu_css_2012_column', 1);
			$this->loadConfigFile('no');
		}
		$this->displayToolbar();
		$this->checkUpdate();
		$this->displayForm();

		return $this->_html;
	}

	public function hookDisplayBackOfficeHeader()
	{
		$this->context->controller->addJquery();
		$this->context->controller->addJS($this->_path.'views/js/admin.js');
		$this->context->controller->addJS(_PS_JS_DIR_.'jquery/plugins/jquery.colorpicker.js');
		$this->context->controller->addJS($this->_path.'js/jquery.cookie.js');
	}

	public function hookdisplayHeader($params)
	{
		//no use
		//$currency = $params['cookie']->id_currency;
		$this->context->controller->addCss($this->_path.'css/theme_style.css', 'all');

		/*
		// Uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			$this->context->controller->addCSS($this->_path.'css/live_configurator.css');
			$this->context->controller->addJS($this->_path.'js/live_configurator.js');
			$this->context->controller->addJS(_PS_JS_DIR_.'jquery/plugins/jquery.colorpicker.js');
			$this->context->controller->addJS($this->_path.'js/jquery.cookie.js');

			if (isset($_COOKIE['theme']))
				$this->context->controller->addCss($this->_path.'css/'.$_COOKIE['theme'].'.css', 'all');
			else
				$this->context->controller->addCss($this->_path.'css/'.Configuration::get('PS_UHU_THEME').'.css', 'all');
		}
		else
			$this->context->controller->addCss($this->_path.'css/'.Configuration::get('PS_UHU_THEME').'.css', 'all');
		*/

		// Addons
		$this->context->controller->addCss($this->_path.'css/'.Configuration::get('PS_UHU_THEME').'.css', 'all');

		$this->context->controller->addCss($this->_path.'css/style.css', 'all');
		$this->context->controller->addCSS($this->_path.'css/custom.css', 'all');
		$this->context->controller->addJS(($this->_path).'js/jquery.cycle2.min.js');
		$this->context->controller->addJqueryPlugin(array('bxslider'));
	}

	public function hookDisplayFooter()
	{
		$html = '';

		if (Tools::isSubmit('resetLiveConfigurator'))
		{
			if (isset($_COOKIE['body_bg']))
				setcookie('body_bg', '', time() - 3600);
			if (isset($_COOKIE['page_bg']))
				setcookie('page_bg', '', time() - 3600);
			if (isset($_COOKIE['header_bg']))
				setcookie('header_bg', '', time() - 3600);
			if (isset($_COOKIE['footer_bg']))
				setcookie('footer_bg', '', time() - 3600);

			if (isset($_COOKIE['headings_bgcolor']))
				setcookie('headings_bgcolor', '', time() - 3600);
			if (isset($_COOKIE['menu_bgcolor']))
				setcookie('menu_bgcolor', '', time() - 3600);
			if (isset($_COOKIE['button_bgcolor']))
				setcookie('button_bgcolor', '', time() - 3600);
			if (isset($_COOKIE['cart_iconbg']))
				setcookie('cart_iconbg', '', time() - 3600);

			if (isset($_COOKIE['body_Textcolor0']))
				setcookie('body_Textcolor0', '', time() - 3600);
			if (isset($_COOKIE['header_text']))
				setcookie('header_text', '', time() - 3600);
			if (isset($_COOKIE['footer_text']))
				setcookie('footer_text', '', time() - 3600);
			if (isset($_COOKIE['menu_color']))
				setcookie('menu_color', '', time() - 3600);

			if (isset($_COOKIE['headings_color']))
				setcookie('headings_color', '', time() - 3600);
			if (isset($_COOKIE['product_des']))
				setcookie('product_des', '', time() - 3600);
			if (isset($_COOKIE['product_price']))
				setcookie('product_price', '', time() - 3600);
			if (isset($_COOKIE['button_color']))
				setcookie('button_color', '', time() - 3600);

			if (isset($_COOKIE['body_Linkcolor0']))
				setcookie('body_Linkcolor0', '', time() - 3600);
			if (isset($_COOKIE['header_link']))
				setcookie('header_link', '', time() - 3600);
			if (isset($_COOKIE['footer_link']))
				setcookie('footer_link', '', time() - 3600);
			if (isset($_COOKIE['product_title']))
				setcookie('product_title', '', time() - 3600);

			if (isset($_COOKIE['all_icon']))
				setcookie('all_icon', '', time() - 3600);
			if (isset($_COOKIE['head_icon']))
				setcookie('head_icon', '', time() - 3600);
			if (isset($_COOKIE['foot_icon']))
				setcookie('foot_icon', '', time() - 3600);
			if (isset($_COOKIE['cart_icon']))
				setcookie('cart_icon', '', time() - 3600);

		}

		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (Tools::isSubmit('submitLiveConfigurator'))
			{
				if (Tools::getValue('body_bg') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_16', Tools::getValue('body_bg'));
				if (Tools::getValue('page_bg') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_19', Tools::getValue('page_bg'));
				if (Tools::getValue('header_bg') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_22', Tools::getValue('header_bg'));
				if (Tools::getValue('footer_bg') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_25', Tools::getValue('footer_bg'));
				if (Tools::getValue('headings_bgcolor') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_34', Tools::getValue('headings_bgcolor'));
				if (Tools::getValue('menu_bgcolor') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_44', Tools::getValue('menu_bgcolor'));
				if (Tools::getValue('button_bgcolor') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_32', Tools::getValue('button_bgcolor'));
				if (Tools::getValue('cart_iconbg') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_56', Tools::getValue('cart_iconbg'));

				if (Tools::getValue('body_Textcolor0') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_10', Tools::getValue('body_Textcolor0'));
				if (Tools::getValue('header_text') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_12', Tools::getValue('header_text'));
				if (Tools::getValue('footer_text') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_14', Tools::getValue('footer_text'));
				if (Tools::getValue('menu_color') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_28', Tools::getValue('menu_color'));
				if (Tools::getValue('headings_color') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_33', Tools::getValue('headings_color'));
				if (Tools::getValue('product_des') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_53', Tools::getValue('product_des'));
				if (Tools::getValue('product_price') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_30', Tools::getValue('product_price'));
				if (Tools::getValue('button_color') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_31', Tools::getValue('button_color'));

				if (Tools::getValue('body_Linkcolor0') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_11', Tools::getValue('body_Linkcolor0'));
				if (Tools::getValue('header_link') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_13', Tools::getValue('header_link'));
				if (Tools::getValue('footer_link') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_15', Tools::getValue('footer_link'));
				if (Tools::getValue('product_title') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_29', Tools::getValue('product_title'));

				if (Tools::getValue('all_icon') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_40', Tools::getValue('all_icon'));
				if (Tools::getValue('head_icon') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_41', Tools::getValue('head_icon'));
				if (Tools::getValue('foot_icon') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_42', Tools::getValue('foot_icon'));
				if (Tools::getValue('cart_icon') <> 'transparent')
					Configuration::updateValue('uhu_modvalue_setting_49', Tools::getValue('cart_icon'));
			}

			// background
			$this->smarty->assign('front_screenbg', Configuration::get('uhu_cssselect_8_0'));
			$this->smarty->assign('front_pagebg', Configuration::get('uhu_cssselect_8_1'));
			$this->smarty->assign('front_headerbg', Configuration::get('uhu_cssselect_3_91'));
			$this->smarty->assign('front_footerbg', Configuration::get('uhu_cssselect_8_3'));
			$this->smarty->assign('front_headingscolor', Configuration::get('uhu_cssselect_8_11'));
			$this->smarty->assign('front_menubarbgcolor', Configuration::get('uhu_cssselect_8_23'));
			$this->smarty->assign('front_buttons', Configuration::get('uhu_cssselect_8_10'));
			$this->smarty->assign('front_carticon', Configuration::get('uhu_cssselect_8_28'));

			// text
			$this->smarty->assign('front_textcolor', Configuration::get('uhu_cssselect_8_0'));
			$this->smarty->assign('front_headertext', Configuration::get('uhu_cssselect_8_6'));
			$this->smarty->assign('front_footertext', Configuration::get('uhu_cssselect_3_5'));
			$this->smarty->assign('front_menubartext', Configuration::get('uhu_cssselect_8_24'));
			$this->smarty->assign('front_headingstext', Configuration::get('uhu_cssselect_8_40'));
			$this->smarty->assign('front_productdes', Configuration::get('uhu_cssselect_8_30'));
			$this->smarty->assign('front_productprice', Configuration::get('uhu_cssselect_8_15'));

			// link
			$this->smarty->assign('front_linkcolor', Configuration::get('uhu_cssselect_8_5'));
			$this->smarty->assign('front_headerlink', Configuration::get('uhu_cssselect_8_7'));
			$this->smarty->assign('front_footerlink', Configuration::get('uhu_cssselect_3_8'));
			$this->smarty->assign('front_producttitle', Configuration::get('uhu_cssselect_8_14'));

			// Icon
			$this->smarty->assign('front_icon', Configuration::get('uhu_cssselect_8_20'));
			$this->smarty->assign('front_headericon', Configuration::get('uhu_cssselect_8_21'));
			$this->smarty->assign('front_footericon', Configuration::get('uhu_cssselect_8_22'));

			$this->smarty->assign(array(
				'themes' => explode('|', Configuration::get('uhu_modvalue_setting_3')),
				'colors' => explode('|', Configuration::get('uhu_modvalue_setting_4')),
				'theme_save' => Configuration::get('uhu_css_2012_front_save'),
				'theme_type' => Configuration::get('uhu_css_2012_front_type')
			));

			$html .= $this->display(__FILE__, 'live_configurator.tpl');
		}

		$this->smarty->assign('gfont_logo', Configuration::get('uhu_modvalue_logo_4'));
		$this->smarty->assign('logoMode', Configuration::get('uhu_modvalue_logo_0'));
		$this->smarty->assign('logoImage', $this->context->link->protocol_content.Tools::getMediaServer($this->name).
									_MODULE_DIR_.$this->name.'/images/logo/'.Configuration::get('uhu_modvalue_logo_1'));

		return $html.$this->display(__FILE__, 'hook.tpl');
	}

	public function postProcess()
	{
		$errors = '';

		if (Tools::isSubmit('submitCustomColor'))
		{
			$file = '';

			/*
				Quick Setting
			*/
			//background
			$file .= $this->postProcessStyleBackground('16', '17', '18', '/images/body/');
			$file .= $this->postProcessStyleBackground('19', '20', '21', '/images/header/');
			$file .= $this->postProcessStyleBackground('22', '23', '24', '/images/columns/');
			$file .= $this->postProcessStyleBackground('25', '26', '27', '/images/footer/');
			// text
			$file .= $this->postProcessStyleColor(10);
			$file .= $this->postProcessStyleColor(12);
			$file .= $this->postProcessStyleColor(14);
			$file .= $this->postProcessStyleColor(53);
			$file .= $this->postProcessStyleColor(30);
			// link
			$file .= $this->postProcessStyleColor(11);
			$file .= $this->postProcessStyleColor(13);
			$file .= $this->postProcessStyleColor(15);
			$file .= $this->postProcessStyleColor(29);
			// headings
			$file .= $this->postProcessStyleColor(33);
			$file .= $this->postProcessStyleColor(34);
			$file .= $this->postProcessStyleColor(35);
			$file .= $this->postProcessStyleColor(50);
			$file .= $this->postProcessStyleColor(51);
			$file .= $this->postProcessStyleColor(52);
			// button
			$file .= $this->postProcessStyleColor(31);
			$file .= $this->postProcessStyleColor(32);
			// menu
			$file .= $this->postProcessStyleColor(28);
			$file .= $this->postProcessStyleColor(43);
			$file .= $this->postProcessStyleColor(44);
			$file .= $this->postProcessStyleColor(45);
			$file .= $this->postProcessStyleColor(46);
			$file .= $this->postProcessStyleColor(47);
			$file .= $this->postProcessStyleColor(48);
			// icon
			$file .= $this->postProcessStyleColor(40);
			$file .= $this->postProcessStyleColor(41);
			$file .= $this->postProcessStyleColor(42);
			$file .= $this->postProcessStyleColor(49);
			$file .= $this->postProcessStyleColor(56);
			$file .= $this->postProcessStyleColor(54);
			$file .= $this->postProcessStyleColor(55);
			// border
			$file .= $this->postProcessStyleColor(5);
			$file .= $this->postProcessStyleColor(6);
			$file .= $this->postProcessStyleColor(7);
			$file .= $this->postProcessStyleColor(57);
			$file .= $this->postProcessStyleColor(59);
			$file .= $this->postProcessStyleColor(58);
			// input & message
			$file .= $this->postProcessStyleColor(36);
			$file .= $this->postProcessStyleColor(37);
			$file .= $this->postProcessStyleColor(9);
			$file .= $this->postProcessStyleColor(38);
			$file .= $this->postProcessStyleColor(39);
			$file .= $this->postProcessStyleColor(8);

			/*
				Style Setting
			*/
			for ($i = 60; $i < 400; $i++)
				$file .= $this->postProcessStyleColor($i);

			/*
				Logo
			*/
			Configuration::updateValue('uhu_modvalue_logo_0', Tools::getValue('logo_type'));
			Configuration::updateValue('uhu_modvalue_logo_1', Tools::getValue('logo_pattern'));
			Configuration::updateValue('uhu_modvalue_logo_2', Tools::getValue('logo_name'));

			Configuration::updateValue('PS_SHOP_NAME', Configuration::get('uhu_modvalue_logo_2'));

			$this->all_logos = '#header_logo a#logo_text';
			$file .= $this->postProcessCSSCode(3, 'logo_color', $this->all_logos, 'color', 'logo');
			$file .= $this->postProcessCSSCode(4, 'logo_font', $this->all_logos, 'font-family', 'logo');
			$file .= $this->postProcessCSSCode(5, 'logo_size', $this->all_logos, 'font-size', 'logo');
			$file .= $this->postProcessCSSCode(6, 'logo_top', '#header_logo', 'top', 'logo');
			$file .= $this->postProcessCSSCode(7, 'logo_left', '#header_logo', 'left', 'logo');

			// custom css
			$customcss = Tools::getValue('customcss');
			Configuration::updateValue('uhu_custom_css', $customcss);

			$fp = fopen(_PS_ROOT_DIR_.'/modules/uhu_setting/css/style.css', 'wb');
			fputs($fp, $file);
			fputs($fp, $customcss);
			fclose($fp);
		}

		/*
			保存插件内容配置
		*/
		if (Tools::isSubmit('submitCustomConfig'))
		{
			for ($i = 0; $i < Configuration::get('uhu_mod_number'); $i++)
			{
				$moduletitle = Configuration::get('uhu_mod_title_'.$i);
				if (strstr($moduletitle, 'uhu_') <> '' && strstr($moduletitle, '全局') == '')
				{
					$module = Module::getInstanceByName($moduletitle);
					if ($module <> false && $module->active)
					{
						for ($j = 0; $j < Configuration::get('uhu_mod_total_'.$i); $j++)
						{
							$tab_id = Configuration::get('uhu_mod_id_'.$i).'_'.$j;
							if (Configuration::get('uhu_moddisplay_'.$tab_id) == 'true')
							{
								$input_id = Configuration::get('uhu_modid_'.$tab_id);
								Configuration::updateValue('uhu_modvalue_'.$tab_id, Tools::getValue($input_id));
							}
						}
					}
				}
				if ($moduletitle == 'uhu_topmenu')
					$this->updateCustomMenu();
			}
		}

		if (Tools::isSubmit('submitChoiseThemeColor'))
		{
			$selected_theme_name = Tools::getValue('selected_theme_color');
			Configuration::updateValue('PS_UHU_THEME', $selected_theme_name);
		}

		if (Tools::isSubmit('loadSystemConfig'))
			$this->loadConfigFile('no');

		if (Tools::isSubmit('submitUpdatePanel'))
		{
			Configuration::updateValue('uhu_css_2012_front_panel', Tools::getValue('front_panel'));
			Configuration::updateValue('uhu_css_2012_front_save', Tools::getValue('front_save'));
		}
		else
		{
			$this->checkUploadSubmit('body', '/images/body/');
			$this->checkUploadSubmit('header', '/images/header/');
			$this->checkUploadSubmit('columns', '/images/columns/');
			$this->checkUploadSubmit('footer', '/images/footer/');
			$this->checkUploadSubmit('logo', '/images/logo/');

			$this->checkUploadModules();
		}

		if ($errors)
			echo $this->displayError($errors);
	}

	private function updateCustomMenu()
	{
		$mod_id = 27;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
		$itme1 = Configuration::get('uhu_modvalue_'.$mod_name.'_25');
		$itme2 = Configuration::get('uhu_modvalue_'.$mod_name.'_33');
		$itme3 = Configuration::get('uhu_modvalue_'.$mod_name.'_37');

		$menu_items = 'CAT'.$itme1.',CAT'.$itme2.',CAT'.$itme3.',';
		$items = explode(',', Configuration::get('uhu_modvalue_'.$mod_name.'_30'));
		foreach ($items as $item)
		{
			if (!$item)
				continue;
			$menu_items .= 'CATA'.$item.',';
		}
		$items = explode(',', Configuration::get('uhu_modvalue_'.$mod_name.'_34'));
		foreach ($items as $item)
		{
			if (!$item)
				continue;
			$menu_items .= 'CATB'.$item.',';
		}
		$items = explode(',', Configuration::get('uhu_modvalue_'.$mod_name.'_38'));
		foreach ($items as $item)
		{
			if (!$item)
				continue;
			$menu_items .= 'CATC'.$item.',';
		}
		Configuration::updateValue('uhu_modvalue_'.$mod_name.'_12', $menu_items);

		// images
		$image_items = 'CATA:'.Configuration::get('uhu_modvalue_'.$mod_name.'_31').'|';
		$image_items .= 'CATB:'.Configuration::get('uhu_modvalue_'.$mod_name.'_35').'|';
		$image_items .= 'CATC:'.Configuration::get('uhu_modvalue_'.$mod_name.'_39');
		Configuration::updateValue('uhu_modvalue_'.$mod_name.'_28', $image_items);

		// links
		$link_items = 'CATA:'.Configuration::get('uhu_modvalue_'.$mod_name.'_32').'|';
		$link_items .= 'CATB:'.Configuration::get('uhu_modvalue_'.$mod_name.'_36').'|';
		$link_items .= 'CATC:'.Configuration::get('uhu_modvalue_'.$mod_name.'_40');
		Configuration::updateValue('uhu_modvalue_'.$mod_name.'_29', $link_items);
	}

	private function checkUploadSubmit($css_id, $imagefolder)
	{
		$errors = array();
		if (Tools::isSubmit('submitBackpattern_'.$css_id))
		{
			if (isset($_FILES[$css_id.'_file']) && isset($_FILES[$css_id.'_file']['tmp_name']) && !empty($_FILES[$css_id.'_file']['tmp_name']))
			{
				if ($error = ImageManager::validateUpload($_FILES[$css_id.'_file'], Tools::convertBytes(ini_get('upload_max_filesize'))))
					$errors .= $error;
				else
				{
					$fname = explode('/', $imagefolder);

					$path = _PS_MODULE_DIR_.'/'.$this->name.'/'.$fname[1].'/'.$fname[2];
					if (!is_dir($path))
					{
						mkdir($path, 0755);

						$s_dir = _PS_MODULE_DIR_.'/'.$this->name.'/images/index.php';
						$d_dir = $path.'/index.php';
						copy($s_dir, $d_dir);

						$s_dir = _PS_MODULE_DIR_.'/'.$this->name.'/images/0_noimage.gif';
						$d_dir = $path.'/0_noimage.gif';
						copy($s_dir, $d_dir);
					}

					if (count($fname) > 3)
					{
						$path = _PS_MODULE_DIR_.'/'.$this->name.'/'.$fname[1].'/'.$fname[2].'/'.$fname[3];
						if (!is_dir($path))
						{
							mkdir($path, 0755);

							$s_dir = _PS_MODULE_DIR_.'/'.$this->name.'/images/index.php';
							$d_dir = $path.'/index.php';
							copy($s_dir, $d_dir);

							$s_dir = _PS_MODULE_DIR_.'/'.$this->name.'/images/0_noimage.gif';
							$d_dir = $path.'/0_noimage.gif';
							copy($s_dir, $d_dir);

						}
					}
					if (!move_uploaded_file($_FILES[$css_id.'_file']['tmp_name'],
						_PS_MODULE_DIR_.'/'.$this->name.$imagefolder.$_FILES[$css_id.'_file']['name']))
						$errors .= $this->l('Error move uploaded file');
				}
			}
		}
	}

	private function checkUploadModules()
	{
		for ($i = 0; $i < Configuration::get('uhu_mod_number'); $i++)
			if (Configuration::get('uhu_mod_adver_'.$i) == 'true')
				$this->checkUploadSubmit('adv_'.Configuration::get('uhu_mod_id_'.$i), '/images/'.Configuration::get('uhu_mod_id_'.$i).'/');
	}

	private function postProcessStyleColor($m_id, $m_name = 'setting')
	{
		$css_id = Configuration::get('uhu_modid_'.$m_name.'_'.$m_id);
		$csstitle = Configuration::get('uhu_moddisplay_'.$m_name.'_'.$m_id);
		$selectors = Configuration::get('uhu_moddesp_'.$m_name.'_'.$m_id);
		$cssvalue = Tools::getValue($css_id);
		Configuration::updateValue('uhu_modvalue_'.$m_name.'_'.$m_id, $cssvalue);

		$code = '';
		if ($cssvalue <> '' && $csstitle <> '' && $selectors <> '')
			$code = $selectors.' {'.$csstitle.':'.$cssvalue.";}\n";

		return $code;
	}

	private function postProcessCSSCode($m_id, $css_id, $selectors, $csstitle, $m_name = 'setting')
	{
		$cssvalue = Tools::getValue($css_id);
		Configuration::updateValue('uhu_modvalue_'.$m_name.'_'.$m_id, $cssvalue);

		$code = '';
		if ($cssvalue <> '' && $csstitle <> '' && $selectors <> '')
			$code = $selectors.' {'.$csstitle.':'.$cssvalue.";}\n";

		return $code;
	}

	private function postProcessStyleBackground($m_bg, $m_pattern, $m_bgpos, $imagefolder)
	{
		$m_name = 'setting';

		$css_bg = Configuration::get('uhu_modid_'.$m_name.'_'.$m_bg);
		$css_pattern = Configuration::get('uhu_modid_'.$m_name.'_'.$m_pattern);
		$css_bgpos = Configuration::get('uhu_modid_'.$m_name.'_'.$m_bgpos);

		$csstitle = Configuration::get('uhu_moddisplay_'.$m_name.'_'.$m_bg);
		//$cssid = Configuration::get('uhu_modinfo_'.$m_name.'_'.$m_bg);

		$selectors = Configuration::get('uhu_moddesp_'.$m_name.'_'.$m_bg);
		//$selectors = Configuration::get('uhu_'.$cssid);

		Configuration::updateValue('uhu_modvalue_setting_'.$m_bg, Tools::getValue($css_bg));
		Configuration::updateValue('uhu_modvalue_setting_'.$m_pattern, Tools::getValue($css_pattern));
		Configuration::updateValue('uhu_modvalue_setting_'.$m_bgpos, Tools::getValue($css_bgpos));

		$cssvalue = '';
		if (Configuration::get('uhu_modvalue_setting_'.$m_bg))
			$cssvalue .= Configuration::get('uhu_modvalue_setting_'.$m_bg);

		if (Configuration::get('uhu_modvalue_setting_'.$m_pattern) <> '0_noimage.gif' && Configuration::get('uhu_modvalue_setting_'.$m_pattern) <> '')
		{
			$cssvalue .= ' url(..'.$imagefolder.Configuration::get('uhu_modvalue_setting_'.$m_pattern).')';
			$cssvalue .= ' '.Configuration::get('uhu_modvalue_setting_'.$m_bgpos);
		}

		$code = '';
		if ($cssvalue <> '' && $csstitle <> '' && $selectors <> '')
			$code = $selectors.' {'.$csstitle.':'.$cssvalue.";}\n";

		return $code;
	}

	private function postProcessCSSCodePattern($m_bg, $m_pattern, $m_bgpos, $css_id, $imagefolder, $selectors, $csstitle)
	{
		Configuration::updateValue('uhu_modvalue_setting_'.$m_bg, Tools::getValue($css_id.'_bg'));
		Configuration::updateValue('uhu_modvalue_setting_'.$m_pattern, Tools::getValue($css_id.'_pattern'));
		Configuration::updateValue('uhu_modvalue_setting_'.$m_bgpos, Tools::getValue($css_id.'_bgpos'));

		$cssvalue = '';
		if (Configuration::get('uhu_modvalue_setting_'.$m_bg))
			$cssvalue .= Configuration::get('uhu_modvalue_setting_'.$m_bg);

		if (Configuration::get('uhu_modvalue_setting_'.$m_pattern) <> '0_noimage.gif' && Configuration::get('uhu_modvalue_setting_'.$m_pattern) <> '')
		{
			$cssvalue .= ' url(..'.$imagefolder.Configuration::get('uhu_modvalue_setting_'.$m_pattern).')';
			$cssvalue .= ' '.Configuration::get('uhu_modvalue_setting_'.$m_bgpos);
		}

		$code = '';
		if ($cssvalue <> '' && $csstitle <> '' && $selectors <> '')
			$code = $selectors.' {'.$csstitle.':'.$cssvalue.";}\n";

		return $code;
	}

	private function displayToolbar()
	{
		if (_PS_VERSION_ < 1.6)
		{
			$this->_html .= '<script type="text/javascript">';
			$this->_html .= "$(document).ready(function() {
								$('#content').addClass('bootstrap');
								$('div.productTabs').find('a').each(function() { $(this).attr('href', '#');	});
								$('div.productTabs a').click(function() {
									var id = $(this).attr('id');
									$('.nav-profile').removeClass('active');
									$(this).addClass('active');
									$('.tab-profile').hide();
									$('.'+id).show();
									});
							});";
			$this->_html .= '</script>';

			$this->_html .= '
							<div class="toolbar-placeholder">
								<div class="toolbarBox toolbarHead">
									<ul class="my_button" style="float: right;">
										<li style="color:#666666; float:left; height:48px;
											list-style: none outside none; padding: 1px 1px 3px 4px; text-align: center;">
											<a id="desc-doc-help" class="toolbar_btn" href="http://doc.uhupage.com"
												title="Document" style="display: block; " >
												<span class="process-icon-export "></span>
												<div>Document</div>
											</a>
										</li>
									</ul>';

			$this->_html .= '
									<div class="pageTitle">
										<h2><span id="current_obj" style="font-weight: normal;">
											<span class="breadcrumb item-2 ">Theme Setting</span> v'.$this->version.'</span>
										</h2>
									</div>
								</div>
							</div>';
		}
		else
		{
			$this->_html .= '<script type="text/javascript">';
			$this->_html .= "$(document).ready(function() {
								$('div.productTabs').find('a').each(function() { $(this).attr('href', '#');	});
								$('div.productTabs a').click(function() {
									var id = $(this).attr('id');
									$('.nav-profile').removeClass('active');
									$(this).addClass('active');
									$('.tab-profile').hide();
									$('.'+id).show();
									});
							});";
			$this->_html .= '</script>';
		}
	}

	private function checkUpdate()
	{
		// Addons
		$update_messages = 'A new version of this theme is available, please contact us for it!<br>';

		// Uhupage
		//$theme_name = Configuration::get('uhu_modvalue_setting_0');
		//$vals = explode('|', Configuration::get('uhu_modvalue_setting_1'));
		//$theme_version = $vals[0];
		//$update_messages = Tools::file_get_contents('http://www.uhupage.com/upload/'.$theme_name.'/'.$theme_version.'/update.txt');

		if ($update_messages <> '')
		{
			$this->_html .= '<div id="blockNewVersionCheck" class="alert alert-info">';
			$this->_html .= $update_messages;
			$this->_html .= '</div>';
		}
	}

	private function displayForm()
	{
		$this->_html .= '<div class="row">';

		$this->_html .= '<div class="productTabs col-lg-2">
							<div class="tab list-group">';

		$this->_html .= '		<span class="nav-profile list-group-item" style="font-size: 14px; background-color: #fcfdfe;"><i class="icon-cogs" style="font-size:20px;"></i> Configure</span>';
		$this->_html .= '		<a class="nav-profile list-group-item active" id="profile-0" href="#">'.$this->l('General').'</a>';

		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-11" href="#">'.$this->l('Top Menu').'</a>';

		$moduletitle = 'uhu_bxslider';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->_html .= '		<a class="nav-profile list-group-item " id="profile-13" href="#">'.$this->l('Image Slider: Bxslider').'</a>';

		$moduletitle = 'uhu_cycleslider';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->_html .= '		<a class="nav-profile list-group-item " id="profile-14" href="#">'.$this->l('Image Slider: Cycle2').'</a>';

		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-15" href="#">'.$this->l('Featured Product').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-17" href="#">'.$this->l('New Product').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-19" href="#">'.$this->l('Advertising').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-21" href="#">'.$this->l('Best Seller').'</a>';

		$moduletitle = 'uhu_catfeatured';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->_html .= '		<a class="nav-profile list-group-item " id="profile-22" href="#">'.$this->l('Hot Categories').'</a>';

		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-30" href="#">'.$this->l('Header').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-39" href="#">'.$this->l('Footer').'</a>';

		$this->_html .= '		<span class="nav-profile list-group-item" style="font-size: 14px; background-color: #fcfdfe;"><i class="icon-wrench" style="font-size:20px;"></i> Color</span>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-50" href="#">'.$this->l('General').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-54" href="#">'.$this->l('Header').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-55" href="#">'.$this->l('Content').'</a>';

		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-60" href="#">'.$this->l('Footer').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-61" href="#">'.$this->l('Top Menu').'</a>';

		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-70" href="#">'.$this->l('Category Page').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-71" href="#">'.$this->l('Product Page').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-72" href="#">'.$this->l('Order Page').'</a>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-73" href="#">'.$this->l('Left&Right Column').'</a>';

		$this->_html .= '		<span class="nav-profile list-group-item" style="font-size: 14px; background-color: #fcfdfe;"><i class="icon-edit" style="font-size:20px;"></i> Custom</span>';
		$this->_html .= '		<a class="nav-profile list-group-item " id="profile-99" href="#">'.$this->l('CSS code').'</a>
							</div>
						</div>';

		$this->_html .= '<form class="form-horizontal col-lg-10" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">';
		$this->displayFormTabConfig(0);
		$this->_html .= '</form>';

		$this->_html .= '<form class="form-horizontal col-lg-10" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">';
		$this->displayFormTabTopmenu(11);
		$this->displayFormTabSliderBX(13);
		$this->displayFormTabSliderCY(14);
		$this->displayFormTabFeatured(15);
		$this->displayFormTabNew(17);
		$this->displayFormTabAdvertising(19);
		$this->displayFormTabBest(21);
		$this->displayFormTabHotcategory(22);
		$this->displayFormTabHeader(30);
		$this->displayFormTabFooter(39);
		$this->_html .= '</form>';

		$this->_html .= '<form class="form-horizontal col-lg-10" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">';
		$this->displayFormTabGeneralColor(50);
		$this->displayFormTabHeaderColor(54);
		$this->displayFormTabContentColor(55);
		$this->displayFormTabFooterColor(60);

		$this->displayFormTabTopmenuColor(61);

		$this->displayFormTabCategoryPageColor(70);
		$this->displayFormTabProductPageColor(71);
		$this->displayFormTabOrderPageColor(72);
		$this->displayFormTabLeftRightColor(73);
		$this->_html .= '</form>';

		$this->_html .= '<form class="form-horizontal col-lg-10" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">';
		$this->displayFormTabCustom(99);
		$this->_html .= '</form>';

		$this->_html .= '</div>';
	}

	private function displayFormTabGeneralColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Global').'</h3>';
		$this->displayStyleColor(10);
		$this->displayStyleColor(11);
		$this->displayStyleColor(348);
		$this->displayStyleColor(40);

		$this->_html .= '<h3>'.$this->l('Screen Background').'</h3>';
		$this->displayStylePattern('16', '17', '18', 'body', '/images/body/');

		$this->_html .= '<h3>'.$this->l('Button').'</h3>';
		$this->displayStyleColor(31);
		$this->displayStyleColor(32);

		$this->_html .= '<h3>'.$this->l('Input & Message').'</h3>';
		$this->displayStyleColor(36);
		$this->displayStyleColor(37);
		$this->displayStyleColor(9);
		$this->displayStyleColor(38);
		$this->displayStyleColor(39);
		$this->displayStyleColor(8);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '	<div class="form-group">';
		$this->_html .= '		<label class="control-label col-lg-3"></label>';
		$this->_html .= '		<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>
								</div>';
		$this->_html .= '	</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabHeaderColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Global').'</h3>';
		$this->displayStyleColor(12);
		$this->displayStyleColor(13);
		$this->displayStyleColor(57);
		$this->displayStyleColor(41);

		$this->_html .= '<h3>'.$this->l('Header Background').'</h3>';
		$this->displayStylePattern('19', '20', '21', 'header', '/images/header/');

		$this->_html .= '<h3>'.$this->l('Navigation').'</h3>';
		$this->displayStyleColor(181);
		$this->displayStyleColor(303);
		$this->displayStyleColor(341);

		$this->_html .= '<h3>'.$this->l('Banner').'</h3>';
		$this->displayStyleColor(377);

		$this->_html .= '<h3>'.$this->l('Head Content').'</h3>';
		$this->displayStyleColor(376);

		$this->_html .= '<h3>'.$this->l('Languages').'</h3>';
		$this->displayStyleColor(64);
		$this->displayStyleColor(65);
		$this->displayStyleColor(66);
		$this->displayStyleColor(67);
		$this->displayStyleColor(68);
		$this->displayStyleColor(69);

		$this->_html .= '<h3>'.$this->l('Currencies').'</h3>';
		$this->displayStyleColor(70);
		$this->displayStyleColor(71);
		$this->displayStyleColor(72);
		$this->displayStyleColor(73);
		$this->displayStyleColor(74);
		$this->displayStyleColor(75);

		$this->_html .= '<h3>'.$this->l('Search').'</h3>';
		$this->displayStyleColor(76);
		$this->displayStyleColor(77);
		$this->displayStyleColor(78);
		$this->displayStyleColor(79);
		$this->displayStyleColor(180);

		$this->_html .= '<h3>'.$this->l('Cart').'</h3>';
		$this->displayStyleColor(257);
		$this->displayStyleColor(258);
		$this->displayStyleColor(259);
		$this->displayStyleColor(260);
		$this->displayStyleColor(261);
		$this->displayStyleColor(262);
		$this->displayStyleColor(263);
		$this->displayStyleColor(264);
		$this->displayStyleColor(265);
		$this->displayStyleColor(266);
		$this->displayStyleColor(267);
		$this->displayStyleColor(268);

		$this->_html .= '<h3>'.$this->l('User info').'</h3>';
		$this->displayStyleColor(60);
		$this->displayStyleColor(61);
		$this->displayStyleColor(62);
		$this->displayStyleColor(63);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '	<div class="form-group">';
		$this->_html .= '		<label class="control-label col-lg-3"></label>';
		$this->_html .= '		<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>
								</div>';
		$this->_html .= '	</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabFooterColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Global').'</h3>';
		$this->displayStyleColor(14);
		$this->displayStyleColor(15);
		$this->displayStyleColor(256);
		$this->displayStyleColor(50);
		$this->displayStyleColor(51);
		$this->displayStyleColor(52);
		$this->displayStyleColor(59);
		$this->displayStyleColor(42);
		$this->displayStyleColor(80);

		$this->_html .= '<h3>'.$this->l('Footer Background').'</h3>';
		$this->displayStylePattern('25', '26', '27', 'footer', '/images/footer/');

		$this->_html .= '<h3>'.$this->l('Background').'</h3>';
		$this->displayStyleColor(269);
		$this->displayStyleColor(81);
		$this->displayStyleColor(335);

		$this->_html .= '<h3>'.$this->l('Border').'</h3>';
		$this->displayStyleColor(380);
		$this->displayStyleColor(381);
		$this->displayStyleColor(382);

		$this->_html .= '<h3>'.$this->l('Reassure').'</h3>';
		for ($id = 142; $id <= 145; $id++)
			$this->displayStyleColor($id);
		$this->displayStyleColor(379);

		$this->_html .= '<h3>'.$this->l('Cms').'</h3>';
		$this->displayStyleColor(146);
		$this->displayStyleColor(147);
		$this->displayStyleColor(347);

		$this->_html .= '<h3>'.$this->l('My account').'</h3>';
		$this->displayStyleColor(148);
		$this->displayStyleColor(149);

		$this->_html .= '<h3>'.$this->l('Facebook').'</h3>';
		$this->displayStyleColor(150);
		$this->displayStyleColor(151);

		$this->_html .= '<h3>'.$this->l('Twitters').'</h3>';
		$this->displayStyleColor(152);
		$this->displayStyleColor(153);

		$this->_html .= '<h3>'.$this->l('Contact us').'</h3>';
		$this->displayStyleColor(154);
		$this->displayStyleColor(155);
		$this->displayStyleColor(177);

		$this->_html .= '<h3>'.$this->l('Copyright').'</h3>';
		$this->displayStyleColor(178);
		$this->displayStyleColor(179);

		$this->_html .= '<h3>'.$this->l('Newsletter').'</h3>';
		$this->displayStyleColor(336);
		$this->displayStyleColor(337);
		$this->displayStyleColor(338);
		$this->displayStyleColor(339);
		$this->displayStyleColor(340);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '	<div class="form-group">';
		$this->_html .= '		<label class="control-label col-lg-3"></label>';
		$this->_html .= '		<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>
								</div>';
		$this->_html .= '	</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabContentColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Global').'</h3>';
		$this->displayStyleColor(367);
		$this->displayStyleColor(363);
		$this->displayStyleColor(364);
		$this->displayStyleColor(365);
		$this->displayStyleColor(371);
		$this->displayStyleColor(5);
		$this->displayStyleColor(6);
		$this->displayStyleColor(7);
		$this->displayStyleColor(58);
		$this->displayStyleColor(29);
		$this->displayStyleColor(30);
		$this->displayStyleColor(53);
		$this->displayStyleColor(49);
		$this->displayStyleColor(56);
		$this->displayStyleColor(54);
		$this->displayStyleColor(55);
		$this->displayStyleColor(383);
		$this->displayStyleColor(384);
		$this->displayStyleColor(385);
		$this->displayStyleColor(399);

		$this->_html .= '<h3>'.$this->l('Page Background').'</h3>';
		$this->displayStylePattern('22', '23', '24', 'columns', '/images/columns/');

		$this->_html .= '<h3>'.$this->l('Background').'</h3>';
		$this->displayStyleColor(378);
		$this->displayStyleColor(392);
		$this->displayStyleColor(195);

		$moduletitle = 'uhu_featured';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->_html .= '<h3>'.$this->l('Featured Product').'</h3>';
			for ($id = 82; $id <= 97; $id++)
				$this->displayStyleColor($id);
			$this->displayStyleColor(391);
			$this->displayStyleColor(182);
			$this->displayStyleColor(183);
			$this->displayStyleColor(298);
		}

		$moduletitle = 'uhu_bxfeatured';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->_html .= '<h3>'.$this->l('Featured Product with slider').'</h3>';
			for ($id = 110; $id <= 125; $id++)
				$this->displayStyleColor($id);
			$this->displayStyleColor(254);
			$this->displayStyleColor(255);
			$this->displayStyleColor(299);
		}

		$this->_html .= '<h3>'.$this->l('Best Seller').'</h3>';
		for ($id = 98; $id <= 109; $id++)
			$this->displayStyleColor($id);
		$this->displayStyleColor(372);
		$this->displayStyleColor(373);
		$this->displayStyleColor(374);
		$this->displayStyleColor(375);

		$this->_html .= '<h3>'.$this->l('New products in Categories').'</h3>';
		for ($id = 126; $id <= 141; $id++)
			$this->displayStyleColor($id);
		$this->displayStyleColor(300);
		$this->displayStyleColor(301);
		$this->displayStyleColor(386);

		$moduletitle = 'uhu_uhu_bxslider';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->_html .= '<h3>'.$this->l('Image Slider with Bxslider').'</h3>';
			$this->displayStyleColor(349);
			$this->displayStyleColor(158);
			$this->displayStyleColor(159);
		}

		$moduletitle = 'uhu_cycleslider';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->_html .= '<h3>'.$this->l('Image Slider with Cycle2').'</h3>';
			$this->displayStyleColor(350);
			$this->displayStyleColor(351);
			$this->displayStyleColor(352);
			$this->displayStyleColor(353);
			$this->displayStyleColor(354);
			$this->displayStyleColor(355);
			$this->displayStyleColor(356);
			$this->displayStyleColor(357);
			$this->displayStyleColor(358);
			$this->displayStyleColor(359);
			$this->displayStyleColor(160);
			$this->displayStyleColor(161);
		}

		$this->_html .= '<h3>'.$this->l('Advertising').'</h3>';
		$moduletitle = 'uhu_gj_1901';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayStyleColor(342);

		$moduletitle = 'uhu_gj_9511';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->displayStyleColor(343);
			$this->displayStyleColor(393);
		}

		$moduletitle = 'uhu_gj_9521';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->displayStyleColor(344);
			$this->displayStyleColor(394);
		}

		$moduletitle = 'uhu_gj_9531';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->displayStyleColor(345);
			$this->displayStyleColor(395);
		}

		$moduletitle = 'uhu_gj_9541';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->displayStyleColor(346);
			$this->displayStyleColor(396);
		}

		$moduletitle = 'uhu_gj_9551';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->displayStyleColor(360);
			$this->displayStyleColor(397);
		}

		$moduletitle = 'uhu_gj_9561';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
		{
			$this->displayStyleColor(361);
			$this->displayStyleColor(398);
		}

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/appearance.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
									class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabTopmenuColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Menu').'</h3>';
		$this->displayStyleColor(28);
		$this->displayStyleColor(43);
		$this->displayStyleColor(44);
		$this->displayStyleColor(45);
		$this->displayStyleColor(46);
		$this->displayStyleColor(47);
		$this->displayStyleColor(48);
		$this->displayStyleColor(302);
		$this->displayStyleColor(156);
		$this->displayStyleColor(157);
		$this->displayStyleColor(366);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '	<div class="form-group">';
		$this->_html .= '		<label class="control-label col-lg-3"></label>';
		$this->_html .= '		<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>
								</div>';
		$this->_html .= '	</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabCategoryPageColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Product Block').'</h3>';
		$this->displayStyleColor(184);
		$this->displayStyleColor(185);
		$this->displayStyleColor(369);
		$this->displayStyleColor(370);

		$this->_html .= '<h3>'.$this->l('Product Image').'</h3>';
		$this->displayStyleColor(209);

		$this->_html .= '<h3>'.$this->l('Product Name').'</h3>';
		$this->displayStyleColor(210);

		$this->_html .= '<h3>'.$this->l('Product Price').'</h3>';
		$this->displayStyleColor(211);
		$this->displayStyleColor(212);
		$this->displayStyleColor(213);

		$this->_html .= '<h3>'.$this->l('Product Description').'</h3>';
		$this->displayStyleColor(217);

		$this->_html .= '<h3>'.$this->l('New Label').'</h3>';
		$this->displayStyleColor(186);

		$this->_html .= '<h3>'.$this->l('In stock').'</h3>';
		$this->displayStyleColor(214);

		$this->_html .= '<h3>'.$this->l('Add to Cart').'</h3>';
		$this->displayStyleColor(191);
		$this->displayStyleColor(192);

		$this->_html .= '<h3>'.$this->l('View').'</h3>';
		$this->displayStyleColor(193);
		$this->displayStyleColor(194);

		$this->_html .= '<h3>'.$this->l('Add to Compare').'</h3>';
		$this->displayStyleColor(215);
		$this->displayStyleColor(216);

		$this->_html .= '<h3>'.$this->l('Sort by').'</h3>';
		$this->displayStyleColor(162);
		$this->displayStyleColor(163);
		$this->displayStyleColor(187);

		$this->_html .= '<h3>'.$this->l('Grid & List').'</h3>';
		$this->displayStyleColor(188);
		$this->displayStyleColor(189);
		$this->displayStyleColor(190);

		$this->_html .= '<h3>'.$this->l('Pagination').'</h3>';
		$this->displayStyleColor(164);
		$this->displayStyleColor(165);
		$this->displayStyleColor(304);
		$this->displayStyleColor(305);
		$this->displayStyleColor(306);
		$this->displayStyleColor(307);
		$this->displayStyleColor(308);
		$this->displayStyleColor(309);
		$this->displayStyleColor(310);
		$this->displayStyleColor(311);

		$this->_html .= '<h3>'.$this->l('Show all').'</h3>';
		$this->displayStyleColor(312);
		$this->displayStyleColor(313);
		$this->displayStyleColor(314);

		$this->_html .= '<h3>'.$this->l('Compare').'</h3>';
		$this->displayStyleColor(206);
		$this->displayStyleColor(207);
		$this->displayStyleColor(208);

		$this->_html .= '<h3>'.$this->l('Category Block').'</h3>';
		$this->displayStyleColor(219);
		$this->displayStyleColor(220);
		$this->displayStyleColor(221);
		$this->displayStyleColor(222);
		$this->displayStyleColor(387);
		$this->displayStyleColor(388);
		$this->displayStyleColor(223);
		$this->displayStyleColor(362);

		$this->_html .= '<h3>'.$this->l('Others').'</h3>';
		$this->displayStyleColor(218);
		$this->displayStyleColor(368);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '	<div class="form-group">';
		$this->_html .= '		<label class="control-label col-lg-3"></label>';
		$this->_html .= '		<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>
								</div>';
		$this->_html .= '	</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabProductPageColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Product Block').'</h3>';
		$this->displayStyleColor(390);

		$this->_html .= '<h3>'.$this->l('Product Title').'</h3>';
		$this->displayStyleColor(170);

		$this->_html .= '<h3>'.$this->l('Product Image').'</h3>';
		$this->displayStyleColor(166);
		$this->displayStyleColor(167);

		$this->_html .= '<h3>'.$this->l('View larger').'</h3>';
		$this->displayStyleColor(173);
		$this->displayStyleColor(236);
		$this->displayStyleColor(237);

		$this->_html .= '<h3>'.$this->l('Thumbnail').'</h3>';
		$this->displayStyleColor(171);
		$this->displayStyleColor(244);
		$this->displayStyleColor(172);
		$this->displayStyleColor(242);
		$this->displayStyleColor(243);

		$this->_html .= '<h3>'.$this->l('In stock').'</h3>';
		$this->displayStyleColor(238);

		$this->_html .= '<h3>'.$this->l('Out stock').'</h3>';
		$this->displayStyleColor(239);

		$this->_html .= '<h3>'.$this->l('Usefull link').'</h3>';
		$this->displayStyleColor(245);
		$this->displayStyleColor(246);

		$this->_html .= '<h3>'.$this->l('Social sharing').'</h3>';
		$this->displayStyleColor(240);
		$this->displayStyleColor(241);

		$this->_html .= '<h3>'.$this->l('Product Info').'</h3>';
		$this->displayStyleColor(168);
		$this->displayStyleColor(169);

		$this->_html .= '<h3>'.$this->l('Price Box').'</h3>';
		$this->displayStyleColor(227);
		$this->displayStyleColor(322);
		$this->displayStyleColor(228);

		$this->_html .= '<h3>'.$this->l('Attributes Box').'</h3>';
		$this->displayStyleColor(318);
		$this->displayStyleColor(319);

		$this->_html .= '<h3>'.$this->l('Cart Box').'</h3>';
		$this->displayStyleColor(320);
		$this->displayStyleColor(321);

		$this->_html .= '<h3>'.$this->l('Add to Cart').'</h3>';
		$this->displayStyleColor(229);
		$this->displayStyleColor(230);
		$this->displayStyleColor(231);
		$this->displayStyleColor(232);
		$this->displayStyleColor(233);
		$this->displayStyleColor(234);
		$this->displayStyleColor(235);

		$this->_html .= '<h3>'.$this->l('More info').'</h3>';
		$this->displayStyleColor(247);
		$this->displayStyleColor(248);
		$this->displayStyleColor(251);

		$this->_html .= '<h3>'.$this->l('More info title').'</h3>';
		$this->displayStyleColor(249);
		$this->displayStyleColor(250);
		$this->displayStyleColor(317);

		$this->_html .= '<h3>'.$this->l('More info others').'</h3>';
		$this->displayStyleColor(252);
		$this->displayStyleColor(253);

		$this->_html .= '<h3>'.$this->l('Reviews').'</h3>';
		$this->displayStyleColor(328);
		$this->displayStyleColor(329);
		$this->displayStyleColor(330);
		$this->displayStyleColor(331);
		$this->displayStyleColor(332);
		$this->displayStyleColor(333);
		$this->displayStyleColor(334);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '	<div class="form-group">';
		$this->_html .= '		<label class="control-label col-lg-3"></label>';
		$this->_html .= '		<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>
								</div>';
		$this->_html .= '	</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabOrderPageColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Heading').'</h3>';
		$this->displayStyleColor(276);
		$this->displayStyleColor(277);
		$this->displayStyleColor(297);

		$this->_html .= '<h3>'.$this->l('Subheading').'</h3>';
		$this->displayStyleColor(296);

		$this->_html .= '<h3>'.$this->l('Order Steps').'</h3>';
		$this->displayStyleColor(174);
		$this->displayStyleColor(175);
		$this->displayStyleColor(176);
		$this->displayStyleColor(270);
		$this->displayStyleColor(271);
		$this->displayStyleColor(272);
		$this->displayStyleColor(273);
		$this->displayStyleColor(274);
		$this->displayStyleColor(275);

		$this->_html .= '<h3>'.$this->l('Cart Summary').'</h3>';
		$this->displayStyleColor(389);
		$this->displayStyleColor(278);
		$this->displayStyleColor(279);

		$this->_html .= '<h3>'.$this->l('Cart Summary Title').'</h3>';
		$this->displayStyleColor(280);
		$this->displayStyleColor(281);
		$this->displayStyleColor(282);

		$this->_html .= '<h3>'.$this->l('Cart Summary Foot').'</h3>';
		$this->displayStyleColor(283);
		$this->displayStyleColor(284);

		$this->_html .= '<h3>'.$this->l('Cart Summary Total Price').'</h3>';
		$this->displayStyleColor(285);
		$this->displayStyleColor(286);

		$this->_html .= '<h3>'.$this->l('Cart Summary Quantity Input Box').'</h3>';
		$this->displayStyleColor(287);
		$this->displayStyleColor(288);

		$this->_html .= '<h3>'.$this->l('Cart Summary Plus & Minus').'</h3>';
		$this->displayStyleColor(289);
		$this->displayStyleColor(290);
		$this->displayStyleColor(291);

		$this->_html .= '<h3>'.$this->l('Cart Summary Others').'</h3>';
		$this->displayStyleColor(292);
		$this->displayStyleColor(323);
		$this->displayStyleColor(324);
		$this->displayStyleColor(325);

		$this->_html .= '<h3>'.$this->l('Address Box').'</h3>';
		$this->displayStyleColor(293);
		$this->displayStyleColor(294);
		$this->displayStyleColor(295);

		$this->_html .= '<h3>'.$this->l('Address Box Title').'</h3>';
		$this->displayStyleColor(326);
		$this->displayStyleColor(327);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '	<div class="form-group">';
		$this->_html .= '		<label class="control-label col-lg-3"></label>';
		$this->_html .= '		<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>
								</div>';
		$this->_html .= '	</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabLeftRightColor($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Block').'</h3>';
		$this->displayStyleColor(196);
		$this->displayStyleColor(197);
		$this->displayStyleColor(198);

		$this->_html .= '<h3>'.$this->l('Title').'</h3>';
		$this->displayStyleColor(33);
		$this->displayStyleColor(34);
		$this->displayStyleColor(35);

		$this->_html .= '<h3>'.$this->l('Content').'</h3>';
		$this->displayStyleColor(199);
		$this->displayStyleColor(200);
		$this->displayStyleColor(201);
		$this->displayStyleColor(202);

		$this->_html .= '<h3>'.$this->l('Button').'</h3>';
		$this->displayStyleColor(203);
		$this->displayStyleColor(204);
		$this->displayStyleColor(205);

		$this->_html .= '<h3>'.$this->l('Others').'</h3>';
		$this->displayStyleColor(224);
		$this->displayStyleColor(225);
		$this->displayStyleColor(226);
		$this->displayStyleColor(315);
		$this->displayStyleColor(316);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '	<div class="form-group">';
		$this->_html .= '		<label class="control-label col-lg-3"></label>';
		$this->_html .= '		<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Color').'"/>
								</div>';
		$this->_html .= '	</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabConfig($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:block">';

		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			$this->_html .= '<div class="panel product-tab" id="tabPane1">';
			$this->_html .= '<h3>'.$this->l('Front page Panel').'</h3>';
			$this->_html .= '<div class="form-group">';
			$this->_html .= '<label class="control-label col-lg-3">'.$this->l('Active Front Panel:').'</label>';
			$this->_html .= '<div class="col-lg-9">
								<div class="row">
									<div class="input-group col-lg-2">
										<span class="switch prestashop-switch">
											<input type="radio" name="front_panel" id="front_panel_1" value="1" '.
											((Configuration::get('uhu_css_2012_front_panel') == 1) ? 'checked="checked"' : '').'>
											<label for="front_panel_1">
												<i class="icon-check-sign color_success"></i> Yes
											</label>
											<input type="radio" name="front_panel" id="front_panel_0" value="0" '.
											((Configuration::get('uhu_css_2012_front_panel') == 0) ? 'checked="checked"' : '').'>
											<label for="front_panel_0">
												<i class="icon-ban-circle color_danger"></i> No
											</label>
											<a class="slide-button btn btn-default"></a>
										</span>
									</div>
								</div>
							</div>';
			$this->_html .= '</div>';

			$this->_html .= '<div class="form-group">';
			$this->_html .= '<label class="control-label col-lg-3">'.$this->l('Show Save button:').'</label>';
			$this->_html .= '<div class="col-lg-9">
								<div class="row">
									<div class="input-group col-lg-2">
										<span class="switch prestashop-switch">
											<input type="radio" name="front_save" id="front_save_1" value="1" '.
											((Configuration::get('uhu_css_2012_front_save') == 1) ? 'checked="checked"' : '').'>
											<label for="front_save_1">
												<i class="icon-check-sign color_success"></i> Yes
											</label>
											<input type="radio" name="front_save" id="front_save_0" value="0" '.
											((Configuration::get('uhu_css_2012_front_save') == 0) ? 'checked="checked"' : '').'>
											<label for="front_save_0">
												<i class="icon-ban-circle color_danger"></i> No
											</label>
											<a class="slide-button btn btn-default"></a>
										</span>
									</div>
								</div>
							</div>';
			$this->_html .= '</div>';

			$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
			$this->_html .= '<div class="form-group">';
			$this->_html .= '<label class="control-label col-lg-3"></label>
							<div class="col-lg-9">
									<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
										class="button" type="submit" name="submitUpdatePanel" value="'.$this->l('Front Theme Panel').'"/>
							</div>';
			$this->_html .= '</div>';
			$this->_html .= '</div>';
			$this->_html .= '</div>';
		}

		$this->_html .= '<div class="panel product-tab" id="tabPane1">';
		$this->_html .= '<h3>'.$this->l('Color theme').'</h3>';
		$themes_names = explode('|', Configuration::get('uhu_modvalue_setting_3'));
		$c_value = explode('|', Configuration::get('uhu_modvalue_setting_4'));
		$id = 0;
		foreach ($themes_names as $themes_name)
		{
			$selected = (Configuration::get('PS_UHU_THEME') == $themes_name) ? 'checked="checked"' : '';
			$this->_html .= '<div class="form-group">';
			$this->_html .= '<label class="control-label col-lg-3">'.$themes_name.' <input type="radio" name="selected_theme_color" id="selected_'.$themes_name.'" value="'.$themes_name.'" '.$selected.'></label>';
			$this->_html .= '<div class="col-lg-9">
								<div class="form-group">
									<div class="col-lg-1">
										<div class="row">
											<div class="input-group">
												<div class="attributes-color-container" style="background-color:'.$c_value[$id ++].';"></div>
											</div>
										</div>
									</div>
								</div>			
							</div>';
			$this->_html .= '</div>';
		}

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3"></label>';
		$this->_html .= '<div class="col-lg-9">
							<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
								class="button" type="submit" name="submitChoiseThemeColor" value="'.$this->l('Choise Color theme').'"/>
						</div>';
		$this->_html .= '</div>';
		$this->_html .= '</div>';
		$this->_html .= '</div>';

		$this->_html .= '<div class="panel product-tab" id="tabPane1">';
		$this->_html .= '<h3>'.$this->l('Logo').'</h3>';
		$this->displayFormInput(6, 'Position Top:', 'logo_top', '', 'logo');
		$this->displayFormInput(7, 'Position Left:', 'logo_left', '', 'logo');

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l('Type').'</label>';
		$this->_html .= '<div class="col-lg-9">';
		$this->_html .= '		<input type="radio" name="logo_type" id="logo_type_1" value="image" '.
									((Configuration::get('uhu_modvalue_logo_0') == 'image') ? 'checked="checked"' : '').'>
								<label class="t" for="logo_type_1">Image</label><br>';
		$this->_html .= '		<input type="radio" name="logo_type" id="logo_type_0" value="text" '.
									((Configuration::get('uhu_modvalue_logo_0') == 'text') ? 'checked="checked"' : '').'>
								<label class="t" for="logo_type_0">Text</label>';
		$this->_html .= '</div>';
		$this->_html .= '</div>';

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l('Image Logo').'</label>';
		$this->_html .= '<div class="col-lg-9">';

		if (is_dir(_PS_ROOT_DIR_.'/modules/'.$this->name.'/images/logo/'))
		{
			$patternfile = scandir(_PS_ROOT_DIR_.'/modules/'.$this->name.'/images/logo/');
			$exclude_list = array('.', '..', 'index.php', '0_noimage.gif');
			$pattern = count($patternfile);
			for ($i = 0; $i < $pattern; $i++)
			{
				if (!in_array($patternfile[$i], $exclude_list))
			$this->_html .= '
								<input type="radio" name="logo_pattern" value="'.$patternfile[$i].'" '.
									((Configuration::get('uhu_modvalue_logo_1') == $patternfile[$i]) ? 'checked="checked"' : '').' />
								<img style="border:1px solid #ccc;padding:10px;margin:0;max-width:200px; max-height:90px;"
									src="'._MODULE_DIR_.$this->name.'/images/logo/'.$patternfile[$i].'" /> 
							';
			}
		}
		$this->_html .= '</div>';
		$this->_html .= '</div>';

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3 "></label>';
		$this->_html .= '<div class="col-lg-9">
							<input id="logo_file" type="file" name="logo_file" />
						</div>
						</div>';

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3 "></label>';
		$this->_html .= '<div class="col-lg-9">
							<input class="button" type="submit" name="submitBackpattern_logo" value="'.$this->l('Upload Logo').'"/>
						</div>
						</div>';

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3 ">'.$this->l('Text Logo').'</label>';
		$this->_html .= '<div class="col-lg-9">
							<p style="padding-bottom:5px; '.(Configuration::get('uhu_modvalue_logo_4') ? 'font-family: '.
								Configuration::get('uhu_modvalue_logo_4').'; ' : ' ').(Configuration::get('uhu_modvalue_logo_5') ? 'font-size: '.
								Configuration::get('uhu_modvalue_logo_5').'; ' : ' ').(Configuration::get('uhu_modvalue_logo_3') ? 'color: '.
								Configuration::get('uhu_modvalue_logo_3').'; ' : ' ').'">'.Configuration::get('uhu_modvalue_logo_2').'
							</p>
						</div>';
		$this->_html .= '</div>';

		$this->displayFormInput(2, 'Shop name:', 'logo_name', '', 'logo');
		$this->displayFormColor(3, 'Color', 'logo_color', 'logo');
		$this->displayFormFontFamily(4, 'logo', 'Font', 'logo_font');
		$this->displayFormFontSize(5, 'logo', 'Size', 'logo_size');

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3"></label>';
		$this->_html .= '<div class="col-lg-9">
							<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
								class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom Logo').'"/>
						</div>';
		$this->_html .= '</div>';
		$this->_html .= '</div>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
	}

	private function displayFormTabModContent($mod_id, $moduletitle)
	{
		if (Configuration::get('uhu_mod_total_'.$mod_id) > 0)
		{
			$this->_html .= '<h3>'.Module::getModuleName($moduletitle).'</h3>';
			for ($jorder = 0; $jorder < Configuration::get('uhu_mod_total_'.$mod_id); $jorder++)
				for ($j = 0; $j < Configuration::get('uhu_mod_total_'.$mod_id); $j++)
				{
					$tab_id = Configuration::get('uhu_mod_id_'.$mod_id).'_'.$j;
					if ($jorder == Configuration::get('uhu_modorder_'.$tab_id))
						if (Configuration::get('uhu_moddisplay_'.$tab_id) == 'true')
							$this->displayFormInputConfig(
										Configuration::get('uhu_modname_'.$tab_id),
										Configuration::get('uhu_modid_'.$tab_id),
										Configuration::get('uhu_modvalue_'.$tab_id),
										Configuration::get('uhu_moddesp_'.$tab_id)
										);
				}

				if (Configuration::get('uhu_mod_adver_'.$mod_id) == 'true')
					$this->displayFormUploadConfig(Configuration::get('uhu_mod_id_'.$mod_id));
		}
	}

	private function displayFormTabOneModContent($mod_id, $mid)
	{
		$tab_id = Configuration::get('uhu_mod_id_'.$mod_id).'_'.$mid;

		$modname = Configuration::get('uhu_modname_'.$tab_id);
		$modid = Configuration::get('uhu_modid_'.$tab_id);
		$modvalue = Configuration::get('uhu_modvalue_'.$tab_id);
		$moddesp = Configuration::get('uhu_moddesp_'.$tab_id);
		$this->displayFormInputConfig($modname, $modid, $modvalue, $moddesp);
	}

	private function displayFormTabTopmenu($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 27;
		$moduletitle = 'uhu_topmenu';
		//$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<h3>'.Module::getModuleName($moduletitle).'</h3>';
		$this->displayFormTabOneModContent($mod_id, 22);

		$this->_html .= '<h3>'.$this->l('Menuitem: Home').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 27);

		$this->_html .= '<h3>'.$this->l('Menuitem: Categories').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 41);
		$this->displayFormTabOneModContent($mod_id, 8);

		$this->_html .= '<h3>'.$this->l('Menuitem: Products').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 6);
		$this->displayFormTabOneModContent($mod_id, 14);
		$this->displayFormTabOneModContent($mod_id, 15);

		$this->_html .= '<h3>'.$this->l('Menuitem: Brands').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 42);
		$this->displayFormTabOneModContent($mod_id, 7);

		$this->_html .= '<h3>'.$this->l('Menuitem: CMS pages').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 9);

		$this->_html .= '<h3>'.$this->l('Menuitem: Custom Links').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 23);
		$this->displayFormTabOneModContent($mod_id, 24);

		$this->_html .= '<h3>'.$this->l('Menuitem: Featured Categories with its sub-categories and thumbnails').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 26);

		$this->_html .= '<h3>'.$this->l('Menuitem: Full Custom A').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 25);
		$this->displayFormTabOneModContent($mod_id, 30);
		$this->displayFormTabOneModContent($mod_id, 31);
		$this->displayFormTabOneModContent($mod_id, 32);

		$this->_html .= '<h3>'.$this->l('Menuitem: Full Custom B').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 33);
		$this->displayFormTabOneModContent($mod_id, 34);
		$this->displayFormTabOneModContent($mod_id, 35);
		$this->displayFormTabOneModContent($mod_id, 36);

		$this->_html .= '<h3>'.$this->l('Menuitem: Full Custom C').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 37);
		$this->displayFormTabOneModContent($mod_id, 38);
		$this->displayFormTabOneModContent($mod_id, 39);
		$this->displayFormTabOneModContent($mod_id, 40);

		$this->_html .= '<h3>'.$this->l('For Expert: Grid in Categories').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 0);
		$this->displayFormTabOneModContent($mod_id, 1);
		$this->displayFormTabOneModContent($mod_id, 11);
		$this->displayFormTabOneModContent($mod_id, 13);

		$this->_html .= '<h3>'.$this->l('For Expert: Grid in Products').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 2);
		$this->displayFormTabOneModContent($mod_id, 3);
		$this->displayFormTabOneModContent($mod_id, 16);
		$this->displayFormTabOneModContent($mod_id, 17);

		$this->_html .= '<h3>'.$this->l('For Expert: Grid in Brands').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 4);
		$this->displayFormTabOneModContent($mod_id, 5);
		$this->displayFormTabOneModContent($mod_id, 18);
		$this->displayFormTabOneModContent($mod_id, 19);
		$this->displayFormTabOneModContent($mod_id, 21);

		$this->_html .= '<h3>'.$this->l('Advertising').'</h3>';
		$this->displayFormUploadConfig(Configuration::get('uhu_mod_id_'.$mod_id), false);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabSliderBX($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 2;
		$moduletitle = 'uhu_bxslider';
		$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabSliderCY($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 32;
		$moduletitle = 'uhu_cycleslider';
		//$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<h3>'.Module::getModuleName($moduletitle).'</h3>';
		$this->displayFormTabOneModContent($mod_id, 4);
		$this->displayFormTabOneModContent($mod_id, 3);
		$this->displayFormTabOneModContent($mod_id, 6);
		$this->displayFormTabOneModContent($mod_id, 7);

		$this->_html .= '<h3>'.$this->l('Slider 1: Image').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 11);

		$this->_html .= '<h3>'.$this->l('Slider 1: Title').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 12);
		$this->displayFormTabOneModContent($mod_id, 13);
		$this->displayFormTabOneModContent($mod_id, 14);
		$this->displayFormTabOneModContent($mod_id, 15);
		$this->displayFormTabOneModContent($mod_id, 16);

		$this->_html .= '<h3>'.$this->l('Slider 1: Text').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 17);
		$this->displayFormTabOneModContent($mod_id, 18);
		$this->displayFormTabOneModContent($mod_id, 19);
		$this->displayFormTabOneModContent($mod_id, 20);
		$this->displayFormTabOneModContent($mod_id, 21);

		$this->_html .= '<h3>'.$this->l('Slider 1: Logo').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 22);
		$this->displayFormTabOneModContent($mod_id, 23);
		$this->displayFormTabOneModContent($mod_id, 24);

		$this->_html .= '<h3>'.$this->l('Slider 1: Link').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 25);
		$this->displayFormTabOneModContent($mod_id, 26);
		$this->displayFormTabOneModContent($mod_id, 27);
		$this->displayFormTabOneModContent($mod_id, 28);
		$this->displayFormTabOneModContent($mod_id, 29);
		$this->displayFormTabOneModContent($mod_id, 30);

		$this->_html .= '<h3>'.$this->l('Slider 2: Image').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 41);

		$this->_html .= '<h3>'.$this->l('Slider 2: Title').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 42);
		$this->displayFormTabOneModContent($mod_id, 43);
		$this->displayFormTabOneModContent($mod_id, 44);
		$this->displayFormTabOneModContent($mod_id, 45);
		$this->displayFormTabOneModContent($mod_id, 46);

		$this->_html .= '<h3>'.$this->l('Slider 2: Text').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 47);
		$this->displayFormTabOneModContent($mod_id, 48);
		$this->displayFormTabOneModContent($mod_id, 49);
		$this->displayFormTabOneModContent($mod_id, 50);
		$this->displayFormTabOneModContent($mod_id, 51);

		$this->_html .= '<h3>'.$this->l('Slider 2: Logo').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 52);
		$this->displayFormTabOneModContent($mod_id, 53);
		$this->displayFormTabOneModContent($mod_id, 54);

		$this->_html .= '<h3>'.$this->l('Slider 2: Link').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 55);
		$this->displayFormTabOneModContent($mod_id, 56);
		$this->displayFormTabOneModContent($mod_id, 57);
		$this->displayFormTabOneModContent($mod_id, 58);
		$this->displayFormTabOneModContent($mod_id, 59);
		$this->displayFormTabOneModContent($mod_id, 60);

		$this->_html .= '<h3>'.$this->l('Slider 3: Image').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 71);

		$this->_html .= '<h3>'.$this->l('Slider 3: Title').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 72);
		$this->displayFormTabOneModContent($mod_id, 73);
		$this->displayFormTabOneModContent($mod_id, 74);
		$this->displayFormTabOneModContent($mod_id, 75);
		$this->displayFormTabOneModContent($mod_id, 76);

		$this->_html .= '<h3>'.$this->l('Slider 3: Text').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 77);
		$this->displayFormTabOneModContent($mod_id, 78);
		$this->displayFormTabOneModContent($mod_id, 79);
		$this->displayFormTabOneModContent($mod_id, 80);
		$this->displayFormTabOneModContent($mod_id, 81);

		$this->_html .= '<h3>'.$this->l('Slider 3: Logo').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 82);
		$this->displayFormTabOneModContent($mod_id, 83);
		$this->displayFormTabOneModContent($mod_id, 84);

		$this->_html .= '<h3>'.$this->l('Slider 3: Link').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 85);
		$this->displayFormTabOneModContent($mod_id, 86);
		$this->displayFormTabOneModContent($mod_id, 87);
		$this->displayFormTabOneModContent($mod_id, 88);
		$this->displayFormTabOneModContent($mod_id, 89);
		$this->displayFormTabOneModContent($mod_id, 90);

		$this->_html .= '<h3>'.$this->l('Slider 3: Product').'</h3>';
		$this->displayFormTabOneModContent($mod_id, 91);
		$this->displayFormTabOneModContent($mod_id, 93);

		$this->_html .= '<h3>'.$this->l('Slider Image').'</h3>';
		$this->displayFormUploadConfig(Configuration::get('uhu_mod_id_'.$mod_id), false);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabFeatured($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 0;
		$moduletitle = 'uhu_featured';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);
		//$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 1;
		$moduletitle = 'uhu_bxfeatured';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);
		//$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabNew($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 7;
		$moduletitle = 'uhu_catproducts';
		$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabBest($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 11;
		$moduletitle = 'uhu_cp_1901';
		$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabHotcategory($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 22;
		$moduletitle = 'uhu_catfeatured';
		$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabAdvertising($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 17;
		$moduletitle = 'uhu_gj_1901';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 18;
		$moduletitle = 'uhu_gj_1902';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 19;
		$moduletitle = 'uhu_gj_1903';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 16;
		$moduletitle = 'uhu_gj_9511';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 15;
		$moduletitle = 'uhu_gj_9521';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 12;
		$moduletitle = 'uhu_gj_9531';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 13;
		$moduletitle = 'uhu_gj_9541';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 31;
		$moduletitle = 'uhu_gj_9551';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 33;
		$moduletitle = 'uhu_gj_9561';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabHeader($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 5;
		$moduletitle = 'uhu_contact';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}


	private function displayFormTabFooter($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$mod_id = 4;
		$moduletitle = 'uhu_myaccount';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 6;
		$moduletitle = 'uhu_social';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 9;
		$moduletitle = 'uhu_reassure';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 25;
		$moduletitle = 'uhu_ft_fblike';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 28;
		$moduletitle = 'uhu_ft_twnews';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 29;
		$moduletitle = 'uhu_cms';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 34;
		$moduletitle = 'uhu_contactus';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$mod_id = 26;
		$moduletitle = 'uhu_copyright';
		$module = Module::getInstanceByName($moduletitle);
		if ($module <> false && $module->active)
			$this->displayFormTabModContent($mod_id, $moduletitle);

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/prefs.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="submitCustomConfig" value="'.$this->l('Save Custom Config').'"/>
						<input style="background:url(../img/admin/manufacturers.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
							class="button" type="submit" name="loadSystemConfig" value="'.$this->l('Load System Config').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormTabCustom($tab)
	{
		$this->_html .= '<div class="profile-'.$tab.' tab-profile product-tab-content" style="display:none">';
		$this->_html .= '<div class="panel product-tab" id="tabPane1">';

		$this->_html .= '<h3>'.$this->l('Add your CSS styles').'</h3>';
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l('CSS:').'</label>';
		$this->_html .= '<div class="col-lg-9">
								<textarea id="customcss" name="customcss" cols="100" rows="25">'.Configuration::get('uhu_custom_css').'</textarea>	
						</div>';
		$this->_html .= '</div>';

		$this->_html .= '<div class="panel-footer" id="toolbar-footer">';
		$this->_html .= '<input style="background:url(../img/admin/appearance.gif) no-repeat 8px 3px; padding: 4px 8px 4px 32px;"
									class="button" type="submit" name="submitCustomColor" value="'.$this->l('Save Custom CSS').'"/>';
		$this->_html .= '</div>';

		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormFontFamily($m_id, $m_name, $e_title, $css_id)
	{
		$c_value = Configuration::get('uhu_modvalue_'.$m_name.'_'.$m_id);

		$font_list = array('', 'Abel','Abril Fatface','Aclonica','Acme','Actor','Adamina','Advent Pro','Aguafina Script','Akronim','Aladin','Aldrich',
							'Alegreya','Alegreya SC','Alex Brush','Alfa Slab One','Alice','Alike','Alike Angular','Allan','Allerta','Allerta Stencil',
							'Allura','Almendra','Almendra SC','Amarante','Amaranth','Amatic SC','Amethysta','Andada','Andika','Angkor',
							'Annie Use Your Telescope','Anonymous Pro','Antic','Antic Didone','Antic Slab','Anton','Arapey','Arbutus','Arbutus Slab',
							'Architects Daughter','Archivo Black','Archivo Narrow','Arimo','Arizonia','Armata','Artifika','Arvo','Asap','Asset','Astloch',
							'Asul','Atomic Age','Aubrey','Audiowide','Autour One','Average','Averia Gruesa Libre','Averia Libre','Averia Sans Libre',
							'Averia Serif Libre','Bad Script','Balthazar','Bangers','Basic','Battambang','Baumans','Bayon','Belgrano','Belleza',
							'BenchNine','Bentham','Berkshire Swash','Bevan','Bigshot One','Bilbo','Bilbo Swash Caps','Bitter','Black Ops One','Bokor',
							'Bonbon','Boogaloo','Bowlby One','Bowlby One SC','Brawler','Bree Serif','Bubblegum Sans','Bubbler One','Buda','Buenard',
							'Butcherman','Butterfly Kids','Cabin','Cabin Condensed','Cabin Sketch','Caesar Dressing','Cagliostro','Calligraffitti',
							'Cambo','Candal','Cantarell','Cantata One','Cantora One','Capriola','Cardo','Carme','Carrois Gothic','Carrois Gothic SC',
							'Carter One','Caudex','Cedarville Cursive','Ceviche One','Changa One','Chango','Chau Philomene One','Chela One',
							'Chelsea Market','Chenla','Cherry Cream Soda','Cherry Swash','Chewy','Chicle','Chivo','Cinzel','Cinzel Decorative','Coda',
							'Coda Caption','Codystar','Combo','Comfortaa','Coming Soon','Concert One','Condiment','Content','Contrail One','Convergence',
							'Cookie','Copse','Corben','Courgette','Cousine','Coustard','Covered By Your Grace','Crafty Girls','Creepster','Crete Round',
							'Crimson Text','Crushed','Cuprum','Cutive','Damion','Dancing Script','Dangrek','Dawning of a New Day','Days One','Delius',
							'Delius Swash Caps','Delius Unicase','Della Respira','Devonshire','Didact Gothic','Diplomata','Diplomata SC','Doppio One',
							'Dorsa','Dosis','Dr Sugiyama','Droid Sans','Droid Sans Mono','Droid Serif','Duru Sans','Dynalight','EB Garamond','Eagle Lake',
							'Eater','Economica','Electrolize','Emblema One','Emilys Candy','Engagement','Enriqueta','Erica One','Esteban','Euphoria Script',
							'Ewert','Exo','Expletus Sans','Fanwood Text','Fascinate','Fascinate Inline','Fasthand','Federant','Federo','Felipa','Fenix',
							'Finger Paint','Fjord One','Flamenco','Flavors','Fondamento','Fontdiner Swanky','Forum','Francois One','Fredericka the Great',
							'Fredoka One','Freehand','Fresca','Frijole','Fugaz One','GFS Didot','GFS Neohellenic','Galdeano','Galindo','Gentium Basic',
							'Gentium Book Basic','Geo','Geostar','Geostar Fill','Germania One','Give You Glory','Glass Antiqua','Glegoo',
							'Gloria Hallelujah','Goblin One','Gochi Hand','Gorditas','Goudy Bookletter 1911','Graduate','Gravitas One','Great Vibes',
							'Griffy','Gruppo','Gudea','Habibi','Hammersmith One','Handlee','Hanuman','Happy Monkey','Headland One','Henny Penny',
							'Herr Von Muellerhoff','Holtwood One SC','Homemade Apple','Homenaje','IM Fell DW Pica','IM Fell DW Pica SC',
							'IM Fell Double Pica','IM Fell Double Pica SC','IM Fell English','IM Fell English SC','IM Fell French Canon',
							'IM Fell French Canon SC','IM Fell Great Primer','IM Fell Great Primer SC','Iceberg','Iceland','Imprima','Inconsolata',
							'Inder','Indie Flower','Inika','Irish Grover','Istok Web','Italiana','Italianno','Jacques Francois','Jacques Francois Shadow',
							'Jim Nightshade','Jockey One','Jolly Lodger','Josefin Sans','Josefin Slab','Judson','Julee','Julius Sans One','Junge','Jura',
							'Just Another Hand','Just Me Again Down Here','Kameron','Karla','Kaushan Script','Kelly Slab','Kenia','Khmer','Knewave',
							'Kotta One','Koulen','Kranky','Kreon','Kristi','Krona One','La Belle Aurore','Lancelot','Lato','League Script','Leckerli One',
							'Ledger','Lekton','Lemon','Life Savers','Lilita One','Limelight','Linden Hill','Lobster','Lobster Two','Londrina Outline',
							'Londrina Shadow','Londrina Sketch','Londrina Solid','Lora','Love Ya Like A Sister','Loved by the King','Lovers Quarrel',
							'Luckiest Guy','Lusitana','Lustria','Macondo','Macondo Swash Caps','Magra','Maiden Orange','Mako','Marcellus','Marcellus SC',
							'Marck Script','Marko One','Marmelad','Marvel','Mate','Mate SC','Maven Pro','McLaren','Meddon','MedievalSharp','Medula One',
							'Megrim','Meie Script','Merienda One','Merriweather','Metal','Metal Mania','Metamorphous','Metrophobic','Michroma','Miltonian',
							'Miltonian Tattoo','Miniver','Miss Fajardose','Modern Antiqua','Molengo','Molle','Monofett','Monoton','Monsieur La Doulaise',
							'Montaga','Montez','Montserrat','Montserrat Alternates','Montserrat Subrayada','Moul','Moulpali','Mountains of Christmas',
							'Mr Bedfort','Mr Dafoe','Mr De Haviland','Mrs Saint Delafield','Mrs Sheppards','Muli','Mystery Quest','Neucha','Neuton',
							'News Cycle','Niconne','Nixie One','Nobile','Nokora','Norican','Nosifer','Nothing You Could Do','Noticia Text','Nova Cut',
							'Nova Flat','Nova Mono','Nova Oval','Nova Round','Nova Script','Nova Slim','Nova Square','Numans','Nunito','Odor Mean Chey',
							'Old Standard TT','Oldenburg','Oleo Script','Open Sans','Open Sans Condensed','Oranienbaum','Orbitron','Oregano','Orienta',
							'Original Surfer','Oswald','Over the Rainbow','Overlock','Overlock SC','Ovo','Oxygen','Oxygen Mono','PT Mono','PT Sans',
							'PT Sans Caption','PT Sans Narrow','PT Serif','PT Serif Caption','Pacifico','Parisienne','Passero One','Passion One',
							'Patrick Hand','Patua One','Paytone One','Peralta','Permanent Marker','Petit Formal Script','Petrona','Philosopher','Piedra',
							'Pinyon Script','Plaster','Play','Playball','Playfair Display','Podkova','Poiret One','Poller One','Poly','Pompiere',
							'Pontano Sans','Port Lligat Sans','Port Lligat Slab','Prata','Preahvihear','Press Start 2P','Princess Sofia','Prociono',
							'Prosto One','Puritan','Quando','Quantico','Quattrocento','Quattrocento Sans','Questrial','Quicksand','Qwigley',
							'Racing Sans One','Radley','Raleway','Raleway Dots','Rammetto One','Ranchers','Rancho','Rationale','Redressed','Reenie Beanie',
							'Revalia','Ribeye','Ribeye Marrow','Righteous','Rochester','Rock Salt','Rokkitt','Romanesco','Ropa Sans','Rosario','Rosarivo',
							'Rouge Script','Ruda','Ruge Boogie','Ruluko','Ruslan Display','Russo One','Ruthie','Rye','Sail','Salsa','Sancreek',
							'Sansita One','Sarina','Satisfy','Scada','Schoolbell','Seaweed Script','Sevillana','Seymour One','Shadows Into Light',
							'Shadows Into Light Two','Shanti','Share','Shojumaru','Short Stack','Siemreap','Sigmar One','Signika','Signika Negative',
							'Simonetta','Sirin Stencil','Six Caps','Skranji','Slackey','Smokum','Smythe','Sniglet','Snippet','Sofadi One','Sofia',
							'Sonsie One','Sorts Mill Goudy','Source Code Pro','Source Sans Pro','Special Elite','Spicy Rice','Spinnaker','Spirax',
							'Squada One','Stalinist One','Stardos Stencil','Stint Ultra Condensed','Stint Ultra Expanded','Stoke','Sue Ellen Francisco',
							'Sunshiney','Supermercado One','Suwannaphum','Swanky and Moo Moo','Syncopate','Tangerine','Taprom','Telex','Tenor Sans',
							'The Girl Next Door','Tienne','Tinos','Titan One','Titillium Web','Trade Winds','Trocchi','Trochut','Trykker','Tulpen One',
							'Ubuntu','Ubuntu Condensed','Ubuntu Mono','Ultra','Uncial Antiqua','Underdog','UnifrakturCook','UnifrakturMaguntia','Unkempt',
							'Unlock','Unna','VT323','Varela','Varela Round','Vast Shadow','Vibur','Vidaloka','Viga','Voces','Volkhov','Vollkorn',
							'Voltaire','Waiting for the Sunrise','Wallpoet','Walter Turncoat','Warnes','Wellfleet','Wire One','Yanone Kaffeesatz',
							'Yellowtail','Yeseva One','Yesteryear','Zeyada');
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l($e_title).'</label>
						 <div class="col-lg-9">
							<div class="form-group">
								<div class="col-lg-2">
									<select name="'.$css_id.'" id="'.$css_id.'">';
		foreach ($font_list as $font)
		$this->_html .= '				<option value="'.$font.'" '.($c_value == $font ? 'selected="selected"' : '').'> '.$font.' </option>';
		$this->_html .= '			</select>
								</div>
							</div>
						 </div>';
		$this->_html .= '</div>';
	}

	private function displayFormFontSize($m_id, $m_name, $e_title, $css_id)
	{
		$c_value = Configuration::get('uhu_modvalue_'.$m_name.'_'.$m_id);

		$size_list = array('','15px','16px','17px','18px','19px','20px','21px','22px','23px','24px','25px','26px','27px','28px','29px','30px','31px',
							'32px','33px','34px','35px','36px','37px','38px','39px','40px','41px','42px','43px','44px','45px','46px','47px','48px',
							'49px','50px','51px','52px','53px','54px','55px','56px','57px','58px','59px','60px','61px','62px','63px','64px','65px',
							'66px','67px','68px','69px','70px','71px','72px','73px','74px','75px','76px','77px','78px','79px','80px');
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l($e_title).'</label>
						 <div class="col-lg-9">
							<div class="form-group">
								<div class="col-lg-2">
									<select name="'.$css_id.'" id="'.$css_id.'">';
		foreach ($size_list as $size)
		$this->_html .= '				<option value="'.$size.'" '.($c_value == $size ? 'selected="selected"' : '').'> '.$size.' </option>';
		$this->_html .= '			</select>
								</div>
							</div>
						 </div>';
		$this->_html .= '</div>';
	}

	private function displayStyleColor($m_id)
	{
		$m_name = 'setting';
		$css_id = Configuration::get('uhu_modid_'.$m_name.'_'.$m_id);
		$c_value = Configuration::get('uhu_modvalue_'.$m_name.'_'.$m_id);
		$e_title = Configuration::get('uhu_modname_'.$m_name.'_'.$m_id);
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l($e_title).'</label>
						 <div class="col-lg-9">
							<div class="form-group">
								<div class="col-lg-2">
									<div class="row">
										<div class="input-group">
											<input id="'.$css_id.'" name="'.$css_id.'" type="text" size="33" data-hex="true"
												class="color mColorPickerInput mColorPicker" value="'.$c_value.'" style="background-color: '.$c_value.'; color: white; ">
											<span style="cursor:pointer;" id="icp_'.$css_id.'" class="mColorPickerTrigger input-group-addon" data-mcolorpicker="true">
											<img src="../img/admin/color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>
										</div>
									</div>
								</div>';

		$colors = Configuration::get('uhu_modtype_'.$m_name.'_'.$m_id);
		$color = explode('|', $colors);
		if (count($color) == 3)
			$c_value = $color[0];
		else
			$c_value = '';
		$this->_html .= '			<div class="col-lg-1">
										<div class="row">
											<div class="input-group" style="float: right;">
												<div class="attributes-color-container" style="background-color:'.$c_value.';"></div>
											</div>
										</div>
									</div>';

		if (count($color) == 3)
			$c_value = $color[1];
		else
			$c_value = '';
		$this->_html .= '			<div class="col-lg-1">
										<div class="row">
											<div class="input-group" style="float: right;">
												<div class="attributes-color-container" style="background-color:'.$c_value.';"></div>
											</div>
										</div>
									</div>';

		if (count($color) == 3)
			$c_value = $color[2];
		else
			$c_value = '';
		$this->_html .= '			<div class="col-lg-1">
										<div class="row">
											<div class="input-group" style="float: right;">
												<div class="attributes-color-container" style="background-color:'.$c_value.';"></div>
											</div>
										</div>
									</div>';

		$this->_html .= '	</div>
						 </div>';
		$this->_html .= '</div>';
	}

	private function displayFormColor($m_id, $e_title, $css_id, $m_name = 'setting')
	{
		$c_value = Configuration::get('uhu_modvalue_'.$m_name.'_'.$m_id);
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l($e_title).'</label>
						 <div class="col-lg-9">
							<div class="form-group">
								<div class="col-lg-2">
									<div class="row">
										<div class="input-group">
											<input id="'.$css_id.'" name="'.$css_id.'" type="text" size="33" data-hex="true"
												class="color mColorPickerInput mColorPicker" value="'.$c_value.'" style="background-color: '.$c_value.'; color: white; ">
											<span style="cursor:pointer;" id="icp_'.$css_id.'" class="mColorPickerTrigger input-group-addon" data-mcolorpicker="true">
											<img src="../img/admin/color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>
										</div>
									</div>
								</div>
							</div>
						 </div>';
		$this->_html .= '</div>';
	}

	private function displayFormInput($m_id, $e_title, $css_id, $pixel, $m_name = 'setting')
	{
		$c_value = Configuration::get('uhu_modvalue_'.$m_name.'_'.$m_id);
		$spw = explode('|', $pixel);
		$spw0 = $spw[0];

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l($e_title).'</label>';
		$this->_html .= '<div class="col-lg-9">
							<div class="form-group">
								<div class="col-lg-2">
									<input type="text" name="'.$css_id.'" value="'.$c_value.'" />';
		if ($spw0 <> '')
		$this->_html .= '			<p class="help-block">'.$spw0.'</p>';
		$this->_html .= '		</div>
							</div>';
		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayStylePattern($m_bg, $m_pattern, $m_bgpos, $css_id, $imagefolder, $upload = true)
	{
		$m_name = 'setting';

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.Configuration::get('uhu_modname_'.$m_name.'_'.$m_bg).'</label>
						 <div class="col-lg-9">
							<div class="form-group">
								<div class="col-lg-2">
									<div class="row">
										<div class="input-group">
											<input id="'.$css_id.'_bg" name="'.$css_id.'_bg" type="text" size="33" data-hex="true"
												class="color mColorPickerInput mColorPicker" value="'.Configuration::get('uhu_modvalue_setting_'.$m_bg).
												'" style="background-color: '.Configuration::get('uhu_modvalue_setting_'.$m_bg).'; color: white; ">
											<span style="cursor:pointer;" id="icp_'.$css_id.'_bg" class="mColorPickerTrigger input-group-addon" data-mcolorpicker="true">
												<img src="../img/admin/color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>
										</div>
									</div>
								</div>
						 </div>';
		$this->_html .= '</div>';

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3 ">'.Configuration::get('uhu_modname_'.$m_name.'_'.$m_pattern).'</label>';
		$this->_html .= '<div class="col-lg-9">';
		if (is_dir(_PS_ROOT_DIR_.'/modules/'.$this->name.$imagefolder))
		{
			$patternfile = scandir(_PS_ROOT_DIR_.'/modules/'.$this->name.$imagefolder);
			$exclude_list = array('.', '..', 'index.php');
			$pattern = count($patternfile);
			for ($i = 0; $i < $pattern; $i++)
			{
				if (!in_array($patternfile[$i], $exclude_list) && $patternfile[$i] != '')
					$this->_html .= '
						<input type="radio" name="'.$css_id.'_pattern" value="'.$patternfile[$i].'" '.
							(((Configuration::get('uhu_modvalue_setting_'.$m_pattern) == $patternfile[$i])) ? 'checked="checked"' : '').' />
							<img style="border:1px solid #ccc; padding:10px; margin: 20px 0px; max-width: 200px; max-height: 80px;"
								src="'._MODULE_DIR_.$this->name.$imagefolder.$patternfile[$i].'" /> 
						';
			}
		}
		$this->_html .= '</div>';
		$this->_html .= '</div>';

		if ($upload)
		{
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3 "></label>';
		$this->_html .= '<div class="col-lg-6">
							<input id="'.$css_id.'_file" type="file" name="'.$css_id.'_file" />
						</div>
						</div>';

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3 "></label>';
		$this->_html .= '<div class="col-lg-6">
							<input class="button" type="submit" name="submitBackpattern_'.$css_id.'" value="'.$this->l('Upload Pattern').'"/>
						</div>
						</div>';
		}

		$this->_html .= '<div class="form-group ">';
		$this->_html .= '<label class="control-label col-lg-3 ">'.Configuration::get('uhu_modname_'.$m_name.'_'.$m_bgpos).'</label>';
		$this->_html .= '<div class="col-lg-9 ">
							<input id="'.$css_id.'_bgpos" name="'.$css_id.'_bgpos" type="text" size="33" value="'.
								Configuration::get('uhu_modvalue_setting_'.$m_bgpos).'">
							<p class="help-block">Set repeat, position to pattern (e.g. "no-repeat top left", "repeat-x 0 0")</p>													
						</div>
						</div>';

		$this->_html .= '</div>';
	}

	private function displayFormInputConfig($c_title, $css_id, $css_value, $pixel)
	{
		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3">'.$this->l($c_title).'</label>';
		$this->_html .= '<div class="col-lg-9">
							<div class="form-group">
								<div class="col-lg-11">
									<input type="text" name="'.$css_id.'" value="'.$css_value.'" />';
		if ($pixel <> '')
		$this->_html .= '			<p class="help-block">'.$pixel.'</p>';
		$this->_html .= '		</div>
							</div>';
		$this->_html .= '</div>';
		$this->_html .= '</div>';
	}

	private function displayFormUploadConfig($css_id, $hr = true)
	{
		if ($hr)
			$this->_html .= '<hr>';

		if (is_dir(_PS_ROOT_DIR_.'/modules/'.$this->name.'/images/'.$css_id))
		{
			$patternfile = scandir(_PS_ROOT_DIR_.'/modules/'.$this->name.'/images/'.$css_id);
			$exclude_list = array('.', '..', 'index.php');
			$pattern = count($patternfile);
			for ($i = 0; $i < $pattern; $i++)
				if (!in_array($patternfile[$i], $exclude_list) && $patternfile[$i] != '')
				{
				$this->_html .= '<div class="form-group">';
				$this->_html .= '<label class="control-label col-lg-3">'.$patternfile[$i].'</label>';
				$this->_html .= '<div class="col-lg-9">';
				$this->_html .= '	<img style="border:1px solid #ccc;padding:10px;margin:0;max-width:200px;max-height:100px;"
										src="'._MODULE_DIR_.$this->name.'/images/'.$css_id.'/'.$patternfile[$i].'" />';
				$this->_html .= '</div>
								</div>';
				}
		}

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3 ">'.$this->l('New Pattern:').'</label>';
		$this->_html .= '<div class="col-lg-9">
							<input id="adv_'.$css_id.'_file" type="file" name="adv_'.$css_id.'_file" />
						</div>
						</div>';

		$this->_html .= '<div class="form-group">';
		$this->_html .= '<label class="control-label col-lg-3 "></label>';
		$this->_html .= '<div class="col-lg-9">
							<input class="button" type="submit" name="submitBackpattern_adv_'.$css_id.'" value="'.$this->l('Upload Pattern').'"/>
						</div>
						</div>';

	}

	private function loadConfigFile($setting_value)
	{
		$j = 0;
		$fp = fopen(_PS_MODULE_DIR_.'uhu_setting/config/tablist.txt', 'rb');
		if ($fp)
		{
			while (! feof($fp))
			{
				$temp = fgets($fp);
				$temp = fgets($fp);
				$temp = trim(fgets($fp));
				if ($temp <> '')
					Configuration::updateValue('uhu_cssselect_8_'.$j, $temp);
				$j++;
			}
			fclose($fp);
		}

		/*
			读取uhu_setting下的个性化设计参数
		*/
		$quickinstall = Configuration::get('uhu_css_2012_column');

		$fp = fopen(_PS_MODULE_DIR_.'uhu_setting/config/modlist.txt', 'rb');
		if ($fp)
		{
			$mod_number = fgets($fp);
			Configuration::updateValue('uhu_mod_number', $mod_number);

			for ($i = 0; $i < Configuration::get('uhu_mod_number'); $i++)
			{
				$temp = trim(fgets($fp));
				if ($temp <> '')
					Configuration::updateValue('uhu_mod_id_'.$i, $temp);

				$temp = trim(fgets($fp));
				if ($temp <> '' && $quickinstall == '1')
					Configuration::updateValue('uhu_mod_title_'.$i, $temp);

				$temp = trim(fgets($fp));
				if ($temp <> '')
					Configuration::updateValue('uhu_mod_total_'.$i, $temp);

				$temp = trim(fgets($fp));
				if ($temp <> '' && $quickinstall == '1')
					Configuration::updateValue('uhu_mod_adver_'.$i, $temp);

				$fp2 = fopen(_PS_MODULE_DIR_.'uhu_setting/config/mod_'.Configuration::get('uhu_mod_id_'.$i).'.txt', 'rb');
				if ($fp2)
				for ($j = 0; $j < Configuration::get('uhu_mod_total_'.$i); $j++)
				{
					if ($quickinstall == '0')
					{
						$tab_id = Configuration::get('uhu_mod_id_'.$i).'_'.$j;

						fgets($fp2);//Configuration::updateValue('uhu_modorder_'.$tab_id, trim(fgets($fp2)));
						fgets($fp2);//Configuration::updateValue('uhu_modtype_'.$tab_id, trim(fgets($fp2)));
						fgets($fp2);//Configuration::updateValue('uhu_modid_'.$tab_id, trim(fgets($fp2)));
						fgets($fp2);//Configuration::updateValue('uhu_modtitle_'.$tab_id, trim(fgets($fp2)));
						fgets($fp2);//Configuration::updateValue('uhu_modinfo_'.$tab_id, trim(fgets($fp2)));

						$temp = trim(fgets($fp2));
						if ($temp <> '')
							Configuration::updateValue('uhu_modvalue_'.$tab_id, $temp);

						fgets($fp2);
						fgets($fp2);
						fgets($fp2);
					}

					if ($quickinstall == '1')
					{
						$tab_id = Configuration::get('uhu_mod_id_'.$i).'_'.$j;

						Configuration::updateValue('uhu_modorder_'.$tab_id, trim(fgets($fp2)));
						Configuration::updateValue('uhu_modtype_'.$tab_id, trim(fgets($fp2)));
						Configuration::updateValue('uhu_modid_'.$tab_id, trim(fgets($fp2)));
						fgets($fp2);//Configuration::updateValue('uhu_modtitle_'.$tab_id, trim(fgets($fp2)));

						if (Configuration::get('uhu_mod_id_'.$i) == 'setting')
						{
							$temp = trim(fgets($fp2));
							if ($temp <> '')
								Configuration::updateValue('uhu_modinfo_'.$tab_id, $temp);
						}
						else
							fgets($fp2);//Configuration::updateValue('uhu_modinfo_'.$tab_id, trim(fgets($fp2)));

						if ($setting_value == 'yes')
						{
							$temp = trim(fgets($fp2));
							if ($temp <> '')
								Configuration::updateValue('uhu_modvalue_'.$tab_id, $temp);
						}
						else
							fgets($fp2);

						$temp = trim(fgets($fp2));
						if ($temp <> '')
							Configuration::updateValue('uhu_moddisplay_'.$tab_id, $temp);

						$temp = trim(fgets($fp2));
						if ($temp <> '')
							Configuration::updateValue('uhu_modname_'.$tab_id, $temp);

						$temp = trim(fgets($fp2));
						if ($temp <> '')
							Configuration::updateValue('uhu_moddesp_'.$tab_id, $temp);
					}
				}
				fclose($fp2);
			}
			fclose($fp);

			//Configuration::updateValue('PS_SHOP_NAME', Configuration::get('uhu_modvalue_logo_2'));
		}
	}
}