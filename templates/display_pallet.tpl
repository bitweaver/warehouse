<div class="body">
	<div class="content">

		{if isset($palletInfo.name) && ($palletInfo.name <> '') }
		<div class="form-group">
			{formlabel label="Name" for="name"}
			{forminput}
				{$palletInfo.name|escape} 
			{/forminput}
		</div>
		{/if}
		{if isset($palletInfo.address1) && ($palletInfo.address1 <> '') }
		<div class="form-group">
			{formlabel label="Address" for="address"}
			{forminput}
				{$palletInfo.address1|escape},{$palletInfo.address2|escape},{$palletInfo.posttown|escape},{$palletInfo.county|escape},{$palletInfo.postcode|escape}
			{/forminput}
		</div>
		{/if}
		{if isset($palletInfo.contact) && ($palletInfo.contact <> '') }
		<div class="form-group">
			{formlabel label="Contact" for="contact"}
			{forminput}
				{$palletInfo.contact|escape}
			{/forminput}
		</div>
		{/if}
		{* include file="bitpackage:warehouse/display_address.tpl" *}
		{jstabs}
			{include file="bitpackage:warehouse/tab_pallet_stock.tpl"}
			{include file="bitpackage:warehouse/tab_topallet.tpl"}
			{include file="bitpackage:warehouse/tab_frompallet.tpl"}
		{/jstabs}
	</div><!-- end .content -->
</div><!-- end .body -->
