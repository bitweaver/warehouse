{strip}
<div class="listing warehouse">
	<div class="header">
		<h1>{tr}Warehouse List{/tr}</h1>
	</div>

	<div class="body">

		<div class="navbar">
			<ul class="sortby">
				<li>{booticon iname="icon-circle-arrow-right"  ipackage="icons"  iexplain="sort by" iforce="icon"}</li>
				{if $gBitSystem->isFeatureActive('warehouse_list_warehouse')}
					<li>{smartlink ititle="Warehouse ID" isort="warehouse" user_id=$gQuerUserId offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_name')}
					<li>{smartlink ititle="Name" isort="name" user_id=$gQuerUserId offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_location')}
					<li>{smartlink ititle="Location" isort="location" user_id=$gQuerUserId offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_pallet_cnt')}
					<li>{smartlink ititle="Pallet Count" isort="pallet_cnt" user_id=$gQuerUserId offset=$iMaxRows}</li>
				{/if}
			</ul>
		</div>

		<ul class="clear data">
			{foreach from=$warehouseList key=warehouseId item=warehouse}
				<li class="item {cycle values='odd,even'} {$warehouse.warehouse}">
					<h2><a href="{$warehouse.display_url}">{$warehouse.warehouse|escape}</a></h2>

					{if $gBitSystem->isFeatureActive('warehouse_list_name')}
						{$warehouse.name}&nbsp;&nbsp;
					{/if}
						
					{if $gBitSystem->isFeatureActive('warehouse_list_location' )}
							{tr}Location{/tr}: {$warehouse.location}&nbsp;&nbsp;
					{/if}
					{if $gBitSystem->isFeatureActive('warehouse_list_palletcnt' )}
							{tr}Pallet Count{/tr}: {$warehouse.pallet_cnt}
					{/if}

					<div class="clear"></div>
				</li>
			{foreachelse}
				<li class="item norecords">
					{tr}No records found{/tr}
				</li>
			{/foreach}
		</ul>

		<div class="clear"></div>
	</div>	<!-- end .body -->
</div>	<!-- end .warehouse -->
{/strip}
