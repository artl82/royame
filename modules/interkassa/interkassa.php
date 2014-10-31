<?php
//interkassa

if (!defined('_PS_VERSION_'))
    exit;

class InterKassa extends PaymentModule
{

    public function __construct()
    {
        $this->name = 'interkassa';
        $this->tab = 'payments_gateways';
        $this->version = '0.1';
        $this->author = 'Artem Lomakin';


        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        parent::__construct();

        $this->displayName = $this->l('INTERKASSA payment');
        $this->description = $this->l('Payment by INTERKASSA');
        $this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');

        if (!count(Currency::checkPaymentCurrencies($this->id)))
            $this->warning = $this->l('No currency set for this module');
    }

    public function install()
    {
        if (!parent::install() || !$this->registerHook('payment'))
            return false;
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall())
            return false;
        return true;
    }

    private function _postValidation()
    {
        if (Tools::isSubmit('btnSubmit'))
        {
        }
    }

    private function _postProcess()
    {
        if (Tools::isSubmit('btnSubmit'))
        {

        }
        $this->_html .= '<div class="conf confirm"> '.$this->l('Settings updated').'</div>';
    }

    private function _displayLogo()
    {
        $this->_html .= '<img src="../modules/interkassa/interkassa.jpg" style="float:left; margin-right:15px;"><b>'.$this->l('This module allows you to accept payments by INTERKASSA.').'</b><br /><br />';
    }

    private function _displayForm()
    {
        $this->_html .=
            '<form action="'.Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset>
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Contact details').'</legend>
				<h1>INTERKASSA _displayForm</h1>
			</fieldset>
		</form>';
    }

    public function getContent()
    {
        $this->_html = '<h2>'.$this->displayName.'</h2>';

        if (Tools::isSubmit('btnSubmit'))
        {
            $this->_postValidation();
            if (!count($this->_postErrors))
                $this->_postProcess();
            else
                foreach ($this->_postErrors as $err)
                    $this->_html .= '<div class="alert error">'.$err.'</div>';
        }
        else
            $this->_html .= '<br />';

        $this->_displayLogo();
        $this->_displayForm();

        return $this->_html;
    }

    public function hookPayment($params)
    {
        if (!$this->active)
            return;
        if (!$this->checkCurrency($params['cart']))
            return;

        $this->smarty->assign(array(
            'this_path' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/'
        ));

        return $this->display(__FILE__, 'payment.tpl');
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency((int)($cart->id_currency));
        $currencies_module = $this->getCurrency((int)$cart->id_currency);

        if (is_array($currencies_module))
            foreach ($currencies_module as $currency_module)
                if ($currency_order->id == $currency_module['id_currency'])
                    return true;
        return false;
    }
}