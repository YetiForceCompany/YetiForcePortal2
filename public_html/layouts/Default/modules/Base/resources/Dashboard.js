/**
 * Base dashboard view class
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
'use strict';

window.Base_Dashboard_Js = class {
	registerEventsForWidgets() {
		$('.js-widget').each(function () {
			const typeWidget = $(this).data('type');
			var classname = 'Base_Dashboard_' + typeWidget + '_Js';
			if (typeof window[classname] != 'undefined') {
				return new window[classname]().registerEvents($(this));
			}
		});
	}
	/**
	 * Register selector dashboard
	 */
	registerSelectDashboard() {
		const self = this;
		$('.js-select-dashboard').on('click', function (e) {
			let id = $(this).data('id');
			const progressInstance = $.progressIndicatorShow();
			AppConnector.requestPjax('index.php?module=Home&view=Dashboard&dashboard=' + id).done(function (data) {
				progressInstance.progressIndicator({ mode: 'hide' });
				$('.js-dashboard-container').html(data);
				self.registerBasicEvents();
			});
		});
	}
	/**
	 * Register basic events
	 */
	registerBasicEvents() {
		this.registerEventsForWidgets();
	}
	/**
	 * Register events
	 */
	registerEvents() {
		this.registerSelectDashboard();
		this.registerBasicEvents();
	}
};
