<?php
/*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Cart extends CartCore
{
    public function haveEmptyProductPrices()
    {
        foreach($this->_products as $product)
        {
            if ($product['price'] == 0)
                return true;
        }
        return false;
    }

    public static function getProductsEnding($count)
    {
//        $count = $count % 100;
//        if ($count >= 11 && $count <= 19) {
//            $ending = 'товаров';
//        } else {
//            $i = $count % 10;
//            switch ($i) {
//                case (1):
//                    $ending = 'товар';
//                    break;
//                case (2):
//                case (3):
//                case (4):
//                    $ending = 'товара';
//                    break;
//                default:
//                    $ending = 'товаров';
//            }
//        }
//        return $ending;
        $word1 = 'товар';
        $word2 = 'товара';
        $word3 = 'товаров';
        $col_max = abs($count) % 100; //переборка букв алфавита
        $col_min = $col_max % 10; // установка определенных значений
        // для 10% окончаний
        if ($col_max > 10 && $col_max < 20) return $word3;
        // если максимальное кол-во больше 10 и не превышает 20, то записывать
        // с окончанием товар"ов"
        if ($col_min > 1 && $col_min < 5) return $word2;
        // если минимальное кол-во больше 1 или меньше 5, то записывать
        // с окончанием товар"а"
        if ($col_min == 1) return $word1;
        // если минимальное кол-во равно 1, то записывать как товар
        return $word3;
        // повторить параметр 4, если все остальные значения не подошли
    }
}