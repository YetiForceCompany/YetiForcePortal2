/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

jQuery.Class(
	'YetiForce_Credits_Js',
	{},
	{
		/**
		 * Function to get the container
		 * @returns {jQuery}
		 */
		getContainer() {
			if (!this.container) {
				this.container = $('.js-table-container');
			}
			return this.container;
		},
		/**
		 * Register tables
		 * @param contentData
		 * @returns {jQuery}
		 */
		registerDataTables(contentData) {
			$.extend($.fn.dataTable.defaults, {
				bPaginate: false,
				order: [],
				language: {
					sZeroRecords: app.translate('JS_NO_RESULTS_FOUND'),
					sInfo: app.translate('JS_S_INFO'),
					sInfoEmpty: app.translate('JS_S_INFO_EMPTY'),
					sSearch: app.translate('JS_SEARCH'),
					sEmptyTable: app.translate('JS_NO_RESULTS_FOUND'),
					sInfoFiltered: app.translate('JS_S_INFO_FILTERED'),
					sLoadingRecords: app.translate('JS_LOADING_OF_RECORDS'),
					sProcessing: app.translate('JS_LOADING_OF_RECORDS'),
					oAria: {
						sSortAscending: app.translate('JS_S_SORT_ASCENDING'),
						sSortDescending: app.translate('JS_S_SORT_DESCENDING')
					}
				}
			});
			return contentData.find('.dataTableWithRecords').DataTable();
		},
		/**
		 * Show modal with more information
		 * @param container
		 */
		showMore(container) {
			container.find('.js-show-more').on('click', function (e) {
				let element = $(this);
				AppConnector.request({
					module: app.getModuleName(),
					view: 'LibraryMoreInfo',
					type: element.attr('data-type'),
					libraryName: element.attr('data-library-name')
				}).done(function (data) {
					app.showModalWindow(data);
				});
			});
		},
		/**
		 * Show modal with information about license
		 * @param container
		 */
		showLicense(container) {
			container.find('.js-show-license').on('click', function (e) {
				AppConnector.request({
					module: app.getModuleName(),
					view: 'LibraryLicense',
					license: $(this).attr('data-license')
				}).done(function (data) {
					if (data) {
						app.showModalWindow(data);
					}
				});
			});
		},
		registerEvents() {
			let container = this.getContainer();
			this.registerDataTables(container);
			this.showMore(container);
			this.showLicense(container);
		}
	}
);
