		{assign var=moveprefcnt value=$productInfo.move|@count}
		{jstab title="Pallet Movements ($moveprefcnt)"}
		{legend legend="Pallet Movements"}
		<div class="row">
			{formlabel label="Pallet Movements" for="move"}
			{forminput}
			<table>
				<caption>{tr}List of product movements to and from pallet locations{/tr}</caption>
				<thead>
					<tr>
						<th>Date</th>
						<th>Product</th>
						<th>Batch</th>
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
					{section name=move loop=$productInfo.move}
						<tr class="{cycle values="even,odd"}" title="{$productInfo.move[move].palletno|escape}">
							<td>
								{$productInfo.move[move].rdate|bit_short_date}
							</td>
							<td>
								<a title="{tr}product details{/tr}" href="{$productInfo.move[move].product_url}">{$productInfo.move[move].partno|escape}</a> - {$productInfo.move[move].descript|escape}
							</td>
							<td>
								{$productInfo.move[move].batch|escape}
							</td>
							<td>
								{$productInfo.move[move].qty|escape}
							</td>
							<td>
								{$productInfo.move[move].fromp|escape}.{$productInfo.move[move].fromsubp|escape}
							</td>
							<td>
								{$productInfo.move[move].top|escape}.{$productInfo.move[move].tosubp|escape}
							</td>
							<td>
								{$productInfo.move[move].cof|escape}
							</td>
							<td>
								{$productInfo.move[move].palletno|escape}
							</td>
							<td>
								{$productInfo.move[move].release_no|escape}
							</td>
							<td>
								{$productInfo.move[move].audit|escape}
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
