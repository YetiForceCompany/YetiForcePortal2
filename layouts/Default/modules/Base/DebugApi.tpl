{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="col-sm-12 px-0 mt-4 pb-4">
		<div class="card c-card">
			<div class="card-header collapsed c-card__header p-2" id="headingDebugApi" data-toggle="collapse" data-target="#debugApi" aria-expanded="true" aria-controls="collapseOne">
				<span class="fas fa-angle-right mr-2 c-card__icon-right"></span>
				<span class="fas fa-angle-down mr-2 c-card__icon-down"></span>
				<span class="font-weight-bold">{\App\Language::translate('LBL_DEBUG_CONSOLE')}</span>
			</div>
			<div id="debugApi" class="collapse {if !empty($COLLAPSE)}show{/if}" aria-labelledby="headingDebugApi">
				<div class="card-body p-1">
					<div class="accordion c-card__accordion" id="accordionExample">
						{foreach item=ITEM key=KEY from=$DEBUG_API}
							<div class="card mt-2">
								<div class="card-header noSpaces  c-card__header" id="headingOne{$KEY}">
									<span class="btn btn-link" type="button" data-toggle="collapse" data-target="#request{$KEY}" aria-expanded="true" aria-controls="collapseOne">
										<span class="font-weight-bold mr-3">{$ITEM['method']}</span>
										<span class="text-secondary mr-3">Request type: {$ITEM['requestType']}</span>
										<span class="text-secondary mr-3">Start time: {$ITEM['date']}</span>
										<span class="text-secondary mr-3">Execution time: {$ITEM['time']}</span>
										<span class="text-secondary mr-3">Size: {\App\Utils::showBytes(\strlen($ITEM['rawResponse']))}</span>
										{if isset($ITEM['requestId'])}
											<span class="text-secondary mr-3">Request ID: {$ITEM['requestId']}</span>
										{/if}
									</span>
								</div>
								<div id="request{$KEY}" class="collapse {if !empty($COLLAPSE)}show{/if}" aria-labelledby="headingOne{$KEY}" data-parent="#accordionExample">
									<div class="card-body">
										<ul class="nav nav-tabs c-nav" role="tablist">
											<li role="nav-item c-nav__item">
												<a class="nav-link c-nav__link active" href="#rawRequest{$KEY}" aria-controls="rawRequest{$KEY}" role="tab"
													data-toggle="tab"><strong>Request</strong></a>
											</li>
											<li role="nav-item c-nav__item">
												<a class="nav-link c-nav__link" href="#rawResponse{$KEY}" aria-controls="rawResponse{$KEY}" role="tab"
													data-toggle="tab"><strong>Raw response</strong></a>
											</li>
											<li role="nav-item c-nav__item">
												<a class="nav-link c-nav__link" href="#response{$KEY}" aria-controls="response{$KEY}" role="tab" data-toggle="tab"><strong>Response</strong></a>
											</li>
											<li role="nav-item c-nav__item">
												<a class="nav-link c-nav__link" href="#trace{$KEY}" aria-controls="trace{$KEY}" role="tab"
													data-toggle="tab"><strong>Trace</strong></a>
											</li>
										</ul>
										<div class="tab-content mt-3">
											<div role="tabpanel" class="tab-pane active" id="rawRequest{$KEY}">
												Headers:<br />
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['rawRequest'][0],true))}</pre>
												Request data:<br />
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['rawRequest'][1],true))}</pre>
											</div>
											<div role="tabpanel" class="tab-pane" id="rawResponse{$KEY}">
												{if isset($ITEM['rawResponse'])}
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['rawResponse'],true))}</pre>{/if}
											</div>
											<div role="tabpanel" class="tab-pane " id="response{$KEY}">
												{if isset($ITEM['response'])}
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['response'],true))}</pre>{/if}
											</div>
											<div role="tabpanel" class="tab-pane" id="trace{$KEY}">
												<pre class="bg-light p-3">{App\Purifier::encodeHTML(print_r($ITEM['trace'],true))}</pre>
											</div>
										</div>
									</div>
								</div>
							</div>
						{/foreach}
					</div>
				</div>
			</div>
		</div>
	</div>
{/strip}
