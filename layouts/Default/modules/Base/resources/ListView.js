jQuery.Class("Base_ListView_Js", {
}, {
	registerSelectRecord: function () {
		jQuery('.listViewEntries tr').click('click', function (e) {
			var url = 'index.php?module=' + app.getModuleName() + '&view=DetailView&record=' + $(this).data('record');
			AppConnector.requestPjax(url).then(function (data) {

			});
		});
	},
	registerEvents: function () {
		this.registerSelectRecord();
	}
});
