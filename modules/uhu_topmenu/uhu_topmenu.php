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

class uhu_topmenu extends Module
{
	private $menu = '';
	private $menuroll = '';
	private $html = '';
	private $user_groups;

	private $menumobile = '';

	/*
	 * Pattern for matching config values
	 */
	private $pattern = '/^([A-Z_]*)[0-9]+/';

	/*
	 * Name of the controller
	 * Used to set item selected or not in top menu
	 */
	private $page_name = '';

	/*
	 * Spaces per depth in BO
	 */
	private $spacer_size = '5';

	public function __construct()
	{
		$this->name = 'uhu_topmenu';
		$this->tab = 'others';
		$this->version = '4.16.5';
		$this->author = 'uhuPage';

		parent::__construct();

		$this->displayName = 'uhu Top menu';
		$this->description = $this->l('Add a new menu on top of your shop.');

		$mod_id = 27;
		$this->mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

	}

	public function install()
	{
		if (!parent::install() ||
			!$this->registerHook('displayTop') ||
			!$this->registerHook('header') ||
			!Configuration::updateGlobalValue('uhu_modvalue_'.$this->mod_name.'_12', 'CAT3,PRD2,PRD3,PRD4,PRD5,MAN1,MAN2'))
			return false;

		return true;
	}

	public function uninstall()
	{
		return (parent::uninstall());
	}

	private function getMenuItems()
	{
		return explode(',', Configuration::get('uhu_modvalue_'.$this->mod_name.'_12'));
	}

	private function makeMenu()
	{
		$menu_items = $this->getMenuItems();
		$id_lang = (int)$this->context->language->id;
		//$id_shop = (int)Shop::getContextShopID();

		$cat_main = 'A';

		//$default_language = (int)Configuration::get('PS_LANG_DEFAULT');
		//$languages = Language::getLanguages(false);

		foreach ($menu_items as $item)
		{
			if (!$item || $item == 'CAT')
				continue;

			preg_match($this->pattern, $item, $value);
			$id = (int)Tools::substr($item, Tools::strlen($value[1]), Tools::strlen($item));

			switch (Tools::substr($item, 0, Tools::strlen($value[1])))
			{
				case 'CAT':
					$catetitle = Tools::substr($item, 0, Tools::strlen($value[1]));
					$con_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_0');
					$adv_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_1');

					$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
					$category = new Category((int)$id, (int)$id_lang);

					if ($category->level_depth > 1)
						$category_link = $category->getLink();
					else
						$category_link = $this->context->link->getPageLink('index');

					if (is_null($category->id))
						continue;

					$is_intersected = array_intersect($category->getGroups(), $this->user_groups);
					// filter the categories that the user is allowed to see and browse
					if (!empty($is_intersected))
					{
						$this->menu .= '<li class="nav_li cat">';
						$this->menu .= '<a class="nav_a roll" href="'.Tools::HtmlEntitiesUTF8($category_link).'" title=""><span data-title="'.$category->name.'">'.$category->name.'</span></a>';
						$this->menu .= '<div class="nav_pop col-md-12">';
						$this->menu .= '<dl class="pop_adver col-md-'.$adv_grid.'">';

						//$con_img = Configuration::get('uhu_modvalue_'.$this->mod_name.'_28');
						$labels = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_28'));
						$links = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_29'));
						$label_num = count($labels);
						for ($i = 0; $i < $label_num; $i++)
						{
							$label = $labels[$i];
							if (isset($links[$i]))
								$link = $links[$i];
							else
								$link = '';

							if (strstr($label, $catetitle.$cat_main))
							{
								$imgs = explode(',', str_replace($catetitle.$cat_main.':', '', $label));
								$imgurl = $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$this->mod_name.'/';
								$count_imgs = count($imgs);
								for ($j = 0; $j < $count_imgs; $j++)
								{
									$this->menu .= '<dd class="col-md-'.(int)(12 / $count_imgs).'">';

									if (strstr($link, $catetitle.$cat_main))
									{
										$lnk = explode(',', str_replace($catetitle.$cat_main.':', '', $link));
										if (isset($lnk[$j]))
											$this->menu .= '<a href="'.$lnk[$j].'">';
									}
									$this->menu .= '<img class="img-responsive" src="'.$imgurl.$imgs[$j].'" />';
									if (strstr($link, $catetitle.$cat_main))
									{
										$lnk = explode(',', str_replace($catetitle.$cat_main.':', '', $link));
										if (isset($lnk[$j]))
											$this->menu .= '</a>';
									}
									$this->menu .= '</dd>';
								}
								$this->menu .= PHP_EOL;
							}
						}
						//$this->getCategory((int)$id);
						$this->menu .= '</dl>';
					}

					$this->menu .= '<dl class="pop_content products_block col-md-'.$con_grid.'">';
					foreach ($menu_items as $item_man)
					{
						if (!$item_man || $item_man == 'CAT')
							continue;

						preg_match($this->pattern, $item_man, $value);
						$id = (int)Tools::substr($item_man, Tools::strlen($value[1]), Tools::strlen($item_man));

						if (Tools::substr($item_man, 0, Tools::strlen($value[1])) == $catetitle.$cat_main)
							$this->getSingleCategory((int)$id);
					}
					$this->menu .= '</dl>';
					$this->menu .= '</div>';
					$this->menu .= '</li>'.PHP_EOL;
					$cat_main = chr(ord($cat_main) + 1);
					break;
			}
		}
	}

	private function getCategory($id_category, $id_lang = false, $id_shop = false)
	{
		$id_shop = $id_shop;
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
		$category = new Category((int)$id_category, (int)$id_lang);

		if ($category->level_depth > 1)
			$category_link = $category->getLink();
		else
			$category_link = $this->context->link->getPageLink('index');

		if (is_null($category->id))
			return;

		$children = Category::getChildren((int)$id_category, (int)$id_lang, true, (int)$id_shop);

		$is_intersected = array_intersect($category->getGroups(), $this->user_groups);
		// filter the categories that the user is allowed to see and browse
		if (!empty($is_intersected))
		{
			if (count($children))
			{
				$grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_13');

				foreach ($children as $child)
				{
					//$this->getCategory((int)$child['id_category'], (int)$id_lang, (int)$child['id_shop']);
					$category_child = new Category((int)$child['id_category'], (int)$id_lang);

					if ($category_child->level_depth > 1)
						$category_link = $category_child->getLink();
					else
						$category_link = $this->context->link->getPageLink('index');

					if (is_null($category_child->id))
						return;

					$children_two = Category::getChildren((int)$child['id_category'], (int)$id_lang, true, (int)$id_shop);

					$is_intersected = array_intersect($category_child->getGroups(), $this->user_groups);
					// filter the categories that the user is allowed to see and browse
					if (!empty($is_intersected))
					{
						$this->menu .= '<dd class="col-md-'.$grid.'">';
						$this->menu .= '<span><a href="'.$category_link.'">'.$category_child->name.'</a></span>';

						if (count($children_two))
						{
							foreach ($children_two as $childtwo)
							{
								$category_childtwo = new Category((int)$childtwo['id_category'], (int)$id_lang);

								if ($category_childtwo->level_depth > 1)
									$category_linktwo = $category_childtwo->getLink();
								else
									$category_linktwo = $this->context->link->getPageLink('index');

								if (is_null($category_childtwo->id))
									return;

								$is_intersected = array_intersect($category_childtwo->getGroups(), $this->user_groups);
								// filter the categories that the user is allowed to see and browse
								if (!empty($is_intersected))
								{
									$this->menu .= '<p>';
									$this->menu .= '<a href="'.$category_linktwo.'">'.$category_childtwo->name.'</a>';
									$this->menu .= '</p>';
								}
							}
						}

						$this->menu .= '</dd>';
					}
				}
			}
		}
	}

	private function getSingleCategory($id_category, $id_lang = false, $id_shop = false)
	{
		$id_shop = $id_shop;
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
		$category = new Category((int)$id_category, (int)$id_lang);

		if ($category->level_depth > 1)
			$category_link = $category->getLink();
		else
			$category_link = $this->context->link->getPageLink('index');

		if (is_null($category->id))
			return;

		$grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_11');

		$is_intersected = array_intersect($category->getGroups(), $this->user_groups);
		// filter the categories that the user is allowed to see and browse
		if (!empty($is_intersected))
		{
			$this->menu .= '<dd class="col-md-'.$grid.'">';
			$this->menu .= '<a href="'.htmlentities($category_link).'" class="product_image">
				<img class="img-responsive" src="'._THEME_CAT_DIR_.$id_category.'.jpg" /></a>';
			$this->menu .= '<h5 class="s_title_block"><a href="'.htmlentities($category_link).'">'.$category->name.'</a></h5>';
			$this->menu .= '<div class="product_desc">'.strip_tags($category->description).'</div>';
			$this->menu .= '</dd>';
		}
	}

	private function makeCategoryMenuItems($enable)
	{
		$id_lang = (int)$this->context->language->id;
		//$id_shop = (int)Shop::getContextShopID();
		$menu_items = explode(',', Configuration::get('uhu_modvalue_'.$this->mod_name.'_26'));

		if (count($menu_items) > 0)
		{
			foreach ($menu_items as $item)
			{
				$con_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_0');
				$adv_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_1');

				$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
				$category = new Category((int)$item, (int)$id_lang);

				if ($category->level_depth > 1)
					$category_link = $category->getLink();
				else
					$category_link = $this->context->link->getPageLink('index');

				if (is_null($category->id))
					continue;

				$is_intersected = array_intersect($category->getGroups(), $this->user_groups);
				if (!empty($is_intersected))
				{
					$this->menu .= '<li class="nav_li cat">';
					$this->menu .= '<a class="nav_a roll" href="'.Tools::HtmlEntitiesUTF8($category_link).'" title=""><span data-title="'.$category->name.'">'.$category->name.'</span></a>';

					if ($enable == 'yes')
					{
						$this->menu .= '<div class="nav_pop col-md-12">';
						$this->menu .= '<dl class="pop_adver col-md-'.$adv_grid.'">';
						$this->getCategory((int)$item);
						$this->menu .= '</dl>';

						$this->menu .= '<dl class="pop_content products_block col-md-'.$con_grid.'">';

						$files = scandir(_PS_CAT_IMG_DIR_);
						if (count($files) > 0)
						{
							foreach ($files as $file)
								if (preg_match('/'.$category->id.'-([0-9])?_thumb.jpg/i', $file) === 1)
									$this->menu .= '<dd class="col-md-6"><img src="'.$this->context->link->getMediaLink(_THEME_CAT_DIR_.$file)
									.'" alt="'.Tools::SafeOutput($category->name).'" title="'
									.Tools::SafeOutput($category->name).'" class="img-responsive" /></dd>';
						}

						$this->menu .= '</dl>';
						$this->menu .= '</div>';
					}

					$this->menu .= '</li>'.PHP_EOL;
				}
			}
		}
	}

	private function makeCategoryMenu()
	{
		if ((Configuration::get('uhu_modvalue_'.$this->mod_name.'_41') == 'no' || Configuration::get('uhu_modvalue_'.$this->mod_name.'_41') == '') && Configuration::get('uhu_modvalue_'.$this->mod_name.'_8') == '')
			$this->menu .= PHP_EOL;
		else
		{
			$this->menu .= '<li class="nav_li cat">';
			$this->menu .= '<a class="nav_a roll" href="javascript:void(0)"><span data-title="Categories">Categories</span></a>';
			$this->menu .= '<div class="nav_pop col-md-12">';

			if (Configuration::get('uhu_modvalue_'.$this->mod_name.'_41') <> 'no')
			{
				$adv_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_1');
				$this->menu .= '<dl class="pop_adver col-md-'.$adv_grid.'">';
				$this->getCategory((int)Configuration::get('PS_HOME_CATEGORY'));
				$this->menu .= '</dl>';
			}

			if (Configuration::get('uhu_modvalue_'.$this->mod_name.'_8') <> '')
			{
				$menu_items = explode(',', Configuration::get('uhu_modvalue_'.$this->mod_name.'_8'));
				$con_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_0');
				$this->menu .= '<dl class="pop_content products_block col-md-'.$con_grid.'">';
				foreach ($menu_items as $item_man)
					$this->getSingleCategory((int)$item_man);
				$this->menu .= '</dl>';
			}

			$this->menu .= '</div>';
			$this->menu .= '</li>'.PHP_EOL;
		}
	}

	private function makeProductMenu()
	{
		if (Configuration::get('uhu_modvalue_'.$this->mod_name.'_6') <> '' || Configuration::get('uhu_modvalue_'.$this->mod_name.'_14') <> '')
		{
			$this->menu .= '<li class="nav_li prd">';
			$this->menu .= '<a class="nav_a roll" href="javascript:void(0)"><span data-title="Products">Products</span></a>';
			$this->menu .= '<div class="nav_pop col-md-12">';

			if (Configuration::get('uhu_modvalue_'.$this->mod_name.'_6') <> '')
			{
				$id_lang = (int)$this->context->language->id;
				$i = 0;
				$con_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_2');
				$pitem = Configuration::get('uhu_modvalue_'.$this->mod_name.'_16');
				$grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_17');

				$this->menu .= '<dl class="pop_content products_block col-md-'.$con_grid.'">';

				$menu_items = explode(',', Configuration::get('uhu_modvalue_'.$this->mod_name.'_6'));
				foreach ($menu_items as $item_prd)
				{
					$product = new Product((int)$item_prd, true, (int)$id_lang);
					if (!is_null($product->id))
					{
						$selected = ($i % $pitem == 0) ? 'first_item' : '';
						$i++;
						$this->menu .= '<dd class="col-md-'.$grid.' '.$selected.'">';
						$image = Image::getImages($id_lang, $product->id);
						$product->id_image = $image[0]['id_image'];
						$typea = 'large';
						$typeb = 'default';
						$type = $typea.'_'.$typeb;
						$imgurl = str_replace('http://', Tools::getShopProtocol(), Context::getContext()->link->getImageLink($product->link_rewrite, $product->id_image, $type));
						$this->menu .= '<a href="'.$product->getLink().'" class="product_image">';
						$this->menu .= '<img class="img-responsive" src="'.$imgurl.'" /></a>';
						$this->menu .= '<h5 class="s_title_block"><a href="'.$product->getLink().'">'.$product->name.'</a></h5>';
						$this->menu .= '<div class="product_desc">'.strip_tags($product->description_short).'</div>';
						$this->menu .= '</dd>'.PHP_EOL;
					}
				}
				$this->menu .= '</dl>';
			}

			if (Configuration::get('uhu_modvalue_'.$this->mod_name.'_14') <> '')
			{
				$adv_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_3');
				$this->menu .= '<dl class="pop_adver col-md-'.$adv_grid.'">';

				//$this->displayFront('prd');

				$imgs = explode(',', Configuration::get('uhu_modvalue_'.$this->mod_name.'_14'));
				$imgurl = $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$this->mod_name.'/';
				$count_imgs = count($imgs);
				for ($j = 0; $j < $count_imgs; $j++)
				{
					$this->menu .= '<dd class="col-md-'.(int)(12 / $count_imgs).'">';

					$lnk = explode(',', Configuration::get('uhu_modvalue_'.$this->mod_name.'_15'));
					if (isset($lnk[$j]))
						$this->menu .= '<a href="'.$lnk[$j].'">';
					$this->menu .= '<img class="img-responsive" src="'.$imgurl.$imgs[$j].'" />';
					if (isset($lnk[$j]))
						$this->menu .= '</a>';

					$this->menu .= '</dd>';
				}

				$this->menu .= '</dl>';
			}

			$this->menu .= '</div>';
			$this->menu .= '</li>'.PHP_EOL;
		}
	}

	private function makeBrandMenu()
	{
		if ((Configuration::get('uhu_modvalue_'.$this->mod_name.'_42') == 'no' || Configuration::get('uhu_modvalue_'.$this->mod_name.'_42') == '') && Configuration::get('uhu_modvalue_'.$this->mod_name.'_7') == '')
			$this->menu .= PHP_EOL;
		else
		{
			$this->menu .= '<li class="nav_li man">';
			$this->menu .= '<a class="nav_a roll" href="javascript:void(0)"><span data-title="Brands">Brands</span></a>';
			$this->menu .= '<div class="nav_pop col-md-12">';

			if (Configuration::get('uhu_modvalue_'.$this->mod_name.'_7') <> '')
			{
				$con_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_4');
				$pitem = Configuration::get('uhu_modvalue_'.$this->mod_name.'_18');
				$grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_19');

				$this->menu .= '<dl class="pop_content products_block col-md-'.$con_grid.'">';

				$i = 0;
				$id_lang = (int)$this->context->language->id;
				$menu_items = explode(',', Configuration::get('uhu_modvalue_'.$this->mod_name.'_7'));

				foreach ($menu_items as $item_man)
				{
					$manufacturer = new Manufacturer((int)$item_man, (int)$id_lang);
					if (!is_null($manufacturer->id))
					{
						if ((int)(Configuration::get('PS_REWRITING_SETTINGS')))
							$manufacturer->link_rewrite = Tools::link_rewrite($manufacturer->name, false);
						else
							$manufacturer->link_rewrite = 0;
						$link = new Link;

						$selected = ($i % $pitem == 0) ? 'first_item' : '';
						$i++;
						$this->menu .= '<dd class="col-md-'.$grid.' '.$selected.'">';
						$this->menu .= '<p><a href="'.$link->getManufacturerLink((int)$item_man, $manufacturer->link_rewrite).'" class="product_image">
											<img class="img-responsive" src="'._THEME_MANU_DIR_.$manufacturer->id_manufacturer.'.jpg" /></a></p>';
						$this->menu .= '<h5 class="s_title_block"><a href="'.$link->getManufacturerLink((int)$item_man, $manufacturer->link_rewrite).'">'.
											$manufacturer->name.'</a></h5>';
						$this->menu .= '<div class="product_desc">'.$manufacturer->short_description.'</div>';
						$this->menu .= '</dd>'.PHP_EOL;
					}
				}

				$this->menu .= '</dl>';
			}

			if (Configuration::get('uhu_modvalue_'.$this->mod_name.'_42') <> 'no')
			{
				$adv_grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_5');
				$pitem = Configuration::get('uhu_modvalue_'.$this->mod_name.'_20');
				$grid = Configuration::get('uhu_modvalue_'.$this->mod_name.'_21');

				$this->menu .= '<dl class="pop_adver col-md-'.$adv_grid.'">';

				$i = 0;
				$manufacturers = Manufacturer::getManufacturers();
				foreach ($manufacturers as $manufacturer)
				{
					$selected = ($i % $pitem == 0) ? 'first_item' : '';
					$i++;
					$this->menu .= '<dd class="col-md-'.$grid.' '.$selected.'"><a href="'.
									htmlentities($link->getManufacturerLink((int)$manufacturer['id_manufacturer'], $manufacturer['link_rewrite'])).
									'">'.$manufacturer['name'].'</a></dd>';
				}

				$this->menu .= '</dl>';
			}

			$this->menu .= '</div>';
			$this->menu .= '</li>'.PHP_EOL;
		}
	}

	private function makeCMSMenuItems()
	{
		$id_lang = (int)$this->context->language->id;
		$menu_items = explode(',', Configuration::get('uhu_modvalue_'.$this->mod_name.'_9'));

		if (count($menu_items) > 0)
		{
			foreach ($menu_items as $item)
			{
				$cms = CMS::getLinks((int)$id_lang, array($item));
				if (count($cms))
					$this->menu .= '<li><a href="'.htmlentities($cms[0]['link']).'" class="roll"><span data-title="'.$cms[0]['meta_title'].'">'.$cms[0]['meta_title'].'</span></a></li>'.PHP_EOL;
			}
		}
	}

	private function makeCustomMenuItems()
	{
		//$id_lang = (int)$this->context->language->id;
		$menu_items = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_23'));

		if (count($menu_items) > 0)
		{
			//$labels = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_23'));
			$links = explode('|', Configuration::get('uhu_modvalue_'.$this->mod_name.'_24'));
			$lid = 0;
			foreach ($menu_items as $item)
				$this->menu .= '<li><a href="'.htmlentities($links[$lid++]).'" class=" roll"><span data-title="'.$item.'">'.$item.'</span></a></li>'.PHP_EOL;
		}
	}

	public function hookDisplayTop($params)
	{
		//$currency = $params['cookie']->id_currency;
		$this->user_groups = ($this->context->customer->isLogged() ?
			$this->context->customer->getGroups() : array(Configuration::get('PS_UNIDENTIFIED_GROUP')));

		$enable = Configuration::get('uhu_modvalue_'.$this->mod_name.'_22'); //test roll

		if ($enable == 'yes')
			$this->makeCategoryMenu();

		$this->makeCategoryMenuItems($enable);

		if ($enable == 'yes')
		{
			$this->makeMenu();
			$this->makeProductMenu();
			$this->makeBrandMenu();
		}
		$this->makeCMSMenuItems();
		$this->makeCustomMenuItems();

		$this->smarty->assign('MENU', $this->menu);

		$showhome = Configuration::get('uhu_modvalue_'.$this->mod_name.'_27');
		$this->smarty->assign('showhome', $showhome);

		$this->getCategoryMobile((int)Configuration::get('PS_HOME_CATEGORY'));
		$this->smarty->assign('MENU_MOBILE', $this->menumobile );

		return $this->display(__FILE__, $this->name.'.tpl');
	}

	public function hookHeader()
	{
		//$this->context->controller->addJS(_THEME_JS_DIR_.'tools/treeManagement.js');
	}

	public function displayFront($type)
	{
		$num = 0;
		//$grid = 12;
		$adv = array();
		$lnk = array();
		if ($type == 'prd')
		{
			$num = 1;
			$adv[0] = Configuration::get('uhu_modvalue_'.$this->mod_name.'_14');
			$lnk[0] = Configuration::get('uhu_modvalue_'.$this->mod_name.'_15');
		}

		//if ($type == 'cms')
		//	$grid = 12;
		//if ($type == 'lnk')
		//	$grid = 4;

		$imgurl = $this->context->link->protocol_content.Tools::getMediaServer($this->name)._MODULE_DIR_.'uhu_setting/images/'.$this->mod_name.'/';

		for ($i = 0; $i < $num; $i++)
		{
			$this->menu .= '<dd>';
			if ($lnk[$i])
				$this->menu .= '<a href="'.$lnk[$i].'">';
			$this->menu .= '<img class="img-responsive" src="'.$imgurl.$adv[$i].'" />';
			if ($lnk[$i])
				$this->menu .= '</a>';
			$this->menu .= '</dd>';
		}
	}

	private function getCategoryMobile($id_category, $id_lang = false, $id_shop = false)
	{
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
		$category = new Category((int)$id_category, (int)$id_lang);

		if ($category->level_depth > 1)
			$category_link = $category->getLink();
		else
			$category_link = $this->context->link->getPageLink('index');

		if (is_null($category->id))
			return;

		$children = Category::getChildren((int)$id_category, (int)$id_lang, true, (int)$id_shop);
		$selected = ($this->page_name == 'category' && ((int)Tools::getValue('id_category') == $id_category)) ? ' class="sfHoverForce"' : '';

		$is_intersected = array_intersect($category->getGroups(), $this->user_groups);
		// filter the categories that the user is allowed to see and browse
		if (!empty($is_intersected))
		{
			if ((int)$id_category == 2)
			{
				$this->menumobile .= '<li id="main" '.$selected.'>';
				$this->menumobile .= '<a href="javascript:void(0)">Categories</a>';
			}
			else
			{
				$this->menumobile .= '<li '.$selected.'>';
				$this->menumobile .= '<a href="'.$category_link.'">'.$category->name.'</a>';
			}

			if (count($children))
			{
				$this->menumobile .= '<ul>';

				foreach ($children as $child)
					$this->getCategoryMobile((int)$child['id_category'], (int)$id_lang, (int)$child['id_shop']);

				$this->menumobile .= '</ul>';
			}
			$this->menumobile .= '</li>';
		}
	}

	private function getCategoryRoll($id_category, $roll, $id_lang = false, $id_shop = false)
	{
		$id_shop = $id_shop;
		$id_lang = $id_lang ? (int)$id_lang : (int)Context::getContext()->language->id;
		$category = new Category((int)$id_category, (int)$id_lang);

		if ($category->level_depth > 1)
			$category_link = $category->getLink();
		else
			$category_link = $this->context->link->getPageLink('index');

		if (is_null($category->id))
			return;

		$this->menuroll .= '<li>';
		$this->menuroll .= '<a href="'.$category_link.'" class=" '.$roll.'"><span data-title="'.$category->name.'">'.$category->name.'</span></a>';
		$this->menuroll .= '</li>';
	}

}
