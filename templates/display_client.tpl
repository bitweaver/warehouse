<div class="body">
	<div class="content">

		{if isset($clientInfo.name) && ($clientInfo.name <> '') }
		<div class="row">
			{formlabel label="Name" for="name"}
			{forminput}
				{$clientInfo.name|escape} 
			{/forminput}
		</div>
		{/if}
		{if isset($clientInfo.address1) && ($clientInfo.address1 <> '') }
		<div class="row">
			{formlabel label="Address" for="address"}
			{forminput}
				{$clientInfo.address1|escape},{$clientInfo.address2|escape},{$clientInfo.posttown|escape},{$clientInfo.county|escape},{$clientInfo.postcode|escape}
			{/forminput}
		</div>
		{/if}
		{if isset($clientInfo.contact) && ($clientInfo.contact <> '') }
		<div class="row">
			{formlabel label="Contact" for="contact"}
			{forminput}
				{$clientInfo.contact|escape}
			{/forminput}
		</div>
		{/if}
	</div><!-- end .content -->
</div><!-- end .body -->
