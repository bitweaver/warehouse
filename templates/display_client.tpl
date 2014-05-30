		{if isset($clientInfo.name) && ($clientInfo.name <> '') }
		<div class="form-group">
			{formlabel label="Name" for="name"}
			{forminput}
				{$clientInfo.name|escape} 
			{/forminput}
		</div>
		{/if}
		{if isset($clientInfo.address1) && ($clientInfo.address1 <> '') }
		<div class="form-group">
			{formlabel label="Address" for="address"}
			{forminput}
				{$clientInfo.address1|escape},{$clientInfo.address2|escape},{$clientInfo.posttown|escape},{$clientInfo.county|escape},{$clientInfo.postcode|escape}
			{/forminput}
		</div>
		{/if}
		{if isset($clientInfo.contact) && ($clientInfo.contact <> '') }
		<div class="form-group">
			{formlabel label="Contact" for="contact"}
			{forminput}
				{$clientInfo.contact|escape}
			{/forminput}
		</div>
		{/if}
