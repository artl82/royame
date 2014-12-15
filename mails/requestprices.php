<?php

require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once(dirname(__FILE__).'/../init.php');

if (Tools::getValue('action') == 'sendPricesRequest')
{
    $email = Tools::getValue('email');
    if (empty($email))
        die('0');

    $templateVars = array(
        '{customer}' => Context::getContext()->customer->email,
        '{cart}' => Context::getContext()->cart->id
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
        die('0');
    }
    die('1');
}
die('0');
