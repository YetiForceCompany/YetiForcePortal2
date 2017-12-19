{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="btn-group">
		{assign var="LABEL" value=$LINK['linklabel']}
		{assign var="ACTION_NAME" value=$LABEL}
		{if isset($LINK['linkurl'])}
			{assign var="LINK_URL" value=$LINK['linkurl']}
		{else}
			{assign var="LINK_URL" value=''}
		{/if}
		{assign var="BTN_MODULE" value=$MODULE_NAME}
	{if isset($LINK['linkhref'])}<a{else}<button type="button"{/if}{/strip} {strip}
					title="{\YF\Core\Functions::translate($LABEL, $BTN_MODULE)}"{/strip} {strip}
					{if isset($LINK['active']) && !$LINK['active']} disabled {/if}
					id="{$MODULE_NAME}_{$BUTTON_VIEW}_action_{str_replace(' ', '_', $ACTION_NAME)}"{/strip} {strip}
					class="btn {if $LINK['linkclass'] neq ''}{if $LINK['linkclass']|strrpos:"btn-" === false}btn-default {/if}{$LINK['linkclass']}{else}btn-default{/if} {if $LABEL neq '' && !isset($LINK['showLabel'])} popoverTooltip{/if} {if isset($LINK['modalView'])}showModal{/if}"{/strip} {strip}
					{if isset($LINK['linkdata']) && is_array($LINK['linkdata'])}
						{foreach from=$LINK['linkdata'] key=NAME item=DATA}
							data-{$NAME}="{$DATA}"
						{/foreach}
					{/if}
			{/strip} {strip}
				{if $LABEL neq '' && !isset($LINK['showLabel'])}
					data-placement="bottom"
					data-content="{\YF\Core\Functions::translate($LABEL, $BTN_MODULE)}"
				{/if}
			{/strip} {strip}
				{if isset($LINK['linkhref'])}
					href="{$LINK_URL}"
				{/if}
			{/strip} {strip}
				{if isset($LINK['linktarget'])}
					target="{$LINK['linktarget']}"
				{/if}
			{/strip} {strip}
				{if isset($LINK['modalView'])}
					data-url="{$LINK_URL}"
				{else}
					{if isset($LINK['linkPopup'])}
						onclick="window.open('{$LINK_URL}', '{if isset($LINK['linktarget'])}{$LINK['linktarget']}{else}_self{/if}'{if isset($LINK['linkPopup'])}, 'resizable=yes,location=no,scrollbars=yes,toolbar=no,menubar=no,status=no'{/if})"
					{else}
						{if $LINK_URL neq '' && !isset($LINK['linkhref'])}
							{if stripos($LINK_URL, 'javascript:')===0}
								onclick='{$LINK_URL|substr:strlen("javascript:")};'
							{else}
								onclick="window.location.href = '{$LINK_URL}'"
							{/if}
						{/if}
					{/if}
				{/if}
				>
				{if isset($LINK['linkimg'])}
					<img class="image-in-button" src="{$LINK['linkimg']}" title="{\YF\Core\Functions::translate($LABEL, $BTN_MODULE)}">
				{elseif isset($LINK['linkicon'])}
					<span class="{$LINK['linkicon']}"></span>
				{/if}
				{if $LABEL neq '' && isset($LINK['showLabel'])}
					{if !isset($LINK['linkimg']) || isset($LINK['linkicon'])}&nbsp;&nbsp;{/if}
					<strong>{\YF\Core\Functions::translate($LABEL, $BTN_MODULE)}</strong>
				{/if}
				{if isset($LINK['linkhref'])}</a>{else}</button>{/if}
</div>
{/strip}
