{strip}
<a class="dropdown-toggle" data-toggle="dropdown" href="#"> {tr}{$packageMenuTitle}{/tr} <b class="caret"></b></a>
<ul class="dropdown-menu">
	<li><a class="item" href="{$smarty.const.WAREHOUSE_PKG_URL}index.php">{booticon iname="icon-calendar" iexplain="Warehouse Management" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.WAREHOUSE_PKG_URL}list_pallets.php">{booticon iname="icon-calendar" iexplain="Pallet Location List" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.WAREHOUSE_PKG_URL}list_products.php">{booticon iname="icon-calendar" iexplain="Product Description List" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.WAREHOUSE_PKG_URL}list_warehouses.php">{booticon iname="icon-calendar" iexplain="Warehouse List" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.WAREHOUSE_PKG_URL}list_clients.php">{booticon iname="icon-calendar" iexplain="Client List" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.WAREHOUSE_PKG_URL}display_client.php?client_id=KAR">{booticon iname="icon-calendar" iexplain="Client Record" ilocation=menu}</a></li>
</ul>
{/strip}
