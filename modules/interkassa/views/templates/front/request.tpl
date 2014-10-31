<html><head></head><body>
<form type=hidden name='payment' action="https://sci.interkassa.com/" method="post">
    <input type="hidden" name="ik_co_id" value="{$shopId}">
    <input type="hidden" name="ik_am" value="{$ik_payment_amount}">
    <input type="hidden" name="ik_pm_no" value="{$ik_payment_id}">
    <input type="hidden" name="ik_paysystem_alias" value="{$ik_paysystem_alias}">
    <input type="hidden" name="ik_baggage_fields" value="{$ik_baggage_fields}">

    <input type="hidden" name="ik_suc_u" value="{$link->getModuleLink('interkassa', 'success', [], true)}">
    <input type="hidden" name="ik_suc_m" value="POST">
    <input type="hidden" name="ik_fal_u" value="{$link->getPageLink('order', true, NULL, $paymentError)}">
    <input type="hidden" name="ik_fal_m" value="POST">
    <input type="hidden" name="ik_ia_u" value="{$link->getModuleLink('interkassa', 'status', [], true)}">
    <input type="hidden" name="ik_ia_m" value='POST'>
    <input type="hidden" name="ik_desc" value="Desc">

    {*<input type="hidden" name="secret_key" value="{$key}">*}
    <input type="hidden" name="process" value="Оплатить">
</form>
    <SCRIPT FOR=window EVENT=onload LANGUAGE='JavaScript'>
        document.payment.submit();
    </SCRIPT>
</body></html>