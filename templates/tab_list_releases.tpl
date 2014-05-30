		{assign var=relrefcnt value=$clientInfo.release|@count}
		{jstab title="Release ($relrefcnt)"}
		{legend legend="Release"}
		<div class="form-group">
			{formlabel label="Release" for="release"}
			{forminput}
			<table>
				<caption>{tr}List of releases{/tr}</caption>
				<thead>
					<tr>
						<th>Release Number</th>
						<th>Date</th>
						<th>Number of lines</th>
					</tr>
				</thead>
				<tbody>
					{section name=release loop=$clientInfo.release}
						<tr class="{cycle values="even,odd"}" title="{$clientInfo.release[release].release_no|escape}">
							<td>
								<a title="{tr}release details{/tr}" href="{$clientInfo.release[release].release_url}">{$clientInfo.release[release].release_no}</a>
							</td>
							<td>
								{$clientInfo.release[release].rdate|bit_short_date}
							</td>
							<td>
								{$clientInfo.release[release].lines|escape}
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
