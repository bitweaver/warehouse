		{assign var=stkrefcnt value=$clientInfo.stock|@count}
		{jstab title="Stock ($stkrefcnt)"}
		{legend legend="Stock"}
		<div class="row">
			{formlabel label="Stock" for="stock"}
			{forminput}
			<table>
				<caption>{tr}List of current stock{/tr}</caption>
				<thead>
					<tr>
						<th>Location</th>
						<th>Product</th>
						<th>Batch</th>
						<th>Quantity</th>
						<th>Open</th>
						<th>Hold</th>
						<th>Pallet Number</th>
					</tr>
				</thead>
				<tbody>
					{section name=stock loop=$clientInfo.stock}
						<tr class="{cycle values="even,odd"}" title="{$clientInfo.stock[stock].palletno|escape}">
							<td>
								<a title="{tr}pallet details{/tr}" href="{$clientInfo.stock[stock].pallet_url}">{$clientInfo.stock[stock].pallet}{if $clientInfo.stock[stock].subp ne ''}.{$clientInfo.stock[stock].subp}{/if}</a>
							</td>
							<td>
								<a title="{tr}product details{/tr}" href="{$clientInfo.stock[stock].product_url}">{$clientInfo.stock[stock].partno|escape}</a>
							</td>
							<td>
								<a title="{tr}batch details{/tr}" href="{$clientInfo.stock[stock].batch_url}">{$clientInfo.stock[stock].batch|escape}</a>
							</td>
							<td>
								{$clientInfo.stock[stock].qty|escape}
							</td>
							<td>
								{$clientInfo.stock[stock].sopen|escape}
							</td>
							<td>
								{$clientInfo.stock[stock].hold|escape}
							</td>
							<td>
								{$clientInfo.stock[stock].palletno|escape}
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
