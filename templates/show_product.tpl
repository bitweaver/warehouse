<div class="display warehouse">
{include file="bitpackage:warehouse/product_header.tpl"}
{include file="bitpackage:warehouse/client_date_bar.tpl"}
	<div class="body">
		<div class="content">
			{include file="bitpackage:warehouse/display_product.tpl"}
			{jstabs}
				{include file="bitpackage:warehouse/tab_product_stock.tpl"}
				{include file="bitpackage:warehouse/tab_movepallet.tpl"}
				{include file="bitpackage:warehouse/tab_product_batches.tpl"}
			{/jstabs}
		</div><!-- end .content -->
	</div><!-- end .body -->
</div> {* end .warehouse *}
