/**
 * Record list modal class
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
'use strict';

window.Base_RecordListModal_JS = class {
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
			deferRender: true,
			ajax: {
				url: 'index.php',
				type: 'POST',
				data: (data) => {
					$.extend(data, this.listForm.serializeFormData());
				},
				error: function (jqXHR, ajaxOptions, thrownError) {
					app.errorLog(jqXHR, thrownError);
					app.showNotify({
						text: thrownError,
						type: 'error',
						stack: window.stackPage
					});
				}
			}
		});
		this.listForm.find('input,select').on('change', () => {
			this.dataTable.ajax.reload();
		});
	}
	/**
	 * Register records events
	 */
	registerListEvents() {
		this.table.on('click', '.js-search-records', () => {
			this.dataTable.ajax.reload();
		});
		this.table.on('click', '.js-clear-search', () => {
			this.table.find('.js-filter-field').each(function () {
				this.value = '';
			});
			this.dataTable.ajax.reload();
		});
		this.table.on('click', '.js-select-record', (e) => {
			this.selectCallBack(e);
		});
		this.table.on('click', 'tbody tr', function (e) {
			let element = jQuery(this);
			if (element.prop('tagName') !== 'A') {
				element.find('.js-select-record').off('click').trigger('click');
			}
		});
	}
	addSelectCallBack(fn) {
		this.selectCallBack = fn;
	}
	/**
	 * Register modal events.
	 * @param {jQuery} modalContainer
	 */
	registerEvents(modalContainer) {
		this.container = modalContainer;
		this.table = modalContainer.find('.js-record-list-table');
		this.listForm = modalContainer.find('.js-form-container');
		this.registerDataTable();
		this.registerListEvents();
	}
};
