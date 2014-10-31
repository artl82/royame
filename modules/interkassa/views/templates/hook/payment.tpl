{*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 7134 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="row">
    <div class="col-xs-12 col-md-6">
        <p class="payment_module">
            <a class="interkassa" href="{$link->getModuleLink('interkassa', 'request', [], true)}"
               title="{l s='Pay by interkassa' mod='interkassa'}">
                {l s='Pay by interkassa' mod='interkassa'}
            </a>
        </p>
    </div>
</div>
<br>

{*<p class="payment_module">
	<a class="button" href="{$link->getModuleLink('cheque', 'payment', [], true)|escape:'html'}" title="{l s='Pay by check' mod='cheque'}">
		<img src="{$this_path_cheque}cheque.jpg" alt="{l s='Pay by check' mod='cheque'}" width="86" height="49" />
		{l s='Pay by check' mod='cheque'} {l s='(order processing will be longer)' mod='cheque'}
	</a>
</p>*}
