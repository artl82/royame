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

/* v4.16.5 */

if (!defined('_PS_VERSION_'))
	exit;

class Uhu_reassure extends Module
{

	public function __construct()
	{
		$this->name = 'uhu_reassure';
		$this->tab = 'others';
		$this->version = '4.16.5';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Reassurance block';
		$this->description = $this->l('Adds an information block aimed at offering helpful information to reassure customers that your store is trustworthy.');
	}

	public function install()
	{
		$mod_id = 9;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
		$hook = Configuration::get('uhu_modvalue_'.$mod_name.'_20');

		if ($hook == 'FooterNav')
			return (parent::install() && $this->registerHook('displayFooterNav'));
		else if ($hook == 'FooterBanner')
			return (parent::install() && $this->registerHook('displayFooterBanner'));
		else
			return (parent::install() && $this->registerHook('footer'));
	}

	public function hookFooter($params)
	{
		$mod_id = 9;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 0;
		$itemgrid = 1;
		$totalitems = 2;
		$icon = 3;
		$reassure_image_0 = 4;
		$reassure_image_1 = 5;
		$reassure_image_2 = 6;
		$reassure_image_3 = 7;
		$reassure_image_4 = 8;
		$reassure_link_0 = 9;
		$reassure_link_1 = 10;
		$reassure_link_2 = 11;
		$reassure_link_3 = 12;
		$reassure_link_4 = 13;
		$reassure_text_0 = 14;
		$reassure_text_1 = 15;
		$reassure_text_2 = 16;
		$reassure_text_3 = 17;
		$reassure_text_4 = 18;

		$this->smarty->assign(array(
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'itemgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$itemgrid),
			'reassure_number' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalitems),
			'icon' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$icon),
			'imgurl' => $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$mod_name.'/',
			'reassure_image_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_image_0),
			'reassure_image_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_image_1),
			'reassure_image_2' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_image_2),
			'reassure_image_3' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_image_3),
			'reassure_image_4' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_image_4),
			'reassure_link_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_link_0),
			'reassure_link_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_link_1),
			'reassure_link_2' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_link_2),
			'reassure_link_3' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_link_3),
			'reassure_link_4' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_link_4),
			'reassure_text_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_text_0),
			'reassure_text_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_text_1),
			'reassure_text_2' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_text_2),
			'reassure_text_3' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_text_3),
			'reassure_text_4' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$reassure_text_4)
		));

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_19');

		/*
		// uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (isset($_COOKIE['reassure']))
			{
				if($_COOKIE['reassure'] == 'show')
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

	public function hookdisplayFooterNav($params)
	{
		return $this->hookFooter($params);
	}

	public function hookdisplayFooterBanner($params)
	{
		return $this->hookFooter($params);
	}
}