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

/* v4.16.03 */

if (!defined('_PS_VERSION_'))
	exit;

class Uhu_social extends Module
{

	public function __construct()
	{
		$this->name = 'uhu_social';
		$this->tab = 'others';
		$this->version = '4.16.03';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Social networking block';
		$this->description = $this->l('Allows you to add extra information about social networks.');
	}

	public function install()
	{
		$mod_id = 6;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
		$hook = Configuration::get('uhu_modvalue_'.$mod_name.'_24');

		if ($hook == 'FooterNav')
			return (parent::install() && $this->registerHook('displayFooterNav'));
		else
			return (parent::install() && $this->registerHook('footer'));
	}

	public function hookFooter($params)
	{
		$mod_id = 6;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 0;
		$social_number = 1;
		$social_type = 2;

		$social_icons = array();
		$social_links = array();
		for ($i = 0; $i < Configuration::get('uhu_modvalue_'.$mod_name.'_'.$social_number); $i++)
		{
			$social_icons[$i] = 3 + $i;
			$social_links[$i] = 13 + $i;
		}

		$this->smarty->assign(array(
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'social_number' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$social_number),
			'social_type' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$social_type)
			));

		for ($i = 0; $i < Configuration::get('uhu_modvalue_'.$mod_name.'_'.$social_number); $i++)
		$this->smarty->assign(array(
			'social_icons_'.$i => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$social_icons[$i]),
			'social_links_'.$i => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$social_links[$i]),
			));

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_23');

		if ($enable == 'yes')
		return $this->display(__FILE__, $this->name.'.tpl');
	}

	public function hookdisplayFooterNav($params)
	{
		return $this->hookFooter($params);
	}
}