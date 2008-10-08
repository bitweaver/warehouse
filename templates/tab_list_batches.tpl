		{assign var=barefcnt value=$clientInfo.batch|@count}
		{jstab title="Product Batches ($barefcnt)"}
		{legend legend="Product Batches"}
		<div class="row">
			{formlabel label="Batches" for="batch"}
			{forminput}
			<table>
				<caption>{tr}List of client batches{/tr}</caption>
				<thead>
					<tr>
						<th>Product Id</th>
						<th>Batch</th>
						<th>Date</th>
						<th>Quantity In</th>
						<th>Balance</th>
						<th>Open</th>
						<th>Hold</th>
					</tr>
				</thead>
				<tbody>
					{section name=batch loop=$clientInfo.batch}
						<tr class="{cycle values="even,odd"}" title="{$clientInfo.batch[batch].partno|escape}">
							<td>
								<a title="{tr}product details{/tr}" href="{$clientInfo.batch[batch].product_url}">{$clientInfo.batch[batch].partno}</a>
							</td>
							<td>
								<a title="{tr}batch details{/tr}" href="{$clientInfo.batch[batch].batch_url}">{$clientInfo.batch[batch].batch|escape}</a>
							</td>
							<td>
								{$clientInfo.batch[batch].indate|bit_short_date}
							</td>
							<td>
								{$clientInfo.batch[batch].qtyin|escape}
							</td>
							<td>
								{$clientInfo.batch[batch].qty|escape}
							</td>
							<td>
								{$clientInfo.batch[batch].bopen|escape}
							</td>
							<td>
								{$clientInfo.batch[batch].hold|escape}
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
