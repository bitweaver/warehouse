		{assign var=stkrefcnt value=$clientInfo.stock|@count}
		{jstab title="Cross reference ($stkrefcnt)"}
		{legend legend="Stock"}
		<div class="row">
			{formlabel label="Cross reference" for="stock"}
			{forminput}
			<table>
				<caption>{tr}List of linked references{/tr}</caption>
				<thead>
					<tr>
						<th>Data</th>
						<th>Application</th>
						<th>USN</th>
						<th>Reference</th>
					</tr>
				</thead>
				<tbody>
					{section name=stock loop=$clientInfo.stock}
						<tr class="{cycle values="even,odd"}" title="{$list[county].title|escape}">
							<td>
								{$clientInfo.stock[stock].last_update_date|bit_long_date}
							</td>
							<td>
								{$clientInfo.stock[stock].source|escape}
							</td>
							<td>
								{if isset($clientInfo.stock[stock].usn) && ($clientInfo.stock[stock].usn <> '') }
									{$clientInfo.stock[stock].usn|escape}
									{smartlink ititle="Link to" ifile="display_citizen.php" ibiticon="icons/accessories-text-editor" content_id=$clientInfo.stock[stock].usn}
								{/if}
							</td>
							<td>
								<span class="actionicon">
									{smartlink ititle="View" ifile="view_stock.php" ibiticon="icons/accessories-text-editor" source=$clientInfo.stock[stock].source stock=$clientInfo.stock[stock].cross_reference}
								</span>
								<label for="ev_{$clientInfo.stock[stock].cross_reference}">	
									{$clientInfo.stock[stock].cross_reference}
								</label>
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
