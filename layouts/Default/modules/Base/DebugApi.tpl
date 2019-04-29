{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="col-sm-12 px-0 mt-4">
		<div class="card c-card">
			<div class="card-header collapsed c-card__header"  id="headingDebugApi" data-toggle="collapse" data-target="#debugApi" aria-expanded="true" aria-controls="collapseOne">
				<span class="fas fa-angle-right mr-2 c-card__icon-right"></span>
				<span class="fas fa-angle-down mr-2 c-card__icon-down"></span>
				<span class="font-weight-bold">{\App\Language::translate('LBL_DEBUG_CONSOLE', $MODULE_NAME)}</span>
			</div>
			<div id="debugApi" class="collapse"  aria-labelledby="headingDebugApi">
				<div class="card-body">
					<div class="accordion c-card__accordion" id="accordionExample">
						{foreach item=ITEM key=KEY from=$DEBUG_API}
							<div class="card">
								<div class="card-header noSpaces  c-card__header" id="headingOne">
									<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#request{$KEY}" aria-expanded="true" aria-controls="collapseOne">
										<span class="font-weight-bold">{$ITEM['method']}</span>
									</button>
								</div>
								<div id="request{$KEY}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
									<div class="card-body">
										<div class="col-3 px-0">
											<table class="table">
												<thead>
													<tr>
														<th scope="col"><span class="font-weight-bold u-fs-12px">Start time:</span></th>
														<th scope="col"><span class="font-weight-bold u-fs-12px">Execution time:</span></th>
														<th scope="col"><span class="font-weight-bold u-fs-12px">API method:</span></th>
														<th scope="col"><span class="font-weight-bold u-fs-12px">Request type:</span></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="u-fs-10px">{$ITEM['date']}</td>
														<td class="u-fs-10px">{$ITEM['time']}</td>
														<td class="u-fs-10px">{$ITEM['method']}</td>
														<td class="u-fs-10px">{$ITEM['requestType']}</td>
													</tr>
												</tbody>
											</table>
										</div>
										<ul class="nav nav-tabs" role="tablist">
											<li role="nav-item">
												<a class="nav-link active" href="#rawRequest{$KEY}" aria-controls="rawRequest{$KEY}" role="tab"
													data-toggle="tab">Request</a>
											</li>
											<li role="nav-item">
												<a class="nav-link" href="#rawResponse{$KEY}" aria-controls="rawResponse{$KEY}" role="tab"
													data-toggle="tab">Raw response</a>
											</li>
											<li role="nav-item " >
												<a class="nav-link " href="#response{$KEY}" aria-controls="response{$KEY}" role="tab" data-toggle="tab">Response</a>
											</li>
											<li role="nav-item">
												<a class="nav-link" href="#trace{$KEY}" aria-controls="trace{$KEY}" role="tab"
													data-toggle="tab">Trace</a>
											</li>
										</ul>
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane active" id="rawRequest{$KEY}">
												Headers:<br/>
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['rawRequest'][0],true))}</pre>
												Request data:<br/>
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['rawRequest'][1],true))}</pre>
											</div>
											<div role="tabpanel" class="tab-pane" id="rawResponse{$KEY}">
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['request'],true))}</pre>
											</div>
											<div role="tabpanel" class="tab-pane " id="response{$KEY}">
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['response'],true))}</pre>
											</div>
											<div role="tabpanel" class="tab-pane" id="trace{$KEY}">
												<pre>{App\Purifier::encodeHTML(print_r($ITEM['trace'],true))}</pre>
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
