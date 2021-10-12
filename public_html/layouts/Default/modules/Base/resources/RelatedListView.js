/**
 * Base related list view class
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
'use strict';

window.Base_RelatedListView_Js = class {
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
					$.extend(data, this.container.serializeFormData());
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
		this.container.find('input').on('change', () => {
			this.dataTable.ajax.reload();
		});
	}
	/**
	 * Register record events
	 */
	registerRecordEvents() {
		this.table.on('click', '.js-search-records', () => {
			this.dataTable.ajax.reload();
		});
		this.table.on('click', '.js-clear-search', () => {
			this.table.find('.js-filter-field').each(function () {
				this.value = '';
			});
			this.dataTable.ajax.reload();
		});
		this.container.on('click', '.js-create-related-record', (e) => {
			let url = $(e.currentTarget).data('url');
			const progress = $.progressIndicator({ blockInfo: { enabled: true } });
			let params = {
				callbackAfterSave: (response) => {
					this.dataTable.ajax.reload();
				}
			};
			App.Components.QuickCreate.getForm(url, params)
				.done((data) => {
					App.Components.QuickCreate.showModal(data, params);
				})
				.fail((textStatus, errorThrown) => {
					app.showNotify({
						text: errorThrown,
						title: app.translate('JS_ERROR'),
						type: 'error'
					});
				})
				.always(() => {
					progress.progressIndicator({ mode: 'hide' });
				});
		});
	}
	/**
	 * Register modal events.
	 */
	registerEvents(container) {
		this.container = container;
		this.table = this.container.find('.js-list-view-table');
		this.registerDataTable();
		this.registerRecordEvents();
	}
};
