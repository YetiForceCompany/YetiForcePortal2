/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

jQuery.Class(
	'Base_RecordList_Js',
	{},
	{
		/**
		 * Register tables with records
		 * @param {jQuery} container
		 */
		registerDataTable: function (container) {
			var params = {};
			var lengthMenu = app.getMainParams('listEntriesPerPage', true);
			if (lengthMenu) {
				params.lengthMenu = lengthMenu;
			}
			params.columnDefs = [{ orderable: false, targets: 0 }];
			params.order = [];
			var table = app.registerDataTables(container.find('table.listViewEntries'), params);
			if (table) {
				jQuery(table.table().container()).find('.listViewEntries').removeClass('d-none');
				table.$('.deleteRecordButton').on('click', function (e) {
					e.stopPropagation();
					e.preventDefault();
					var element = jQuery(e.currentTarget);
					AppConnector.request(element.data('url')).then(
						function (data) {
							if (data.result) {
								table.row(element.closest('tr')).remove().draw();
							}
						},
						function (e, err) {
							console.log([e, err]);
						}
					);
				});
				table.$('.listViewEntries tbody tr').on('click', function (e) {
					e.stopPropagation();
					e.preventDefault();

					if ($.contains(jQuery(e.currentTarget).find('td:first-child').get(0), e.target)) {
						return;
					}
					app.event.trigger('AfterSelectedRecordList', {
						id: jQuery(e.currentTarget).closest('tr').data('record'),
						name: jQuery(e.currentTarget).closest('tr').data('name')
					});
					app.hideModalWindow();
				});
			}
			return table;
		},
		/**
		 * Register all events in view
		 * @param {jQuery} container
		 */
		registerEvents: function (container) {
			this.registerDataTable(container);
		}
	}
);
