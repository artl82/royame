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

/* v4.16.4 */

if (!defined('_PS_VERSION_'))
	exit;

class Uhu_featured extends Module
{

	public function __construct()
	{
		$this->name = 'uhu_featured';
		$this->tab = 'others';
		$this->version = '4.16.4';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Featured products';
		$this->description = $this->l('Displays featured products in the central column of your homepage.');
	}

	public function install()
	{
		return (parent::install() && $this->registerHook('home'));
	}

	public function hookHome($params)
	{
		$mod_id = 0;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 0;
		$productgrid = 1;
		$nb_items_per_line = 2;
		$totalproducts = 3;
		$ptype = 4;
		$title_pos = 5;
		$awesome = 6;
		$csstype = 8;
		$title_awesome = 9;

		$nb = Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalproducts);
		$type = Configuration::get('uhu_modvalue_'.$mod_name.'_'.$ptype);

		$category = new Category(Context::getContext()->shop->getCategory(), Configuration::get('PS_LANG_DEFAULT'));
		$products = $category->getProducts($params['cookie']->id_lang, 1, ($nb ? $nb : 10));

		if (!$products)
			return;

		$this->smarty->assign(array(
			'products' => $products,
			'ptype' => $type,
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'productgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$productgrid),
			'title_pos' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$title_pos),
			'nb_items_per_line' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$nb_items_per_line),
			'awesome' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$awesome),
			'csstype' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$csstype),
			'title_awesome' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$title_awesome)
			));

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_7');

		/*
		// uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (isset($_COOKIE['featured']))
			{
				if ($_COOKIE['featured'] == 'multi')
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

}