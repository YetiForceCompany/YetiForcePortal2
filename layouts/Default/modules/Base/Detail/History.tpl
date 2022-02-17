{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Detail-History -->
	<div class="w-100">
		<ul class="timeline">
			{foreach item=HISTORY from=$HISTORY_MODEL->getHistory()}
				{if isset($HISTORY_MODEL::$iconActions[$HISTORY['rawStatus']])}
					<li data-type="{$HISTORY['rawStatus']}">
						<div class="d-flex">
							<span class="c-circle-icon mt-2 pt-1 bg-success d-sm-inline d-none text-center" style="background-color: {$HISTORY_MODEL::$colorsActions[$HISTORY['rawStatus']]} !important;">
								<span class="{$HISTORY_MODEL::$iconActions[$HISTORY['rawStatus']]} fa-fw text-light"></span>
							</span>
							<div class="flex-grow-1 ml-1 p-1 timeline-item">
								<div class="timeline-body small">
									<div class="float-right time text-muted ml-1">{$HISTORY['time']}</div>
									<strong class="mr-1">{$HISTORY['owner']}</strong>{$HISTORY['status']}
									{if $HISTORY['rawStatus'] === 'LBL_ADDED'}
										<strong class="mx-1">{$HISTORY['data']['targetLabel']}</strong>
										({$HISTORY['data']['targetModuleLabel']})
									{elseif $HISTORY['rawStatus'] === 'LBL_CREATED'}
										<div>
											{foreach key=FIELD_NAME item=FIELD_VALUE from=$HISTORY['data']}
												<div class='font-x-small d-flex flex-wrap'>
													<span class="mr-1">{$FIELD_VALUE['label']}:</span><strong>{\App\Viewer::truncateText($FIELD_VALUE['value'],100, true)}</strong>
												</div>
											{/foreach}
										</div>
									{elseif in_array($HISTORY['rawStatus'],['LBL_TRANSFER_EDIT','LBL_UPDATED'])}
										<div>
											{foreach key=FIELD_NAME item=FIELD_VALUE from=$HISTORY['data']}
												<div class='font-x-small d-flex flex-wrap'>
													<span class="mr-1">{$FIELD_VALUE['label']}:</span>
													{\App\Language::translate('LBL_FROM')}
													<strong class="mx-1">{if !empty($FIELD_VALUE['from'])}{\App\Viewer::truncateText($FIELD_VALUE['from'],100, true)}{/if}</strong>
													{\App\Language::translate('LBL_TO')}
													<strong class="ml-1">{\App\Viewer::truncateText($FIELD_VALUE['to'],100, true)}</strong>
												</div>
											{/foreach}
										</div>
									{/if}
								</div>
							</div>
						</div>
					</li>
				{/if}
			{/foreach}
		</ul>
	</div>
	<!-- /tpl-Base-Detail-History -->
{/strip}
