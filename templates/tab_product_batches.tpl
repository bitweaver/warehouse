		{assign var=barefcnt value=$productInfo.batch|@count}
		{jstab title="Batches ($barefcnt)"}
		{legend legend="Batches"}
		<div class="form-group">
			{formlabel label="Batches" for="batch"}
			{forminput}
			<table>
				<caption>{tr}List of product batches{/tr}</caption>
				<thead>
					<tr>
						<th>Batch</th>
						<th>Date</th>
						<th>Quantity In</th>
						<th>Balance</th>
						<th>Open</th>
						<th>Hold</th>
					</tr>
				</thead>
				<tbody>
					{section name=batch loop=$productInfo.batch}
						<tr class="{cycle values="even,odd"}" title="{$productInfo.batch[batch].partno|escape}">
							<td>
								<a title="{tr}batch details{/tr}" href="{$palletInfo.batch[batch].batch_url}">{$productInfo.batch[batch].batch|escape}</a>
							</td>
							<td>
								{$productInfo.batch[batch].indate|bit_short_date}
							</td>
							<td>
								{$productInfo.batch[batch].qtyin|escape}
							</td>
							<td>
								{$productInfo.batch[batch].qty|escape}
							</td>
							<td>
								{$productInfo.batch[batch].bopen|escape}
							</td>
							<td>
								{$productInfo.batch[batch].hold|escape}
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
