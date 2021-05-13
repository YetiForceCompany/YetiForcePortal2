/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_ListView_Js = class {
	/**
	 * Register data table
	 */
	registerDataTable() {
		this.dataTable = app.registerDataTables(this.table, {
			order: [],
			processing: true,
			serverSide: true,
			searching: false,
			orderCellsTop: true,
			ajax: {
				url: 'index.php',
				type: 'POST',
				data: (data) => {
					$.extend(data, this.listForm.serializeFormData());
				}
			}
		});
		this.listForm.find('input').on('change', () => {
			this.dataTable.ajax.reload();
		});
	}
	/**
	 * Register record events
	 */
	registerRecordEvents() {
		// table.$('.deleteRecordButton').on('click', function (e) {
		// 	e.stopPropagation();
		// 	e.preventDefault();
		// 	var element = jQuery(e.currentTarget);
		// 	AppConnector.request({
		// 		data: {},
		// 		url: element.data('url')
		// 	}).then(
		// 		function (data) {
		// 			if (data.result) {
		// 				table.row(element.closest('tr')).remove().draw();
		// 			}
		// 		},
		// 		function (e, err) {
		// 			console.log([e, err]);
		// 		}
		// 	);
		// });
		// table.$('.listViewEntries tbody tr').on('click', function (e) {
		// 	e.stopPropagation();
		// 	e.preventDefault();
		// 	if ($.contains(jQuery(e.currentTarget).find('td:first-child').get(0), e.target)) {
		// 		return;
		// 	}
		// 	jQuery(e.currentTarget).find('.detailLink').trigger('click');
		// });
		// var listViewContentDiv = this.getListViewContentContainer();
		// 	listViewContentDiv.on('click', '.deleteRecordButton', function (e) {
		// 		var elem = jQuery(e.currentTarget);
		// 		var recordId = elem.closest('tr').data('id');
		// 		Vtiger_List_Js.deleteRecord(recordId);
		// 		e.stopPropagation();
		// 	});
	}
	/**
	 * Register modal events.
	 */
	registerEvents() {
		this.listForm = $('.js-form-container');
		this.table = this.listForm.find('.js-list-view-table');
		this.registerDataTable();
	}
};
