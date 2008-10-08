<div class="body">
	<div class="content">

		{if isset($palletInfo.contact) && ($palletInfo.contact <> '') }
		<div class="row">
			{formlabel label="Weight" for="weight"}
			{forminput}
				{$productInfo.weight|escape}
			{/forminput}
		</div>
		{/if}
		{jstabs}
			{include file="bitpackage:warehouse/tab_product_stock.tpl"}
			{include file="bitpackage:warehouse/tab_movepallet.tpl"}
			{include file="bitpackage:warehouse/tab_product_batches.tpl"}
		{/jstabs}
	</div><!-- end .content -->
</div><!-- end .body -->
