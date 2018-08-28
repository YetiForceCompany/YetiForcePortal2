{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="card-header">{\App\Functions::translate('LBL_DEBUG_CONSOLE', $MODULE_NAME)}</div>
			<div class="card-body">
				{foreach item=ITEM key=KEY from=$DEBUG_API}
					<div>
						Start time: {$ITEM['date']}<br/>
						Execution time: {$ITEM['time']}<br/>
						API method: {$ITEM['method']}<br/>
						Request type: {$ITEM['requestType']}<br/>
					</div>
					<div>
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation">
								<a href="#rawRequest{$KEY}" aria-controls="rawRequest{$KEY}" role="tab"
								   data-toggle="tab">Request</a>
							</li>
							<li role="presentation">
								<a href="#rawResponse{$KEY}" aria-controls="rawResponse{$KEY}" role="tab"
								   data-toggle="tab">Raw response</a>
							</li>
							<li role="presentation" class="active">
								<a href="#response{$KEY}" aria-controls="response{$KEY}" role="tab" data-toggle="tab">Response</a>
							</li>
							<li role="presentation">
								<a href="#trace{$KEY}" aria-controls="trace{$KEY}" role="tab"
								   data-toggle="tab">Trace</a>
							</li>
						</ul>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane" id="rawRequest{$KEY}">
								Headers:<br/>
								<pre>{print_r($ITEM['rawRequest'][0],true)}</pre>
								Request data:<br/>
								<pre>{print_r($ITEM['rawRequest'][1],true)}</pre>
							</div>
							<div role="tabpanel" class="tab-pane" id="rawResponse{$KEY}">
								<pre>{print_r($ITEM['request'],true)}</pre>
							</div>
							<div role="tabpanel" class="tab-pane active" id="response{$KEY}">
								<pre>{print_r($ITEM['response'],true)}</pre>
							</div>
							<div role="tabpanel" class="tab-pane" id="trace{$KEY}">
								<pre>{print_r($ITEM['trace'],true)}</pre>
							</div>
						</div>
					</div>
					<hr/>
				{/foreach}
			</div>
		</div>
	</div>
{/strip}

