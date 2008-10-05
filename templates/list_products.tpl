{strip}
<div class="listing warehouse">
	<div class="header">
		<h1>{tr}Product List{/tr}</h1>
	</div>

	<div class="body">
		{minifind}

		<div class="navbar">
			<ul class="sortby">
				<li>{biticon ipackage="icons" iname="emblem-symbolic-link" iexplain="sort by" iforce="icon"}</li>
				{if $gBitSystem->isFeatureActive('warehouse_list_warehouse')}
					<li>{smartlink ititle="Product ID" isort="partno" offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_pallet_cnt')}
					<li>{smartlink ititle="Description" isort="descript" offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_name')}
					<li>{smartlink ititle="Client" isort="client" offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_location')}
					<li>{smartlink ititle="Quantity" isort="quantity" offset=$iMaxRows}</li>
				{/if}
			</ul>
		</div>

		<ul class="clear data">
			{foreach from=$productList key=productId item=product}
				<li class="item {cycle values='odd,even'} {$product.partno}">
					<h2><a href="{$product.display_url}">{$product.partno|escape}</a></h2>

					{$product.descript}&nbsp;&nbsp;-&nbsp;{tr}Quantity{/tr}: {$product.quantity}&nbsp;&nbsp;
						{tr}Unit{/tr}: {$product.unit}&nbsp;&nbsp;
						{tr}Weight{/tr}: {$product.weight}&nbsp;&nbsp;
						{tr}Per Pallet{/tr}: {$product.perpal}&nbsp;&nbsp;
						{tr}Package{/tr}: {$product.package}&nbsp;&nbsp;

					<div class="clear"></div>
				</li>
			{foreachelse}
				<li class="item norecords">
					{tr}No records found{/tr}
				</li>
			{/foreach}
		</ul>

		<div class="clear"></div>
		{pagination}
	</div>	<!-- end .body -->
</div>	<!-- end .warehouse -->
{/strip}
