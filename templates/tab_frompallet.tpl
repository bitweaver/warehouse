		{assign var=fromprefcnt value=$palletInfo.fromp|@count}
		{jstab title="From Pallet ($fromprefcnt)"}
		{legend legend="From Pallet"}
		<div class="row">
			{formlabel label="From Pallet" for="fromp"}
			{forminput}
			<table>
				<caption>{tr}List of movements from pallet location{/tr}</caption>
				<thead>
					<tr>
						<th>Date</th>
						<th>Product</th>
						<th>Batch</th>
						<th>Quantity</th>
						<th>To</th>
						<th>By</th>
						<th>Pallet Number</th>
						<th>Release</th>
						<th>Audit</th>
					</tr>
				</thead>
				<tbody>
					{section name=fromp loop=$palletInfo.fromp}
						<tr class="{cycle values="even,odd"}" title="{$palletInfo.fromp[fromp].palletno|escape}">
							<td>
								{$palletInfo.fromp[fromp].rdate|bit_short_date}
							</td>
							<td>
								<a title="{tr}product details{/tr}" href="{$palletInfo.fromp[fromp].product_url}">{$palletInfo.fromp[fromp].partno|escape}</a> - {$palletInfo.fromp[fromp].descript|escape}
							</td>
							<td>
								<a title="{tr}batch details{/tr}" href="{$palletInfo.fromp[fromp].batch_url}">{$palletInfo.fromp[fromp].batch|escape}</a>
							</td>
							<td>
								{$palletInfo.fromp[fromp].qty|escape}
							</td>
							<td>
								{$palletInfo.fromp[fromp].fromp|escape}{if $productInfo.fromp[fromp].fromsubp ne ''}.{$productInfo.fromp[fromp].fromsubp}{/if}
							</td>
							<td>
								{$palletInfo.fromp[fromp].cof|escape}
							</td>
							<td>
								{$palletInfo.fromp[fromp].palletno|escape}
							</td>
							<td>
								{$palletInfo.fromp[fromp].release_no|escape}
							</td>
							<td>
								{$palletInfo.fromp[fromp].audit|escape}
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
