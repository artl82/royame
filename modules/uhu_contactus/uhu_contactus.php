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


if (!defined('_CAN_LOAD_FILES_'))
	exit;

class Uhu_contactus extends Module
{
	public function __construct()
	{
		$this->name = 'uhu_contactus';
		$this->tab = 'others';
		$this->author = 'uhuPage';
		$this->version = '4.16.4';

		parent::__construct();

		$this->displayName = 'uhu Contact info block';
		$this->description = $this->l('This module will allow you to display your e-store&#039;s contact information in a customizable block.');
	}

	public function install()
	{
		return (parent::install() && $this->registerHook('footer'));
	}

	public function hookFooter($params)
	{
		$mod_id = 34;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 0;
		$company = 1;
		$address = 2;
		$phone = 3;
		$email = 4;
		$logo = 6;
		$title = 7;

		$this->smarty->assign(array(
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'imgurl' => $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$mod_name.'/',
			'logo' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$logo),
			'title' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$title),
			'company' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$company),
			'address' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$address),
			'phone' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$phone),
			'email' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$email)
			));

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_5');

		if ($enable == 'yes')
		return $this->display(__FILE__, $this->name.'.tpl');
	}
}
?>
