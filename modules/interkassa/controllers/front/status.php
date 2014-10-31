<?php

class InterkassaStatusModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     * @see FrontController::initContent()
     */
    public function init()
    {
        $this->display_column_left = false;
        parent::init();

        $ik_shop_id = trim(Tools::getValue('ik_co_id'));
        $ik_payment_amount = trim(Tools::getValue('ik_am'));
        $ik_payment_id = trim(Tools::getValue('ik_pm_no'));
        $ik_payment_state = trim(Tools::getValue('ik_inv_st')); // new - новый; waitAccept - ожидает оплаты; process - обрабатывается; success - успешно проведен; canceled - отменен; fail - не проведен
        //$ik_trans_id = trim(Tools::getValue('ik_trn_id '));
        //$ik_currency_exch = trim(Tools::getValue('ik_currency_exch'));
        //$ik_fees_payer = trim(Tools::getValue('ik_fees_payer'));
        $ik_sign = trim(Tools::getValue('ik_sign'));

        //artem
        $file = fopen('logg.txt', 'a');
        fwrite($file, "status.php 1 ik_shop_id=$ik_shop_id ik_payment_id=$ik_payment_id ik_payment_amount=$ik_payment_amount ik_payment_state=$ik_payment_state\r\n");
        fclose($file);
        //artem

        if ($ik_shop_id != _INTERKASSA_SHOP_ID_) {
            //artem
            $file = fopen('logg.txt', 'a');
            fwrite($file, "status.php  DIE ik_shop_id != _INTERKASSA_SHOP_ID_\r\n");
            fclose($file);
            //artem
            header("HTTP/1.0 205 Reset Content");
            die();
        }

        if ($ik_payment_state != 'process' || $ik_payment_state != 'success') {
            //artem
            $file = fopen('logg.txt', 'a');
            fwrite($file, "status.php  DIE ik_payment_state \r\n");
            fclose($file);
            //artem
            header("HTTP/1.0 205 Reset Content");
            die();
        }

        //проверка цифровой подписи
        unset($_POST['ik_sign']); // удаляем из данных строку подписи
        ksort($dataSet, SORT_STRING); // сортируем по ключам в алфавитном порядке элементы массива
        array_push($_POST, _INTERKASSA_SC_); // добавляем в конец массива "секретный ключ"
        $signString = implode(':', $_POST); // конкатенируем значения через символ ":"
        $sign = base64_encode(md5($signString, true)); // берем MD5 хэш в бинарном виде по сформированной строке и кодируем в BASE64
        if ($sign != $ik_sign) {
            //artem
            $file = fopen('logg.txt', 'a');
            fwrite($file, "status.php  DIE sign \r\n");
            fclose($file);
            //artem
            header("HTTP/1.0 205 Reset Content");
            die();
        }

        $cart = new Cart($ik_payment_id);
        //artem
        $file = fopen('logg.txt', 'a');
        fwrite($file, "status.php ik_shop_id=$ik_shop_id ik_payment_id=$ik_payment_id ik_payment_amount=$ik_payment_amount\r\n");
        fclose($file);
        //artem
        if (!Validate::isLoadedObject($cart)) {
            //artem
            $file = fopen('logg.txt', 'a');
            fwrite($file, "status.php DIE cart\r\n");
            fclose($file);
            //artem

            header("HTTP/1.0 205 Reset Content");
            die();
        }

        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);

        $ik_payment_amount = (float)$ik_payment_amount;

        //artem
        $file = fopen('logg.txt', 'a');
        fwrite($file, "status.php ik_payment_amount=$ik_payment_amount total=$total\r\n");
        fclose($file);
        //artem

        if ($total != $ik_payment_amount) {
            //artem
            $file = fopen('logg.txt', 'a');
            fwrite($file, "status.php DIE total != payment_amount\r\n");
            fclose($file);
            //artem

            header("HTTP/1.0 205 Reset Content");
            die();
        }


        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            //artem
            $file = fopen('logg.txt', 'a');
            fwrite($file, "status.php DIE customer\r\n");
            fclose($file);
            //artem
            header("HTTP/1.0 205 Reset Content");
            die();
        }


        $currency = new Currency($cart->id_currency);
        if (!Validate::isLoadedObject($currency)) {
            //artem
            $file = fopen('logg.txt', 'a');
            fwrite($file, "status.php DIE currency\r\n");
            fclose($file);
            //artem
            header("HTTP/1.0 205 Reset Content");
            die();
        }

        $mailVars = array();
        //artem
        $file = fopen('logg.txt', 'a');
        $c = (int)$cart->id;
        fwrite($file, "status.php validateOrder before$c\r\n");
        fclose($file);
        //artem
        $this->module->validateOrder((int)$cart->id, Configuration::get('PS_OS_PAYMENT'), $total, $this->module->displayName, NULL, $mailVars, (int)$currency->id, false, $customer->secure_key);
        //artem
        $file = fopen('logg.txt', 'a');
        $c = (int)$cart->id;
        fwrite($file, "status.php validateOrder after$c\r\n");
        fclose($file);
        //artem
    }
}