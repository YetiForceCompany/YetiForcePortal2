/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

jQuery.Class("Base_ListView_Js", {
}, {
	registerSelectRecord: function () {
		$('.actions').click(function(event){
			event.stopPropagation();
		});
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
