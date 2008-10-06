<div class="floaticon">
  {if $print_page ne 'y'}
    {if !$lock}
      {if $gBitUser->hasPermission('p_warehouse_edit')}
		<a href="edit.php?content_id={$clientInfo.content_id}" {if $beingEdited eq 'y'}{popup_init src="`$gBitLoc.THEMES_PKG_URL`overlib.js"}{popup text="$semUser" width="-1"}{/if}>{biticon ipackage="icons" iname="accessories-text-editor" iexplain="edit"}</a>
      {/if}
    {/if}
    <a title="{tr}print{/tr}" href="print.php?content_id={$clientInfo.content_id}">{biticon ipackage="icons" iname="document-print" iexplain="print"}</a>
      {if $gBitUser->hasPermission('p_warehouse_expunge')}
        <a title="{tr}remove this citizen{/tr}" href="remove_client.php?content_id={$clientInfo.content_id}">{biticon ipackage="icons" iname="edit-delete" iexplain="delete"}</a>
      {/if}
  {/if} {* end print_page *}
</div> {*end .floaticon *}
<div class="date">
	{tr}Created by{/tr} {displayname user=$clientInfo.creator_user user_id=$clientInfo.user_id real_name=$clientInfo.creator_real_name}, {tr}Last modification by{/tr} {displayname user=$clientInfo.modifier_user user_id=$clientInfo.modifier_user_id real_name=$clientInfo.modifier_real_name} on {$clientInfo.last_modified|bit_long_datetime}
</div>
