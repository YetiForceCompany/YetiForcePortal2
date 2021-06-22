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
	/**
	 * Register widgets events
	 */
	registerWidgetsEvents() {
		$('.js-widget-container').each(function () {
			const typeWidget = $(this).data('type');
			let className = 'Base_Widget_' + typeWidget + '_Js';
			if (typeof window[className] != 'undefined') {
				return new window[className]().registerEvents($(this));
			}
		});
	}
	/**
	 * Register related list events
	 */
	registerRelatedListEvents() {
		if (this.container.find('#mode').val() === 'relatedList') {
			let className = app.getModuleName() + '_RelatedListView_Js';
			if (typeof window[className] != 'undefined') {
				new window[className]().registerEvents(this.container.find('.js-form-container'));
			} else {
				let className = 'Base_RelatedListView_Js';
				if (typeof window[className] != 'undefined') {
					new window[className]().registerEvents(this.container.find('.js-form-container'));
				}
			}
		}
	}
	/**
	 * Register detail view events.
	 */
	registerEvents() {
		this.container = $('#page');
		this.registerRecordEvents();
		this.registerWidgetsEvents();
		this.registerRelatedListEvents();
	}
};
