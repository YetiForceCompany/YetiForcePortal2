{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="col-sm-12">
		<div class="card card-primary">
			<div class="card-header">{\App\Language::translate('LBL_DEBUG_CONSOLE', $MODULE_NAME)}</div>
			<div class="card-body">
			<div class="accordion" id="accordionExample">
				{foreach item=ITEM key=KEY from=$DEBUG_API}
					<div class="card">
						<div class="card-header noSpaces" id="headingOne">
							<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#request{$KEY}" aria-expanded="true" aria-controls="collapseOne">
							{$ITEM['method']}
							</button>
						</div>
						<div id="request{$KEY}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
							<div class="card-body">
							Start time: {$ITEM['date']}<br/>
							Execution time: {$ITEM['time']}<br/>
							API method: {$ITEM['method']}<br/>
							Request type: {$ITEM['requestType']}<br/>
							<ul class="nav nav-pills nav-fill" role="tablist">
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
{/strip}
