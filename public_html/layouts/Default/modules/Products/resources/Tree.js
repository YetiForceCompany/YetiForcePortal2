/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

jQuery.Class("Products_Tree_Js", {}, {
	registerDataTable: function () {
		var params = {};
		var lengthMenu = app.getMainParams('listEntriesPerPage', true);
		if (lengthMenu) {
			params.lengthMenu = lengthMenu;
		}
		params.columnDefs = [{"orderable": false, "targets": 0}];
		params.order = [];
		var table = app.registerDataTables(jQuery('table.listViewEntries'), params);
		if (table) {
			jQuery(table.table().container()).find('.listViewEntries').removeClass('d-none')
			table.$('.deleteRecordButton').on('click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				var element = jQuery(e.currentTarget);
				AppConnector.request(element.data('url')).then(function (data) {
					if (data.result) {
						table.row(element.closest('tr')).remove().draw();
					}
				}, function (e, err) {
					console.log([e, err])
				});
			});
			table.$('.listViewEntries tbody tr').on('click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				if ($.contains(jQuery(e.currentTarget).find('td:first-child').get(0), e.target)) {
					return;
				}
				jQuery(e.currentTarget).find('.detailLink').trigger('click');
			});
		}
		return table;
	},
	registerDeleteRecordClickEvent: function () {
		var thisInstance = this;
		var listViewContentDiv = this.getListViewContentContainer();
		listViewContentDiv.on('click', '.deleteRecordButton', function (e) {
			var elem = jQuery(e.currentTarget);
			var recordId = elem.closest('tr').data('id');
			Vtiger_List_Js.deleteRecord(recordId);
			e.stopPropagation();
		});
	},
	registerEvents: function () {
		this.registerDataTable();
	}
});
