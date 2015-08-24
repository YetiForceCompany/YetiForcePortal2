jQuery.Class("Base_ListView_Js", {
}, {
	registerSelectRecord: function () {
		$('.listViewEntries tr').click('click', function (e) {
			var url = 'index.php?module=' + app.getModuleName() + '&view=DetailView&record=' + $(this).data('record');
			AppConnector.requestPjax(url).then(function (data) {
				$('div.bodyContent').html(data);
			});
		});
	},
	registerEvents: function () {
		this.registerSelectRecord();
	}
});
