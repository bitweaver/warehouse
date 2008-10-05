{strip}
<div class="listing warehouse">
	<div class="header">
		<h1>{tr}Pallet Location List{/tr}</h1>
	</div>

	<div class="body">
		{minifind}

		<div class="navbar">
			<ul class="sortby">
				<li>{biticon ipackage="icons" iname="emblem-symbolic-link" iexplain="sort by" iforce="icon"}</li>
				{if $gBitSystem->isFeatureActive('warehouse_list_warehouse')}
					<li>{smartlink ititle="Pallet ID" isort="pallet" offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_pallet_cnt')}
					<li>{smartlink ititle="Product Count" isort="product" offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_name')}
					<li>{smartlink ititle="Height" isort="height" offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_location')}
					<li>{smartlink ititle="Size" isort="size1" offset=$iMaxRows}</li>
				{/if}
			</ul>
		</div>

		<ul class="clear data">
			{foreach from=$palletList key=warehouseId item=pallet}
				<li class="item {cycle values='odd,even'} {$pallet.pallet}">
					<h2><a href="{$pallet.display_url}">{$pallet.pallet|escape}</a></h2>

					{if $pallet.client ne 'JB ' }
						{$pallet.client}&nbsp;&nbsp;-&nbsp;{tr}Product Count{/tr}: {$pallet.product}&nbsp;&nbsp;
					{else}
						Location Empty&nbsp;&nbsp;
					{/if}
						{tr}Height{/tr}: {$pallet.size1}&nbsp;&nbsp;
						{tr}Size{/tr}: {$pallet.size1}&nbsp;&nbsp;

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
