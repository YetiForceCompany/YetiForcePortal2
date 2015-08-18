{strip}
	<div class="panel panel-primary">
		<div class="panel-heading">{translate('LBL_DEBUG_CONSOLE', $MODULE_NAME)}</div>
		<div class="panel-body">
			{foreach item=ITEM key=KEY from=$DEBUG_API}
				<div>
					Start time: {$ITEM['date']}<br/>
					Execution time: {$ITEM['time']}<br/>
					API method: {$ITEM['method']}<br/>
				</div>
				<div>
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation">
							<a href="#rawRequest{$KEY}" aria-controls="rawRequest{$KEY}" role="tab" data-toggle="tab">Raw request</a>
						</li>
						<li role="presentation">
							<a href="#rawResponse{$KEY}" aria-controls="rawResponse{$KEY}" role="tab" data-toggle="tab">Raw response</a>
						</li>
						<li role="presentation" class="active">
							<a href="#response{$KEY}" aria-controls="response{$KEY}" role="tab" data-toggle="tab">Response</a>
						</li>
						<li role="presentation">
							<a href="#request{$KEY}" aria-controls="request{$KEY}" role="tab" data-toggle="tab">Request</a>
						</li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane" id="rawRequest{$KEY}">
							<pre>{print_r($ITEM['rawRequest'],true)}</pre>
						</div>
						<div role="tabpanel" class="tab-pane" id="rawResponse{$KEY}">
							<pre>{print_r($ITEM['rawResponse'],true)}</pre>
						</div>
						<div role="tabpanel" class="tab-pane active" id="response{$KEY}">
							<pre>{print_r($ITEM['response'],true)}</pre>
						</div>
						<div role="tabpanel" class="tab-pane" id="request{$KEY}">
							<pre>{print_r($ITEM['request'],true)}</pre>
						</div>
					</div>
				</div>
				<hr/>
			{/foreach}
		</div>
	</div>
{/strip}

