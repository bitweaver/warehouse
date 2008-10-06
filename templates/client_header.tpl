<div class="header">
	<h1>{$clientInfo.content_id}&nbsp;-&nbsp;
		{if isset($clientInfo.organisation) && ($clientInfo.organisation <> '') }
		{$clientInfo.organisation}
		{else}
		{$clientInfo.prefix}&nbsp;
		{$clientInfo.forename}&nbsp;
		{$clientInfo.surname}
		{/if}</h1>
	<div class="description">{$clientInfo.description}</div>
</div> {* end .header *}
