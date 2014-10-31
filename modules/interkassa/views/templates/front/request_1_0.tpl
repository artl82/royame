<html><head></head><body>
<form type=hidden name='request' action="http://www.interkassa.com/lib/payment.php" method="post">
    <input type="hidden" name="ik_shop_id" value="{$shopId}">
    <input type="hidden" name="ik_payment_amount" value="{$ik_payment_amount}">
    <input type="hidden" name="ik_payment_id" value="{$ik_payment_id}">
    <input type="hidden" name="ik_payment_desc" value="poker shop">
    <input type="hidden" name="ik_paysystem_alias" value="{$ik_paysystem_alias}">
    <input type="hidden" name="ik_baggage_fields" value="{$ik_baggage_fields}">

    <input type="hidden" name="ik_success_url" value="{$link->getModuleLink('interkassa', 'success', [], true)}">
    <input type="hidden" name="ik_success_method" value="POST">
    <input type="hidden" name="ik_fail_url" value="{$link->getPageLink('order', true, NULL, $paymentError)}">
    <input type="hidden" name="ik_fail_method" value="POST">
    <input type="hidden" name="ik_status_url" value='{$link->getModuleLink('interkassa', 'status', [], true)}'>
    <input type="hidden" name="ik_status_method" value='POST'>
    <input type="hidden" name="ik_sign_hash" value="{$ik_sign_hash}">

    {*<input type="hidden" name="secret_key" value="{$key}">*}
    <input type="hidden" name="process" value="Оплатить">
</form>
    <SCRIPT FOR=window EVENT=onload LANGUAGE='JavaScript'>
        document.request.submit();
    </SCRIPT>
</body></html>