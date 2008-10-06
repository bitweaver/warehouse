		{assign var=prorefcnt value=$clientInfo.product|@count}
		{jstab title="Products ($prorefcnt)"}
		{legend legend="Products"}
		<div class="row">
			{formlabel label="Products" for="product"}
			{forminput}
			<table>
				<caption>{tr}List of client products{/tr}</caption>
				<thead>
					<tr>
						<th>Product Id</th>
						<th>Description</th>
						<th>Quantity</th>
						<th>Unit</th>
					</tr>
				</thead>
				<tbody>
					{section name=product loop=$clientInfo.product}
						<tr class="{cycle values="even,odd"}" title="{$clientInfo.product[product].partno|escape}">
							<td>
								<a title="{tr}product details{/tr}" href="{$clientInfo.product[product].product_url}">{$clientInfo.product[product].partno}</a>
							</td>
							<td>
								{$clientInfo.product[product].description|escape}
							</td>
							<td>
								{$clientInfo.product[product].quantity|escape}
							</td>
							<td>
								{$clientInfo.product[product].unit|escape}
							</td>
						</tr>
					{sectionelse}
						<tr class="norecords">
							<td colspan="3">
								{tr}No records found{/tr}
							</td>
						</tr>
					{/section}
				</tbody>
			</table>
			{/forminput}
		</div>
		{/legend}
		{/jstab}
