/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

window.Base_RecordList_Js = class {
	/**
	 * Register tables with records
	 */
	registerDataTable() {
		let params = {};
		let lengthMenu = app.getMainParams('listEntriesPerPage', true);
		if (lengthMenu) {
			params.lengthMenu = lengthMenu;
		}
		params.columnDefs = [{ orderable: false, targets: 0 }];
		params.order = [];
		let table = app.registerDataTables(this.container.find('table.listViewEntries'), params);
		if (table) {
			$(table.table().container()).find('.listViewEntries').removeClass('d-none');
			table.$('.deleteRecordButton').on('click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				let element = $(e.currentTarget);
				AppConnector.request(element.data('url')).done((data) => {
					if (data.result) {
						table.row(element.closest('tr')).remove().draw();
					}
				});
			});
			table.$('.listViewEntries tbody tr').on('click', function (e) {
				e.stopPropagation();
				e.preventDefault();
				if ($.contains($(e.currentTarget).find('td:first-child').get(0), e.target)) {
					return;
				}
				app.event.trigger('AfterSelectedRecordList', {
					id: $(e.currentTarget).closest('tr').data('record'),
					name: $(e.currentTarget).closest('tr').data('name')
				});
				app.hideModalWindow();
			});
		}
		return table;
	}
	/**
	 * Register modal events.
	 * @param {jQuery} modalContainer
	 */
	registerEvents(modalContainer) {
		this.container = modalContainer;
		this.registerDataTable();
	}
};
