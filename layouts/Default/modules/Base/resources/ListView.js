/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

jQuery.Class("Base_ListView_Js", {
}, {
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
			table.$('.listViewEntries tbody tr').on('click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				if ($.contains(jQuery(e.currentTarget).find('td:first-child').get(0), e.target)){
					return;
				}
				jQuery(e.currentTarget).find('.detailLink').trigger('click');
			});
		}
	},
	registerEvents: function () {
		this.registerDataTable();
	}
});
