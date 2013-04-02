		<hr />
		<div class="control-group">
			{formlabel label="Batch Number" for="Batch_no"}
			{forminput}
				{$productInfo.batch_no|escape} - {$productInfo.batch_date|bit_short_date}
			{/forminput}
		</div>
		<div class="control-group">
			{formlabel label="Pallet Movements for Batch" for="batchmove"}
			{forminput}
			<table>
				<caption>{tr}List of product movements to and from pallet locations{/tr}</caption>
				<thead>
					<tr>
						<th>Date</th>
						<th>Quantity</th>
						<th>From</th>
						<th>To</th>
						<th>By</th>
						<th>Pallet Number</th>
						<th>Release</th>
						<th>Audit</th>
					</tr>
				</thead>
				<tbody>
					{section name=batchmove loop=$productInfo.batchmove}
						<tr class="{cycle values="even,odd"}" title="{$productInfo.batchmove[batchmove].palletno|escape}">
							<td>
								{$productInfo.batchmove[batchmove].rdate|bit_short_date}
							</td>
							<td>
								{$productInfo.batchmove[batchmove].qty|escape}
							</td>
							<td>
								{$productInfo.batchmove[batchmove].fromp|escape}{if $productInfo.batchmove[batchmove].fromsubp ne ''}.{$productInfo.batchmove[batchmove].fromsubp}{/if}
							</td>
							<td>
								{$productInfo.batchmove[batchmove].top|escape}{if $productInfo.batchmove[batchmove].topubp ne ''}.{$productInfo.batchmove[batchmove].tosubp}{/if}
							</td>
							<td>
								{$productInfo.batchmove[batchmove].cof|escape}
							</td>
							<td>
								{$productInfo.batchmove[batchmove].palletno|escape}
							</td>
							<td>
								<a title="{tr}release details{/tr}" href="{$productInfo.batchmove[batchmove].release_url}">{$productInfo.batchmove[batchmove].release_no|escape}</a>
							</td>
							<td>
								{$productInfo.batchmove[batchmove].audit|escape}
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
