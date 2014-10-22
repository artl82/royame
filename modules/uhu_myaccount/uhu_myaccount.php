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

/* v4.16.04 */

if (!defined('_PS_VERSION_'))
	exit;

class Uhu_myaccount extends Module
{
	public function __construct()
	{
		$this->name = 'uhu_myaccount';
		$this->tab = 'others';
		$this->version = '4.16.04';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('uhu My account block');
		$this->description = $this->l('Displays a block with links relative to user accounts.');
	}

	public function install()
	{
		return (parent::install() && $this->registerHook('footer'));
	}

	public function hookFooter($params)
	{
		$mod_id = 4;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 1;

		$this->smarty->assign(array(
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'voucherAllowed' => CartRule::isFeatureActive(),
			'returnAllowed' => Configuration::get('PS_ORDER_RETURN'),
			'HOOK_BLOCK_MY_ACCOUNT' => Hook::exec('displayMyAccountBlockfooter')
			));

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_0');

		if ($enable == 'yes')
		return $this->display(__FILE__, $this->name.'.tpl');
	}
}
