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



/* v4.16.6 */

if (!defined('_PS_VERSION_'))
	exit;

class Uhu_cp_1901 extends Module
{

	public function __construct()
	{
		$this->name = 'uhu_cp_1901';
		$this->tab = 'others';
		$this->version = '4.16.6';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu_bestsellers';
		$this->description = $this->l('Add a block displaying the shop\'s top sellers.');
	}

	public function install()
	{
		return (parent::install() && $this->registerHook('home'));
	}

	public function uninstall()
	{
		return (parent::uninstall());
	}

	public function hookHome($params)
	{
		$mod_id = 11;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 0;
		$productgrid = 1;
		$perline = 2;
		$totalproducts = 3;
		$imggrid = 4;
		$infogrid = 5;
		$awesome = 6;
		$title_awesome = 7;
		$firstimggrid = 8;
		$firstinfogrid = 9;
		$showcomment = 11;
		$totalcomment = Configuration::get('uhu_modvalue_'.$mod_name.'_12');
		$waterfall = 13;
		$titlepos = 14;
		$titlebkimg = 15;
		$imgurl = $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$mod_name.'/';
		$this->smarty->assign('titlebkimg', $imgurl.Configuration::get('uhu_modvalue_'.$mod_name.'_'.$titlebkimg));
		$csstype = 16;
		$showprice = 17;
		$advergrid = 18;
		$adverimg = 19;
		$this->smarty->assign('adverimg', $imgurl.Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adverimg));
		$adverlink = 20;

		$nb = Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalproducts);

		if (Configuration::get('PS_CATALOG_MODE'))
			return;

		if (!($result = ProductSale::getBestSalesLight((int)$params['cookie']->id_lang, 0, $nb)))
			return (Configuration::get('PS_BLOCK_BESTSELLERS_DISPLAY') ? array() : false);

		$currency = new Currency($params['cookie']->id_currency);
		$usetax = (Product::getTaxCalculationMethod((int)$this->context->customer->id) != PS_TAX_EXC);
		foreach ($result as &$row)
		{
			$row['price'] = Tools::displayPrice(Product::getPriceStatic((int)$row['id_product'], $usetax), $currency);
			$row['comments'] = $this->getByProduct((int)$row['id_product'], 1, $totalcomment);
		}

		$this->smarty->assign(array(
			'products' => $result,
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'productgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$productgrid),
			'perline' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$perline),
			'imggrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$imggrid),
			'infogrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$infogrid),
			'awesome' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$awesome),
			'title_awesome' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$title_awesome),
			'firstimggrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$firstimggrid),
			'firstinfogrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$firstinfogrid),
			'showcomment' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$showcomment),
			'waterfall' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$waterfall),
			'titlepos' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$titlepos),
			'csstype' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$csstype),
			'showprice' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$showprice),
			'advergrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$advergrid),
			'adverlink' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$adverlink)
			));

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_10');

		/*
		// uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (isset($_COOKIE['cp1901']))
			{
				if($_COOKIE['cp1901'] == 'show')
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

		// adddons
		if ($enable == 'yes')
			return $this->display(__FILE__, $this->name.'.tpl');
	}

	public static function getByProduct($id_product, $p = 1, $n = null, $id_customer = null)
	{
		if (!Validate::isUnsignedId($id_product))
			die(Tools::displayError());
		$validate = Configuration::get('PRODUCT_COMMENTS_MODERATE');
		$p = (int)$p;
		$n = (int)$n;
		if ($p <= 1)
			$p = 1;
		if ($n != null && $n <= 0)
			$n = 5;

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT pc.`id_product_comment`,
			(SELECT count(*) FROM `'._DB_PREFIX_.'product_comment_usefulness` pcu WHERE pcu.`id_product_comment` = pc.`id_product_comment` AND pcu.`usefulness` = 1) as total_useful,
			(SELECT count(*) FROM `'._DB_PREFIX_.'product_comment_usefulness` pcu WHERE pcu.`id_product_comment` = pc.`id_product_comment`) as total_advice, '.
			((int)$id_customer ? '(SELECT count(*) FROM `'._DB_PREFIX_.'product_comment_usefulness` pcuc WHERE pcuc.`id_product_comment` = pc.`id_product_comment` AND pcuc.id_customer = '.(int)$id_customer.') as customer_advice, ' : '').
			((int)$id_customer ? '(SELECT count(*) FROM `'._DB_PREFIX_.'product_comment_report` pcrc WHERE pcrc.`id_product_comment` = pc.`id_product_comment` AND pcrc.id_customer = '.(int)$id_customer.') as customer_report, ' : '').'
			IF(c.id_customer, CONCAT(c.`firstname`, \' \',  LEFT(c.`lastname`, 1)), pc.customer_name) customer_name, pc.`content`, pc.`grade`, pc.`date_add`, pc.title
			  FROM `'._DB_PREFIX_.'product_comment` pc
			LEFT JOIN `'._DB_PREFIX_.'customer` c ON c.`id_customer` = pc.`id_customer`
			WHERE pc.`id_product` = '.(int)$id_product.($validate == '1' ? ' AND pc.`validate` = 1' : '').'
			ORDER BY pc.`date_add` DESC
			'.($n ? 'LIMIT '.(int)(($p - 1) * $n).', '.(int)$n : ''));

		return $result;
	}

}