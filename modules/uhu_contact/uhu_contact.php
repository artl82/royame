<?php
/*
* 2007-2013 PrestaShop
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
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class Uhu_contact extends Module
{

	public function __construct()
	{
		$this->name = 'uhu_contact';
		$this->tab = 'others';
		$this->version = '4.16.4';
		$this->author = 'uhupage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Contact block';
		$this->description = $this->l('Allows you to add additional information about your store&#039;s customer service.');
	}

	public function install()
	{
		return (parent::install() && $this->registerHook('displayNav'));
	}

	public function hookDisplayNav($params)
	{
		$mod_id = 5;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 0;
		$shop_telnumber = 1;
		$shop_email = 2;

		$this->smarty->assign(array(
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'shop_telnumber' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$shop_telnumber),
			'shop_email' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$shop_email)
			));

		return $this->display(__FILE__, $this->name.'.tpl');
	}

}
