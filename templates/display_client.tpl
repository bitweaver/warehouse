<div class="body">
	<div class="content">

		{if isset($clientInfo.organisation) && ($clientInfo.organisation <> '') }
		<div class="row">
			{formlabel label="Organisation" for="organisation"}
			{forminput}
				{$clientInfo.organisation|escape} 
			{/forminput}
		</div>
		{/if}
		{if isset($clientInfo.dob) && ($clientInfo.dob <> '') }
		<div class="row">
			{formlabel label="Date of Birth" for="dob"}
			{forminput}
				{$clientInfo.dob|bit_long_date}
			{/forminput}
		</div>
		{/if}
		{if isset($clientInfo.nino) && ($clientInfo.nino <> '') }
		<div class="row">
			{formlabel label="National Insurance Number" for="nino"}
			{forminput}
				{$clientInfo.nino|escape}
			{/forminput}
		</div>
		{/if}
		{* include file="bitpackage:warehouse/display_address.tpl" *}
		{jstabs}
			{include file="bitpackage:warehouse/tab_list_stock.tpl"}
			{include file="bitpackage:warehouse/tab_list_products.tpl"}
			{* include file="bitpackage:warehouse/list_appoint.tpl" *}
		{/jstabs}
	</div><!-- end .content -->
</div><!-- end .body -->
