		{assign var=stkrefcnt value=$productInfo.stock|@count}
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
						<th>Batch</th>
						<th>Quantity</th>
						<th>Open</th>
						<th>Hold</th>
						<th>Pallet Number</th>
					</tr>
				</thead>
				<tbody>
					{section name=stock loop=$productInfo.stock}
						<tr class="{cycle values="even,odd"}" title="{$productInfo.stock[stock].palletno|escape}">
							<td>
								<a title="{tr}pallet details{/tr}" href="{$productInfo.stock[stock].pallet_url}">{$productInfo.stock[stock].pallet}{if $productInfo.stock[stock].subp ne ''}.{$productInfo.stock[stock].subp}{/if}</a>
							</td>
							<td>
								<a title="{tr}batch details{/tr}" href="{$productInfo.stock[stock].batch_url}">{$productInfo.stock[stock].batch|escape}</a>
							</td>
							<td>
								{$productInfo.stock[stock].qty|escape}
							</td>
							<td>
								{$productInfo.stock[stock].sopen|escape}
							</td>
							<td>
								{$productInfo.stock[stock].hold|escape}
							</td>
							<td>
								{$productInfo.stock[stock].palletno|escape}
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
