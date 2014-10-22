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

if (!defined('_PS_VERSION_'))
	exit;

class uhu_ft_fblike extends Module
{
	public function __construct()
	{
		$this->name = 'uhu_ft_fblike';
		$this->tab = 'others';
		$this->version = '4.16.5';
		$this->author = 'uhuPage';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = 'uhu Facebook fan';
		$this->description = $this->l('Display a Facebook fan page on your site.');
	}

	public function install()
	{
		return (parent::install() && $this->registerHook('footer'));
	}

	public function hookFooter($params)
	{
		$this->prepareHook();

		$mod_id = 25;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);
		$enable = Configuration::get('uhu_modvalue_'.$mod_name.'_9');

		/*
		// uhupage
		if (Configuration::get('uhu_css_2012_front_panel'))
		{
			if (isset($_COOKIE['facebook']))
			{
				if ($_COOKIE['facebook'] == 'show')
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

	private function prepareHook()
	{
		$error_message = '';
		$fans_filename = _PS_MODULE_DIR_.$this->name.'/fbfans.txt';

		$mod_id = 25;
		$mod_name = Configuration::get('uhu_mod_id_'.$mod_id);

		$totalgrid = Configuration::get('uhu_modvalue_'.$mod_name.'_0');
		$fans_number = Configuration::get('uhu_modvalue_'.$mod_name.'_1');
		$fb_username = Configuration::get('uhu_modvalue_'.$mod_name.'_2');
		//$title = Configuration::get('uhu_modvalue_'.$mod_name.'_3');
		$perline = Configuration::get('uhu_modvalue_'.$mod_name.'_4');
		$sandbox = Configuration::get('uhu_modvalue_'.$mod_name.'_5');

		if ($sandbox == 'true')
		{
			Configuration::updateValue('uhu_modvalue_'.$mod_name.'_6', 'Prestashop');
			Configuration::updateValue('uhu_modvalue_'.$mod_name.'_7', '24889');
			Configuration::updateValue('uhu_modvalue_'.$mod_name.'_8', '114089955274622');
			$fb_data_name = Configuration::get('uhu_modvalue_'.$mod_name.'_6');
			$fb_data_likes = Configuration::get('uhu_modvalue_'.$mod_name.'_7');
			$fb_data_id = Configuration::get('uhu_modvalue_'.$mod_name.'_8');

			$mylogo = '';
			//'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc6/276652_114089955274622_8030346_q.jpg';
		}
		// uhupage
		/*
		else
		{
			$file_contents = Tools::file_get_contents('https://graph.facebook.com/'.$fb_username);

			// change stripos to strripos
			$pos = strripos($file_contents, '"id":');
			$temp = Tools::substr($file_contents, $pos + 6);
			$pos = stripos($temp, '",');
			$fb_data_id = Tools::substr($temp, 0, $pos);
			Configuration::updateValue('uhu_modvalue_'.$mod_name.'_8', $fb_data_id);

			$pos = strripos($file_contents, '"likes":');
			$temp = Tools::substr($file_contents, $pos + 8);
			$pos = stripos($temp, ',');
			$fb_data_likes = Tools::substr($temp, 0, $pos);
			Configuration::updateValue('uhu_modvalue_'.$mod_name.'_7', $fb_data_likes);

			$pos = strripos($file_contents, '"name":');
			$temp = Tools::substr($file_contents, $pos + 8);
			$pos = stripos($temp, '"');
			$fb_data_name = Tools::substr($temp, 0, $pos);
			Configuration::updateValue('uhu_modvalue_'.$mod_name.'_6', $fb_data_name);

			// Fackbook limit
			$seconds = 3600;
			$avatar = Tools::file_get_contents('https://graph.facebook.com/'.$fb_data_id.'/picture');
			if (function_exists('base64_encode'))
				$mylogo = 'data:image/jpg;base64,'.base64_encode($avatar);
			else
				$mylogo = $avatar;

			if (!file_exists($fans_filename) || (filemtime($fans_filename) + $seconds < time()))
			{
				if (function_exists('curl_exec'))
				{
					$ch = curl_init('https://www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/'.$fb_username);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0.1');
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					$result = curl_exec($ch);
					curl_close($ch);

					$fname = _PS_MODULE_DIR_.$this->name.'/fbch.txt';
					$fp = fopen($fname, 'wb');
					fputs($fp, $result);
					fclose($fp);

					$pos = stripos($result, '<ul class="');
					$temp = substr($result, $pos);
					$pos = stripos($temp, '</div>');
					$value = substr($temp, 0, $pos);

					$fname = _PS_MODULE_DIR_.$this->name.'/fbvalue.txt';
					$fp = fopen($fname, 'wb');
					fputs($fp, $value);
					fclose($fp);

					$fname = _PS_MODULE_DIR_.$this->name.'/fbavatar.txt';
					$ffp = fopen($fname, 'wb');
					$fp = fopen($fans_filename, 'wb');
					if ($fp)
					{
						$doc = new DOMDocument('1.0', 'utf-8');
						$doc->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'.$value);
						foreach ($doc->getElementsByTagName('ul')->item(0)->childNodes as $child)
						{
							$temp = preg_replace('/<li[^>]+\>/i', '', $doc->saveXML($child));
							$temp = preg_replace('/<\/li>/i', '', $temp);
							$name = $this->getTagAttribute('title', $temp)."\n";
							$link = $this->getTagAttribute('href', $temp)."\n";
							$imagesrc = $this->getTagAttribute('src', $temp);
							$imagesrc = str_replace("&amp;", "&", $imagesrc);

							fputs($ffp, $imagesrc."\n");

							fputs($fp, $name);
							fputs($fp, $link);
							if (function_exists('base64_encode'))
							{
								if (base64_encode(Tools::file_get_contents($imagesrc)) == '')
									$imagesrc = str_replace("https://fbcdn-profile-a.akamaihd.net/hprofile-ak", "https://scontent-2.2914.fna.fbcdn.net/hprofile", $imagesrc);
								$image = 'data:image/jpg;base64,'.base64_encode(Tools::file_get_contents($imagesrc))."\n";
							}
							else
								$image = $imagesrc."\n";
							fputs($fp, $image);
						}
						fclose($fp);
					}
					else
						$error_message = "Error: Can't write file ".$fans_filename.'<br/>';
					fclose($ffp);
				}
				else
					$error_message = 'Error: cURL library is not installed<br/>';
			}
		}
		*/

		$fans_name = array();
		$fans_link = array();
		$fans_image = array();
		$fp = fopen($fans_filename, 'rb');
		if ($fp)
		{
			while (! feof($fp))
			{
				$fans_name[] = fgets($fp);
				$fans_link[] = fgets($fp);
				$fans_image[] = fgets($fp);
			}
			fclose($fp);

			$i = count($fans_name) - 1;
			if ($i < $fans_number)
				$fans_number = $i;
		}
		else
			$error_message = "Error: Can't read file ".$fans_filename.'<br/>';

		$this->smarty->assign(array(
			'totalgrid' => $totalgrid,
			'fans_number' => $fans_number,
			'perline' => $perline,
			'myName' => $fb_data_name,
			'myLikes' =>$fb_data_likes,
			'myLogo' => $mylogo,
			'myPage' => 'https://www.facebook.com/'.$fb_username,
			'error_message' => $error_message
		));

		for ($i = 0; $i < $fans_number; $i++)
		{
			$this->smarty->assign(array(
				'fans_name_'.$i => $fans_name[$i],
				'fans_link_'.$i => $fans_link[$i],
				'fans_image_'.$i => $fans_image[$i]
			));
		}

	}

	public function getTagAttribute($attrib, $tag)
	{
		$pattern = '/'.$attrib.'=["\']?([^"\' ]*)["\' ]/is';
		preg_match($pattern, $tag, $match);

		if ($match)
			return urldecode($match[1]);
		else
			return false;
	}

}

