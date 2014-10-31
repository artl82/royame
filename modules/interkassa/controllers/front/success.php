<?php

class InterkassaSuccessModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        $this->display_column_left = false;
        parent::initContent();

        $ik_payment_id = trim(Tools::getValue('ik_payment_id'));
        $ik_payment_state = trim(Tools::getValue('ik_payment_state'));

        $cart = new Cart($ik_payment_id);
        $products = $cart->getProducts();
        $id_order = (int)Order::getOrderByCartId($ik_payment_id);
        $order = new Order($id_order);
        $this->context->smarty->assign(
            array('reference' => $order->reference,
                'products' => $products
        ));

        $this->setTemplate('success.tpl');
    }
}
