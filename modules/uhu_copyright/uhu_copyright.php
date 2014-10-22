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

class Uhu_copyright extends Module
{
	public function __construct()
	{
		$this->name = 'uhu_copyright';
		$this->tab = 'others';
		$this->author = 'uhuPage';
		$this->version = '4.16.4';

		parent::__construct();

		$this->displayName = 'uhu Copyright block';
		$this->description = $this->l('Add a block to add coprright information.');
	}

	public function install()
	{
		$mod_id = 26;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
		$hook = Configuration::get('uhu_modvalue_'.$mod_name.'_5');

		if ($hook == 'FooterBanner')
			return (parent::install() && $this->registerHook('displayFooterBanner'));
		else
			return (parent::install() && $this->registerHook('footer'));
	}

	public function uninstall()
	{
		return (parent::uninstall());
	}

	public function hookFooter($params)
	{
		$mod_id = 26;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 0;
		$company = 1;
		$copyright = 2;
		$logo = 3;
		$footall = 4;

		$this->smarty->assign(array(
			'totalgrid' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid),
			'company' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$company),
			'copyright' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$copyright),
			'imgurl' => $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$mod_name.'/',
			'logo' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$logo),
			'footall' => Configuration::get('uhu_modvalue_'.$mod_name.'_'.$footall)
		));

		return $this->display(__FILE__, $this->name.'.tpl');
	}

	public function hookdisplayFooterBanner($params)
	{
		return $this->hookFooter($params);
	}
}
?>
