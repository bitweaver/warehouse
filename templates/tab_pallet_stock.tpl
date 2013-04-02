		{assign var=stkrefcnt value=$palletInfo.stock|@count}
		{jstab title="Stock ($stkrefcnt)"}
		{legend legend="Stock"}
		<div class="control-group">
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
					{section name=stock loop=$palletInfo.stock}
						<tr class="{cycle values="even,odd"}" title="{$palletInfo.stock[stock].palletno|escape}">
							<td>
								<a title="{tr}pallet details{/tr}" href="{$palletInfo.stock[stock].pallet_url}">{$palletInfo.stock[stock].pallet}{if $palletInfo.stock[stock].subp ne ''}.{$palletInfo.stock[stock].subp}{/if}</a>
							</td>
							<td>
								<a title="{tr}product details{/tr}" href="{$palletInfo.stock[stock].product_url}">{$palletInfo.stock[stock].partno|escape}</a>
							</td>
							<td>
								<a title="{tr}batch details{/tr}" href="{$palletInfo.stock[stock].batch_url}">{$palletInfo.stock[stock].batch|escape}</a>
							</td>
							<td>
								{$palletInfo.stock[stock].qty|escape}
							</td>
							<td>
								{$palletInfo.stock[stock].sopen|escape}
							</td>
							<td>
								{$palletInfo.stock[stock].hold|escape}
							</td>
							<td>
								{$palletInfo.stock[stock].palletno|escape}
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
