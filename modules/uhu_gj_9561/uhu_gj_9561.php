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


/* v4.16.07 */


if (!defined('_PS_VERSION_'))
	exit;

class Uhu_gj_9561 extends Module
{

	public function __construct()
	{
		$this->name = 'uhu_gj_9561';
		$this->tab = 'others';
		$this->version = '4.16.07';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Advertising block 9561';
		$this->description = $this->l('Adds a block to display six advertisements.');
	}

	public function install()
	{
		$mod_id = 33;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
		$pos = 0;
		$hook = Configuration::get('uhu_modvalue_'.$mod_name.'_'.$pos);

		if ($hook == 'top')
			return (parent::install() && $this->registerHook('displayTopColumn'));
		else if ($hook == 'foot')
			return (parent::install() && $this->registerHook('footer'));
		else
			return (parent::install() && $this->registerHook('home'));
	}

	public function hookHome($params)
	{
		$mod_id = 33;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$adv_image = array();
		$pos = 0;
		$totalgrid = 1;
		$adgrid = 2;
		$oneonly = 3;
		$adv_image[0] = 4;
		$adv_image[1] = 6;
		$adv_image[2] = 8;
		$adv_image[3] = 10;
		$adv_image[4] = 12;
		$adv_image[5] = 16;
		$adv_link_0 = 5;
		$adv_link_1 = 7;
		$adv_link_2 = 9;
		$adv_link_3 = 11;
		$adv_link_4 = 13;
		$adv_link_5 = 17;

		$this->smarty->assign(array(
			'adv_number' => 6,
			'pos' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$pos),
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'adgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adgrid),
			'adv_link_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_0),
			'adv_link_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_1),
			'adv_link_2' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_2),
			'adv_link_3' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_3),
			'adv_link_4' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_4),
			'adv_link_5' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_5),
			'zoom' => Configuration::get('uhu_modvalue_'.$mod_name.'_15')
		));

		$imgurl = $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$mod_name.'/';

		$langs = explode('|', Configuration::get('uhu_modvalue_'.$mod_name.'_'.$oneonly));
		$lang_iso = Language::getIsoById($params['cookie']->id_lang);
		$lang_id = 0;
		if (array_search($lang_iso, $langs) <> false)
			$lang_id = array_search($lang_iso, $langs);

		for ($i = 0; $i < 6; $i++)
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

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_14');

		/*
		// uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (isset($_COOKIE['gj9561']))
			{
				if($_COOKIE['gj9561'] == 'show')
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

	public function hookFooter($params)
	{
		return $this->hookHome($params);
	}

}