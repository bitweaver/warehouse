		{assign var=toprefcnt value=$palletInfo.top|@count}
		{jstab title="To Pallet ($toprefcnt)"}
		{legend legend="To Pallet"}
		<div class="control-group">
			{formlabel label="To Pallet" for="top"}
			{forminput}
			<table>
				<caption>{tr}List of movements to pallet location{/tr}</caption>
				<thead>
					<tr>
						<th>Date</th>
						<th>Product</th>
						<th>Batch</th>
						<th>Quantity</th>
						<th>From</th>
						<th>By</th>
						<th>Pallet Number</th>
						<th>Release</th>
						<th>Audit</th>
					</tr>
				</thead>
				<tbody>
					{section name=top loop=$palletInfo.top}
						<tr class="{cycle values="even,odd"}" title="{$palletInfo.top[top].palletno|escape}">
							<td>
								{$palletInfo.top[top].rdate|bit_short_date}
							</td>
							<td>
								<a title="{tr}product details{/tr}" href="{$palletInfo.top[top].product_url}">{$palletInfo.top[top].partno|escape}</a> - {$palletInfo.top[top].descript|escape}
							</td>
							<td>
								<a title="{tr}batch details{/tr}" href="{$palletInfo.top[top].batch_url}">{$palletInfo.top[top].batch|escape}</a>
							</td>
							<td>
								{$palletInfo.top[top].qty|escape}{if $palletInfo.top[top].tosubp ne ''}.{$palletInfo.top[top].tosubp}{/if}
							</td>
							<td>
								{$palletInfo.top[top].fromp|escape}.{$palletInfo.top[top].fromsubp|escape}
							</td>
							<td>
								{$palletInfo.top[top].cof|escape}
							</td>
							<td>
								{$palletInfo.top[top].palletno|escape}
							</td>
							<td>
								{$palletInfo.top[top].release_no|escape}
							</td>
							<td>
								{$palletInfo.top[top].audit|escape}
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
