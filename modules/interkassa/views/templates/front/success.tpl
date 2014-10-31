{if !isset($reference)}
    {l s='Pay by interkassa is success! Check your order.' mod='interkassa'}
{else}
    {l s='Pay by interkassa is success! Check your order %s.' sprintf=$reference mod='interkassa'}
{/if}

{if isset($products)}
<br /><br />{l s='Bought products:' mod='interkassa'}<br/>
    {foreach from=$products item=product}
        - {$product.name} x {$product.quantity} <br/>
    {/foreach}
{/if}

