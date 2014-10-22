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

/* uhuPage v4.16.4 */

if (!defined('_PS_VERSION_'))
	exit;

class Uhu_cms extends Module
{
	private $my_cms = '';

	/*
	 * Pattern for matching config values
	 */
	private $pattern = '/^([A-Z_]*)[0-9]+/';

	public function __construct()
	{
		$this->name = 'uhu_cms';
		$this->tab = 'others';
		$this->version = '4.16.4';
		$this->author = 'uhuPage';

		parent::__construct();

		$this->displayName = 'uhu CMS Block';
		$this->description = $this->l('Adds a block featuring some categories on footer.');
	}

	public function install()
	{
		$mod_id = 29;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
		$hook = Configuration::get('uhu_modvalue_'.$mod_name.'_8');

		if ($hook == 'FooterBanner')
			return (parent::install() && $this->registerHook('displayFooterBanner'));
		else
			return (parent::install() && $this->registerHook('footer'));
	}

	public function uninstall()
	{
		return (parent::uninstall());
	}

	private function getCategory($id_category, $id_lang = false)
	{
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
		$category = new Category((int)$id_category, (int)$id_lang);

		if ($category->level_depth > 1)
			$category_link = $category->getLink();
		else
			$category_link = $this->context->link->getPageLink('index');

		if (is_null($category->id))
			return;

		$this->my_menu .= '<li>';
		$this->my_menu .= '<a href="'.$category_link.'">'.$category->name.'</a>';
		$this->my_menu .= '</li>';
	}

	public function hookFooter($params)
	{
		$id_lang = (int)$this->context->language->id;

		$mod_id = 29;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = 1;
		$this->smarty->assign('totalgrid', Configuration::get('uhu_modvalue_'.$mod_name.'_'.$totalgrid));

		$cms_titles = array();
		$cms_items = explode(',', Configuration::get('uhu_modvalue_'.$mod_name.'_2'));
		foreach ($cms_items as $item)
		{
			if (!$item)
				continue;

			preg_match($this->pattern, $item, $value);
			$id = (int)Tools::substr($item, Tools::strlen($value[1]), Tools::strlen($item));
			$cms = CMS::getLinks((int)$id_lang, array($id));
			if (count($cms))
			{
				$cms_titles[$item]['link'] = $cms[0]['link'];
				$cms_titles[$item]['meta_title'] = $cms[0]['meta_title'];
			}
		}

		$footer_text = Configuration::get('uhu_modvalue_'.$mod_name.'_3');
		$display_footer = Configuration::get('uhu_modvalue_'.$mod_name.'_4') == 'yes' ? 1:0;
		$display_special = Configuration::get('uhu_modvalue_'.$mod_name.'_5') == 'yes' ? 1:0;
		$display_new = Configuration::get('uhu_modvalue_'.$mod_name.'_6') == 'yes' ? 1:0;
		$display_best = Configuration::get('uhu_modvalue_'.$mod_name.'_7') == 'yes' ? 1:0;

		$this->smarty->assign(
			array(
				'contact_url' => 'contact',
				'cmslinks' => $cms_titles,
				'display_stores_footer' => $display_footer,
				'display_special_footer' => $display_special,
				'display_new_footer' => $display_new,
				'display_best_footer' => $display_best,
				'footer_text' => $footer_text
			)
		);

		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_0');

		/*
		// uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (isset($_COOKIE['info']))
			{
				if ($_COOKIE['info'] == 'show')
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

	public function hookdisplayFooterBanner($params)
	{
		return $this->hookFooter($params);
	}

}
