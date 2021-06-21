/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_DetailView_Js = class {
	/**
	 * Register record events
	 */
	registerRecordEvents() {
		this.container.on('click', '.js-delete-record', (e) => {
			app.showNotifyConfirm(
				{
					title: app.translate('JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE')
				},
				function () {
					AppConnector.request({
						data: {},
						url: $(e.currentTarget).data('url')
					}).done((data) => {
						if (data.result) {
							window.location.href = 'index.php?module=' + app.getModuleName() + '&view=ListView';
						}
					});
				}
			);
		});
	}

	registerEventsForWidgets() {
		$('.js-widget-container').each(function () {
			const typeWidget = $(this).data('type');
			var className = 'Base_Widget_' + typeWidget + '_Js';
			if (typeof window[className] != 'undefined') {
				return new window[className]().registerEvents($(this));
			}
		});
	}

	/**
	 * Register detail view events.
	 */
	registerEvents() {
		this.container = $('#page');
		this.registerRecordEvents();
		this.registerEventsForWidgets();
	}
};
