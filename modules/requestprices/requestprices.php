<?php

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

////artem
//$file = fopen('logg.txt', 'a');
//fwrite($file, "requestprices.php 1\n");
//fclose($file);
////artem
if (Tools::getValue('action') == 'sendPricesRequest')
{
    $email = Tools::getValue('email');
    if (empty($email))
        die('0');

    /* Email generation */
    //$productLink = $module->context->link->getProductLink($product);
    //$customer = $module->context->cookie->customer_firstname ? $module->context->cookie->customer_firstname . ' ' . $module->context->cookie->customer_lastname : $module->l('A friend', 'sendtoafriend_ajax');

    $templateVars = array(
        '{product}' => 'testProduct',
        '{product_link}' => 'testLink',
        '{customer}' => 'testCustomer',
        '{name}' => 'testName'
    );

    /* Email sending */
    if (!Mail::Send(1,
        'sendPricesRequest',
        'тема',
        $templateVars, $email,
        null,
        null,
        null,
        null,
        null,
        dirname(__FILE__) . '/mails/')
    )
    {
        //artem
        $file = fopen('logg.txt', 'a');
        fwrite($file, "requestprices.php 2\n");
        fclose($file);
        //artem
        die('0');
    }
    //artem
    $file = fopen('logg.txt', 'a');
    fwrite($file, "requestprices.php 3\n");
    fclose($file);
    //artem
    die('1');
}
//artem
$file = fopen('logg.txt', 'a');
fwrite($file, "requestprices.php 4\n");
fclose($file);
//artem
die('2');
