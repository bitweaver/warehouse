		<hr />
		<div class="form-group">
			{formlabel label="Release Number" for="release_no"}
			{forminput}
				{$clientInfo.release_no|escape} - {$clientInfo.release_date|bit_short_date}
			{/forminput}
		</div>
		<div class="form-group">
			{formlabel label="Release" for="releaseno"}
			{forminput}
			<table>
				<caption>{tr}Details of release{/tr}</caption>
				<thead>
					<tr>
						<th>Line No</th>
						<th>Product Id</th>
						<th>Batch</th>
						<th>Quantity</th>
						<th>Open</th>
						<th>Hold</th>
						<th>Pallet No</th>
					</tr>
				</thead>
				<tbody>
					{section name=releaseno loop=$clientInfo.releaseno}
						<tr class="{cycle values="even,odd"}" title="{$clientInfo.releaseno[releaseno].partno|escape}">
							<td>
								{$clientInfo.releaseno[releaseno].lineno|escape}
							</td>
							<td>
								<a title="{tr}product details{/tr}" href="{$clientInfo.releaseno[releaseno].product_url}">{$clientInfo.releaseno[releaseno].partno}</a>
							</td>
							<td>
								<a title="{tr}batch details{/tr}" href="{$clientInfo.releaseno[releaseno].batch_url}">{$clientInfo.releaseno[releaseno].batch|escape}</a>
							</td>
							<td>
								{$clientInfo.releaseno[releaseno].qty|escape}
							</td>
							<td>
								{$clientInfo.releaseno[releaseno].ropen|escape}
							</td>
							<td>
								{$clientInfo.releaseno[releaseno].hold|escape}
							</td>
							<td>
								{$clientInfo.releaseno[releaseno].palletno|escape}
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
