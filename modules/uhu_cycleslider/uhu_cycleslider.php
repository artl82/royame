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



/* uhu_gd_9501 v4.16.7 */

if (!defined('_PS_VERSION_'))
	exit;

class uhu_cycleslider extends Module
{

	public function __construct()
	{
		$this->name = 'uhu_cycleslider';
		$this->tab = 'others';
		$this->version = '4.16.7';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Image Cycle slider';
		$this->description = $this->l('Adds an image slider to your homepage.');

		$mod_id = 32;
		$this->mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
	}

	public function install()
	{
		$pos = 1;
		$hook = Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$pos);

		if ($hook == 'top')
			return (parent::install() && $this->registerHook('displayTopColumn'));
		else if ($hook == 'foot')
			return (parent::install() && $this->registerHook('footer'));
		else
			return (parent::install() && $this->registerHook('home'));
	}

	public function uninstall()
	{
		return (parent::uninstall());
	}

	public function hookHome($params)
	{
		$this->smarty->assign('module_name', $this->name);

		$totalgrid = 0;
		$pos = 1;
		$totalads = 2;

		$slider_time = 3;

		$oneonly = 5;
		$awesome_prev = 6;
		$awesome_next = 7;

		// Slider 0
		$slider0_show = 10;
		$slider0_image = 11;

		$slider_title = array();
		$slider_text = array();
		$slider_logo = array();
		$slider_link = array();

		// Title
		$slider_title[0] = 12;
		//$slider0_title_color = 13;
		$slider0_title_font = 14;
		$slider0_title_top = 15;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_title_top));
		$slider0_title_topafter = $top[0];
		if (count($top) == 2)
			$slider0_title_topbefore = $top[1];
		else
			$slider0_title_topbefore = $top[0];

		$slider0_title_left = 16;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_title_left));
		$slider0_title_leftafter = $left[0];
		if (count($left) == 2)
			$slider0_title_leftbefore = $left[1];
		else
			$slider0_title_leftbefore = $left[0];

		// Text
		$slider_text[0] = 17;
		//$slider0_text_color = 18;
		$slider0_text_font = 19;

		$slider0_text_top = 20;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_text_top));
		$slider0_text_topafter = $top[0];
		if (count($top) == 2)
			$slider0_text_topbefore = $top[1];
		else
			$slider0_text_topbefore = $top[0];

		$slider0_text_left = 21;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_text_left));
		$slider0_text_leftafter = $left[0];
		if (count($left) == 2)
			$slider0_text_leftbefore = $left[1];
		else
			$slider0_text_leftbefore = $left[0];

		//Logo
		$slider_logo[0] = 22;

		$slider0_logo_top = 23;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_logo_top));
		$slider0_logo_topafter = $top[0];
		if (count($top) == 2)
			$slider0_logo_topbefore = $top[1];
		else
			$slider0_logo_topbefore = $top[0];

		$slider0_logo_left = 24;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_logo_left));
		$slider0_logo_leftafter = $left[0];
		if (count($left) == 2)
			$slider0_logo_leftbefore = $left[1];
		else
			$slider0_logo_leftbefore = $left[0];

		//Link
		$slider_link[0] = 25;
		//$slider0_link_color = 26;
		$slider0_link_font = 27;

		$slider0_link_top = 28;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_link_top));
		$slider0_link_topafter = $top[0];
		if (count($top) == 2)
			$slider0_link_topbefore = $top[1];
		else
			$slider0_link_topbefore = $top[0];

		$slider0_link_left = 29;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_link_left));
		$slider0_link_leftafter = $left[0];
		if (count($left) == 2)
			$slider0_link_leftbefore = $left[1];
		else
			$slider0_link_leftbefore = $left[0];

		$slider0_url = 30;

		/*
			Slider 1
		*/
		$slider1_show = 40;
		$slider1_image = 41;

		// Title
		$slider_title[1] = 42;
		//$slider1_title_color = 43;
		$slider1_title_font = 44;
		$slider1_title_top = 45;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_title_top));
		$slider1_title_topafter = $top[0];
		if (count($top) == 2)
			$slider1_title_topbefore = $top[1];
		else
			$slider1_title_topbefore = $top[0];

		$slider1_title_left = 46;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_title_left));
		$slider1_title_leftafter = $left[0];
		if (count($left) == 2)
			$slider1_title_leftbefore = $left[1];
		else
			$slider1_title_leftbefore = $left[0];

		// Text
		$slider_text[1] = 47;
		//$slider1_text_color = 48;
		$slider1_text_font = 49;

		$slider1_text_top = 50;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_text_top));
		$slider1_text_topafter = $top[0];
		if (count($top) == 2)
			$slider1_text_topbefore = $top[1];
		else
			$slider1_text_topbefore = $top[0];

		$slider1_text_left = 51;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_text_left));
		$slider1_text_leftafter = $left[0];
		if (count($left) == 2)
			$slider1_text_leftbefore = $left[1];
		else
			$slider1_text_leftbefore = $left[0];

		//Logo
		$slider_logo[1] = 52;

		$slider1_logo_top = 53;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_logo_top));
		$slider1_logo_topafter = $top[0];
		if (count($top) == 2)
			$slider1_logo_topbefore = $top[1];
		else
			$slider1_logo_topbefore = $top[0];

		$slider1_logo_left = 54;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_logo_left));
		$slider1_logo_leftafter = $left[0];
		if (count($left) == 2)
			$slider1_logo_leftbefore = $left[1];
		else
			$slider1_logo_leftbefore = $left[0];

		//Link
		$slider_link[1] = 55;
		//$slider1_link_color = 56;
		$slider1_link_font = 57;

		$slider1_link_top = 58;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_link_top));
		$slider1_link_topafter = $top[0];
		if (count($top) == 2)
			$slider1_link_topbefore = $top[1];
		else
			$slider1_link_topbefore = $top[0];

		$slider1_link_left = 59;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_link_left));
		$slider1_link_leftafter = $left[0];
		if (count($left) == 2)
			$slider1_link_leftbefore = $left[1];
		else
			$slider1_link_leftbefore = $left[0];

		$slider1_url = 60;

		/*
			Slider 3
		*/
		$slider2_show = 70;
		$slider2_image = 71;

		// Title
		$slider_title[2] = 72;
		//$slider2_title_color = 73;
		$slider2_title_font = 74;
		$slider2_title_top = 75;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_title_top));
		$slider2_title_topafter = $top[0];
		if (count($top) == 2)
			$slider2_title_topbefore = $top[1];
		else
			$slider2_title_topbefore = $top[0];

		$slider2_title_left = 76;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_title_left));
		$slider2_title_leftafter = $left[0];
		if (count($left) == 2)
			$slider2_title_leftbefore = $left[1];
		else
			$slider2_title_leftbefore = $left[0];

		// Text
		$slider_text[2] = 77;
		//$slider2_text_color = 78;
		$slider2_text_font = 79;

		$slider2_text_top = 80;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_text_top));
		$slider2_text_topafter = $top[0];
		if (count($top) == 2)
			$slider2_text_topbefore = $top[1];
		else
			$slider2_text_topbefore = $top[0];

		$slider2_text_left = 81;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_text_left));
		$slider2_text_leftafter = $left[0];
		if (count($left) == 2)
			$slider2_text_leftbefore = $left[1];
		else
			$slider2_text_leftbefore = $left[0];

		//Logo
		$slider_logo[2] = 82;

		$slider2_logo_top = 83;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_logo_top));
		$slider2_logo_topafter = $top[0];
		if (count($top) == 2)
			$slider2_logo_topbefore = $top[1];
		else
			$slider2_logo_topbefore = $top[0];

		$slider2_logo_left = 84;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_logo_left));
		$slider2_logo_leftafter = $left[0];
		if (count($left) == 2)
			$slider2_logo_leftbefore = $left[1];
		else
			$slider2_logo_leftbefore = $left[0];

		//Link
		$slider_link[2] = 85;
		//$slider2_link_color = 86;
		$slider2_link_font = 87;

		$slider2_link_top = 88;
		$top = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_link_top));
		$slider2_link_topafter = $top[0];
		if (count($top) == 2)
			$slider2_link_topbefore = $top[1];
		else
			$slider2_link_topbefore = $top[0];

		$slider2_link_left = 89;
		$left = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_link_left));
		$slider2_link_leftafter = $left[0];
		if (count($left) == 2)
			$slider2_link_leftbefore = $left[1];
		else
			$slider2_link_leftbefore = $left[0];

		$slider2_url = 90;

		//
		$show_newproduct = 91;
		$productgrid = 92;
		$newproductpos = 93;
		$awesome = 94;
		$dd_adjust = Configuration::get('uhu_modvalue_'.$this->mod_name.'_95');
		if ($dd_adjust == '')
			$dd_adjust = 3;
		$pgrid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_97');
		$pline = Configuration::get('uhu_modvalue_'.$this->mod_name.'_98');

		$position = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$newproductpos));
		$position_newproduct_top = $position[0];
		if (count($position) == 2)
			$position_newproduct_left = $position[1];
		else
			$position_newproduct_left = $position[0];

		$nb = 4;
		if (Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$show_newproduct) == 'true')
			$products = Product::getNewProducts($params['cookie']->id_lang, 0, ($nb ? $nb : 10));
		else
			$products = false;

		$this->smarty->assign(array(
			'totalgrid' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$totalgrid),
			'slider_number' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$totalads),
			'slider_time' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider_time),
			'pos' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$pos),
			'imgurl' => $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$this->mod_name.'/',
			'awesome_prev' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$awesome_prev),
			'awesome_next' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$awesome_next),
			'awesome' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$awesome),
			'dd_adjust' => $dd_adjust,
			'pgrid' => $pgrid,
			'pline' => $pline,
			'productgrid' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$productgrid),
			'position_newproduct_top' => $position_newproduct_top,
			'position_newproduct_left' => $position_newproduct_left,
			'products' => $products
		));

		$this->smarty->assign(array(
			'slider0_show' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_show),

			'slider0_title_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_title_font),
			'slider0_title_topbefore' => $slider0_title_topbefore,
			'slider0_title_topafter' => $slider0_title_topafter,
			'slider0_title_leftbefore' => $slider0_title_leftbefore,
			'slider0_title_leftafter' => $slider0_title_leftafter,

			'slider0_text_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_text_font),
			'slider0_text_topbefore' => $slider0_text_topbefore,
			'slider0_text_topafter' => $slider0_text_topafter,
			'slider0_text_leftbefore' => $slider0_text_leftbefore,
			'slider0_text_leftafter' => $slider0_text_leftafter,

			'slider0_logo_topbefore' => $slider0_logo_topbefore,
			'slider0_logo_topafter' => $slider0_logo_topafter,
			'slider0_logo_leftbefore' => $slider0_logo_leftbefore,
			'slider0_logo_leftafter' => $slider0_logo_leftafter,

			'slider0_link_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_link_font),
			'slider0_link_topbefore' => $slider0_link_topbefore,
			'slider0_link_topafter' => $slider0_link_topafter,
			'slider0_link_leftbefore' => $slider0_link_leftbefore,
			'slider0_link_leftafter' => $slider0_link_leftafter,

			'slider0_url' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_url),
		));

		$this->smarty->assign(array(
			'slider1_show' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_show),

			'slider1_title_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_title_font),
			'slider1_title_topbefore' => $slider1_title_topbefore,
			'slider1_title_topafter' => $slider1_title_topafter,
			'slider1_title_leftbefore' => $slider1_title_leftbefore,
			'slider1_title_leftafter' => $slider1_title_leftafter,

			'slider1_text_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_text_font),
			'slider1_text_topbefore' => $slider1_text_topbefore,
			'slider1_text_topafter' => $slider1_text_topafter,
			'slider1_text_leftbefore' => $slider1_text_leftbefore,
			'slider1_text_leftafter' => $slider1_text_leftafter,

			'slider1_logo_topbefore' => $slider1_logo_topbefore,
			'slider1_logo_topafter' => $slider1_logo_topafter,
			'slider1_logo_leftbefore' => $slider1_logo_leftbefore,
			'slider1_logo_leftafter' => $slider1_logo_leftafter,

			'slider1_link_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_link_font),
			'slider1_link_topbefore' => $slider1_link_topbefore,
			'slider1_link_topafter' => $slider1_link_topafter,
			'slider1_link_leftbefore' => $slider1_link_leftbefore,
			'slider1_link_leftafter' => $slider1_link_leftafter,

			'slider1_url' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_url),
		));

		$this->smarty->assign(array(
			'slider2_show' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_show),

			'slider2_title_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_title_font),
			'slider2_title_topbefore' => $slider2_title_topbefore,
			'slider2_title_topafter' => $slider2_title_topafter,
			'slider2_title_leftbefore' => $slider2_title_leftbefore,
			'slider2_title_leftafter' => $slider2_title_leftafter,

			'slider2_text_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_text_font),
			'slider2_text_topbefore' => $slider2_text_topbefore,
			'slider2_text_topafter' => $slider2_text_topafter,
			'slider2_text_leftbefore' => $slider2_text_leftbefore,
			'slider2_text_leftafter' => $slider2_text_leftafter,

			'slider2_logo_topbefore' => $slider2_logo_topbefore,
			'slider2_logo_topafter' => $slider2_logo_topafter,
			'slider2_logo_leftbefore' => $slider2_logo_leftbefore,
			'slider2_logo_leftafter' => $slider2_logo_leftafter,

			'slider2_link_font' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_link_font),
			'slider2_link_topbefore' => $slider2_link_topbefore,
			'slider2_link_topafter' => $slider2_link_topafter,
			'slider2_link_leftbefore' => $slider2_link_leftbefore,
			'slider2_link_leftafter' => $slider2_link_leftafter,

			'slider2_url' => Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_url),
		));

		$langs = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$oneonly));
		$lang_iso = Language::getIsoById($params['cookie']->id_lang);
		$lang_id = 0;
		if (array_search($lang_iso, $langs) <> false)
			$lang_id = array_search($lang_iso, $langs);

		for ($i = 0; $i < 3; $i++)
		{
			$slider_titles = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider_title[$i]));
			if (isset($slider_titles[$lang_id]))
				$stitle = $slider_titles[$lang_id];
			else
				$stitle = $slider_titles[0];
			$this->smarty->assign('slider'.$i.'_title', $stitle);

			$slider_texts = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider_text[$i]));
			if (isset($slider_texts[$lang_id]))
				$stext = $slider_texts[$lang_id];
			else
				$stext = $slider_texts[0];
			$this->smarty->assign('slider'.$i.'_text', $stext);

			$slider_logos = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider_logo[$i]));
			if (isset($slider_logos[$lang_id]))
				$slogo = $slider_logos[$lang_id];
			else
				$slogo = $slider_logos[0];
			$this->smarty->assign('slider'.$i.'_logo', $slogo);

			$slider_links = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider_link[$i]));
			if (isset($slider_links[$lang_id]))
				$slink = $slider_links[$lang_id];
			else
				$slink = $slider_links[0];
			$this->smarty->assign('slider'.$i.'_link', $slink);
		}

		$imgurl = $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$this->mod_name.'/';

		if (strstr(Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_image), 'http://') <> '')
			$this->smarty->assign('slider0_image', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_image));
		else
			$this->smarty->assign('slider0_image', $imgurl.Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider0_image));

		if (strstr(Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_image), 'http://') <> '')
			$this->smarty->assign('slider1_image', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_image));
		else
			$this->smarty->assign('slider1_image', $imgurl.Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider1_image));

		if (strstr(Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_image), 'http://') <> '')
			$this->smarty->assign('slider2_image', Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_image));
		else
			$this->smarty->assign('slider2_image', $imgurl.Configuration::get('uhu_modvalue_'.$this->mod_name.'_'.$slider2_image));

		$enable = Configuration::get('uhu_modvalue_'.$this->mod_name.'_4');

		/*
		// uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (isset($_COOKIE['slider']))
			{
				if ($_COOKIE['slider'] == 'cy')
					return $this->display(__FILE__, $this->name.'.tpl');
			}
			else
			if ($enable == 'yes')
				return $this->display(__FILE__, $this->name.'.tpl');
		}
		else
		{
			if ($enable == 'yes')
				return $this->display(__FILE__, $this->name.'.tpl');
		}
		*/

		// addons
		if ($enable == 'yes')
			return $this->display(__FILE__, $this->name.'.tpl');
	}

	public function hookdisplayTopColumn($params)
	{
		return $this->hookHome($params);
	}

}