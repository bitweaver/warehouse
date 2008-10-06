{strip}
<div class="listing warehouse">
	<div class="header">
		{if $gWarehouseId}
			<h1>{tr}Client list for warehouse{/tr}{if $gWarehouseId} $gWarehouseId{/if}</h1>
		{else}
			<h1>{tr}Client list{/tr}</h1>
		{/if}
	</div>

	<div class="body">

		<div class="navbar">
			<ul class="sortby">
				<li>{biticon ipackage="icons" iname="emblem-symbolic-link" iexplain="sort by" iforce="icon"}</li>
				{if $gBitSystem->isFeatureActive('warehouse_list_client')}
					<li>{smartlink ititle="Client Name" isort="client" user_id=$gQuerUserId offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_contact')}
					<li>{smartlink ititle="Contact" isort="contact" user_id=$gQuerUserId offset=$iMaxRows}</li>
				{/if}
				{if $gBitSystem->isFeatureActive('warehouse_list_palletcnt')}
					<li>{smartlink ititle="Full Pallets" isort="fullp" user_id=$gQuerUserId offset=$iMaxRows}</li>
					<li>{smartlink ititle="Part Pallets" isort="part" user_id=$gQuerUserId offset=$iMaxRows}</li>
				{/if}
			</ul>
		</div>

		<ul class="clear data">
			{foreach from=$clientList key=clientId item=client}
				<li class="item {cycle values='odd,even'} {$client.client}">
					<h2><a href="{$client.display_url}">{if $gBitSystem->isFeatureActive('warehouse_list_client')}{$client.name|escape}{else}Client ID {$client.client}{/if}</a></h2>

					{if $gBitSystem->isFeatureActive('warehouse_list_contact')}
						{$client.contact}&nbsp;&nbsp;
					{/if}
						
					{if $gBitSystem->isFeatureActive('warehouse_list_pallet_cnt' )}
							{tr}Stock{/tr}: {$client.stock}&nbsp;&nbsp;
							{tr}Full Pallets{/tr}: {$client.fullp}&nbsp;&nbsp;
							{tr}Partial Pallets{/tr}: {$client.part}
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
