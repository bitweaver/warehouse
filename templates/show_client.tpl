<div class="display warehouse">
{include file="bitpackage:warehouse/client_header.tpl"}
{include file="bitpackage:warehouse/client_date_bar.tpl"}
	<div class="body">
		<div class="content">
			{include file="bitpackage:warehouse/display_client.tpl"}
			{jstabs}
				{include file="bitpackage:warehouse/tab_list_stock.tpl"}
				{include file="bitpackage:warehouse/tab_list_products.tpl"}
				{include file="bitpackage:warehouse/tab_list_batches.tpl"}
				{include file="bitpackage:warehouse/tab_list_releases.tpl"}
			{/jstabs}
		</div><!-- end .content -->
	</div><!-- end .body -->
</div> {* end .warehouse *}
