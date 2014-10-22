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

/* uhu_gd_9501 v4.16.6 */

if (!defined('_PS_VERSION_'))
	exit;

class uhu_bxslider extends Module
{
	public function __construct()
	{
		$this->name = 'uhu_bxslider';
		$this->tab = 'others';
		$this->version = '4.16.6';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Image bxslider';
		$this->description = $this->l('Adds an image slider to your homepage.');

		$mod_id = 2;
		$this->mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
	}

	public function install()
	{
		$hook = Configuration::get('uhu_modvalue_'.$this->mod_name.'_18');

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
		$mod_id = 2;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$adv_image = array();
		$totalgrid = 0;
		$totalads = 1;
		$oneonly = 2;
		$adv_image[0] = 3;
		$adv_image[1] = 4;
		$adv_image[2] = 5;
		$adv_image[3] = 6;
		$adv_image[4] = 7;
		$adv_link_0 = 8;
		$adv_link_1 = 9;
		$adv_link_2 = 10;
		$adv_link_3 = 11;
		$adv_link_4 = 12;
		$mode = 13;
		$awesome_prev = 14;
		$awesome_next = 15;
		$speed = 16;
		$autoplay = 19;

		$this->smarty->assign(array(
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'adv_number' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalads),
			'mode' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$mode),
			'speed' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$speed),
			'autoplay' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$autoplay),
			'awesome_prev' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$awesome_prev),
			'awesome_next' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$awesome_next),
			'adv_link_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_0),
			'adv_link_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_1),
			'adv_link_2' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_2),
			'adv_link_3' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_3),
			'adv_link_4' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_4)
		));

		$imgurl = $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$mod_name.'/';

		$langs = explode('|', Configuration::get('uhu_modvalue_'.$mod_name.'_'.$oneonly));
		$lang_iso = Language::getIsoById($params['cookie']->id_lang);
		$lang_id = 0;
		if (array_search($lang_iso, $langs) <> false)
			$lang_id = array_search($lang_iso, $langs);

		for ($i = 0; $i < 5; $i++)
		{
			$advimgs = explode('|', Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_image[$i]));
			if (isset($advimgs[$lang_id]))
				$adv = $advimgs[$lang_id];
			else
				$adv = $advimgs[0];
			if (strstr($adv, 'http://') <> '')
				$this->smarty->assign('adv_image_'.$i, $adv);
			else
				$this->smarty->assign('adv_image_'.$i, $imgurl.$adv);
		}

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_17');

		/*
		// uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (isset($_COOKIE['slider']))
			{
				if($_COOKIE['slider'] == 'bx')
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