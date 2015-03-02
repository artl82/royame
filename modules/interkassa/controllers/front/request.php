<?php

class InterkassaRequestModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        //artem
        $file = fopen('logg.txt', 'a');
        fwrite($file, "request.php initContent\r\n");
        fclose($file);
        //artem
        $this->display_column_left = false;
        parent::initContent();
        $cart = $this->context->cart;
        if ($cart->id_customer == 0 || !$this->module->active)
        {
            $message = $this->module->l('Internal error has occurred, please contact with administrator.', 'interkassa');
            Tools::redirect('index.php?controller=order&step=3&paymentError='.$message);
        }

        $authorized = false;
        foreach (Module::getPaymentModules() as $module)
            if ($module['name'] == 'interkassa')
            {
                $authorized = true;
                break;
            }
        if (!$authorized)
        {
            $message = $this->module->l('Internal error has occurred, please contact with administrator.', 'interkassa');
            Tools::redirect('index.php?controller=order&step=3&paymentError='.$message);
        }

        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);

        $ik_payment_id=$cart->id;
        //$ik_paysystem_alias="";
        //$ik_baggage_fields="";
        $ik_sign_hash=md5(_INTERKASSA_SHOP_ID_.":".$total.":".$ik_payment_id.":"._INTERKASSA_SC_);

        //artem
        $file = fopen('logg.txt', 'a');
        fwrite($file, "request ik_payment_id=$ik_payment_id total=$total\r\n");
        fclose($file);
        //artem

        $statusUrl = Context::getContext()->link->getModuleLink('interkassa', 'status');

        //artem
        $file = fopen('logg.txt', 'a');
        fwrite($file, "request statusUrl=$statusUrl \r\n");
        fclose($file);
        //artem
        $this->context->smarty->assign(array(
            'ik_payment_amount' => $total,
            'ik_payment_id' => $ik_payment_id,
            //'key' => _INTERKASSA_SC_,
            'shopId' => _INTERKASSA_SHOP_ID_,
            'ik_sign_hash' => $ik_sign_hash,
            //'ik_paysystem_alias' => $ik_paysystem_alias,
            //'ik_baggage_fields' => $ik_baggage_fields,
            'paymentError' => array(
                'step' => '3',
                'paymentError' => $this->module->l('Возникла ошибка оплаты, пожалуйста сообщите нам!', 'interkassa')
            ),
            'statusUrl' => $statusUrl
        ));

        $this->setTemplate('request.tpl');
    }
}
