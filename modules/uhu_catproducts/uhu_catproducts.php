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

class Uhu_catproducts extends Module
{

	public function __construct()
	{
		$this->name = 'uhu_catproducts';
		$this->tab = 'others';
		$this->version = '4.16.4';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu New products in Featured categories';
		$this->description = $this->l('Displays a block featuring newly added products in some Featured Categories.');
	}

	public function install()
	{
		return (parent::install() && $this->registerHook('home'));
	}

	public function hookHome($params)
	{
		$mod_id = 7;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 0;
		$productgrid = 1;
		$nb_items_per_line = 2;
		$totalproducts = 3;
		$ptype = 4;
		$title_pos = 5;
		$category_number = 6;

		$csstype = 11;
		$adv_number = 12;
		$oneonly = 13;

		$adgrid = 14;
		$pdgrid = 15;
		$picgrid = 16;

		$new_image_0 = 17;
		$new_link_0 = 18;
		$new_image_1 = 19;
		$new_link_1 = 20;

		$adv_image_0_0 = 21;
		$adv_link_0_0 = 22;
		$adv_image_0_1 = 23;
		$adv_link_0_1 = 24;

		$adv_image_1_0 = 25;
		$adv_link_1_0 = 26;
		$adv_image_1_1 = 27;
		$adv_link_1_1 = 28;

		$adv_image_2_0 = 29;
		$adv_link_2_0 = 30;
		$adv_image_2_1 = 31;
		$adv_link_2_1 = 32;

		$nb = Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalproducts);
		$type = Configuration::get('uhu_modvalue_'.$mod_name.'_'.$ptype);

		$this->smarty->assign(array(
			'ptype' => $type,
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'productgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$productgrid),
			'title_pos' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$title_pos),
			'nb_items_per_line' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$nb_items_per_line),
			'category_number' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$category_number),
			'csstype' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$csstype),
			'adv_number' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_number),
			'oneonly' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$oneonly),
			'adgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adgrid),
			'pdgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$pdgrid),
			'picgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$picgrid),
			'imgurl' => $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$mod_name.'/',
			'new_image_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$new_image_0),
			'new_link_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$new_link_0),
			'new_image_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$new_image_1),
			'new_link_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$new_link_1),
			'adv_image_0_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_image_0_0),
			'adv_link_0_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_0_0),
			'adv_image_0_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_image_0_1),
			'adv_link_0_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_0_1),
			'adv_image_1_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_image_1_0),
			'adv_link_1_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_1_0),
			'adv_image_1_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_image_1_1),
			'adv_link_1_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_1_1),
			'adv_image_2_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_image_2_0),
			'adv_link_2_0' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_2_0),
			'adv_image_2_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_image_2_1),
			'adv_link_2_1' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adv_link_2_1),
			));

		$products = Product::getNewProducts($params['cookie']->id_lang, 0, ($nb ? $nb : 10));
		$this->smarty->assign('products_new', $products);

		for ($i = 0; $i < Configuration::get('uhu_modvalue_'.$mod_name.'_'.$category_number); $i++)
		{
			$categoryid = Configuration::get('uhu_modvalue_'.$mod_name.'_'.($i + 7));
			$category = new Category($categoryid, Configuration::get('PS_LANG_DEFAULT'));
			$products = $category->getProducts($params['cookie']->id_lang, 1, ($nb ? $nb : 10), 'id_product', 'DESC');
			$this->smarty->assign('products_'.$i, $products);

			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
				SELECT c.`id_category`, cl.`name`
				FROM `'._DB_PREFIX_.'category` c
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category`)
				WHERE cl.`id_lang` = '.(int)$params['cookie']->id_lang.' AND cl.`id_category` = '.$categoryid.' 
				ORDER BY c.`position`');

			$this->smarty->assign('title_'.$i, $result['name']);
		}

		return $this->display(__FILE__, $this->name.'.tpl');
	}

}