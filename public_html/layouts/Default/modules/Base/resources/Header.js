/**
 * Base header class
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
'use strict';

jQuery.Class(
	'Base_Header_Js',
	{
		self: false,
		getInstance: function () {
			if (this.self != false) {
				return this.self;
			}
			this.self = new Base_Header_Js();
			return this.self;
		}
	},
	{
		recentPageViews: function () {
			var thisInstance = this;
			var maxValues = 20;
			var BtnText = '';
			var BtnLink = 'javascript:void();';
			var key = 'yf_history_portal_';
			var history = localStorage.getItem(key);
			if (history != '' && history != null) {
				var sp = history.toString().split('_|_');
				var item = sp[sp.length - 1].toString().split('|');
				BtnText = item[0];
				BtnLink = item[1];
			}
			var htmlContent = '<ul class="dropdown-menu float-right historyList px-3" role="menu">';
			var date = new Date().getTime();
			var howManyDays = -1;
			var writeSelector = true;
			if (sp != null) {
				for (var i = sp.length - 1; i >= 0; i--) {
					item = sp[i].toString().split('|');
					var d = new Date();
					var t = '';
					if (item[2] != undefined) {
						d.setTime(item[2]);
						var hours = app.formatDateZ(d.getHours());
						var minutes = app.formatDateZ(d.getMinutes());
						if (writeSelector && howManyDays != app.howManyDaysFromDate(d)) {
							howManyDays = app.howManyDaysFromDate(d);
							if (howManyDays == 0) {
								htmlContent += '<li class="selectorHistory">' + app.translate('JS_TODAY') + '</li>';
							} else if (howManyDays == 1) {
								htmlContent += '<li class="selectorHistory">' + app.translate('JS_YESTERDAY') + '</li>';
							} else {
								htmlContent += '<li class="selectorHistory">' + app.translate('JS_OLDER') + '</li>';
								writeSelector = false;
							}
						}
						if (writeSelector) t = '<span class="historyHour">' + hours + ':' + minutes + '</span> | ';
						else t = app.formatDate(d) + ' | ';
					}
					var format = $('#userDateFormat').val() + '' + $('#userDateFormat').val();
					htmlContent += ' <a class="item dropdown-item" href="' + item[1] + '">' + t + item[0] + '</a>';
				}
				var Label = this.getHistoryLabel();
				if (Label.length > 1 && document.URL != BtnLink) {
					sp.push(this.getHistoryLabel() + '|' + document.URL + '|' + date);
				}
				if (sp.length >= maxValues) {
					sp.splice(0, 1);
				}
				localStorage.setItem(key, sp.join('_|_'));
			} else {
				var stack = new Array();
				var Label = this.getHistoryLabel();
				if (Label.length > 1) {
					stack.push(this.getHistoryLabel() + '|' + document.URL + '|' + date);
					localStorage.setItem(key, stack.join('_|_'));
				}
			}
			if (history != null) {
				htmlContent +=
					'<div class="dropdown-divider"></div><a class="dropdown-item clearHistory" href="#">' +
					app.translate('JS_CLEAR_HISTORY') +
					'</a>';
			} else {
				htmlContent +=
					' <a class="item dropdown-item" href="#" role="listitem">' + app.translate('JS_NO_RECORDS') + '</a>';
			}

			htmlContent += '</ul>';
			$('.showHistoryBtn').after(htmlContent);
			this.registerClearHistory();
		},
		getHistoryLabel: function () {
			var label = '';
			$('.breadcrumbsLinks span').each(function (index) {
				label += $(this).text().replace(/\//g, ' ');
			});
			return label;
		},
		registerClearHistory: function () {
			$('.historyBtn .clearHistory').click(function () {
				var key = 'yf_history_portal_';
				localStorage.removeItem(key);
				var htmlContent =
					'<a class="item dropdown-item" href="#" role="listitem">' + app.translate('JS_NO_RECORDS') + '</a>';
				$('.historyBtn .dropdown-menu').html(htmlContent);
			});
		},
		/**
		 * Show left scrollbar for menu.
		 */
		registerScrolbarToMenu() {
			const container = $('.js-base-container'),
				menuContainer = container.find('.js-menu--scroll');
			app.showNewScrollbarLeft(menuContainer, { suppressScrollX: true });
		},
		/**
		 * Pin menu
		 */
		registerPinEvent: function () {
			const container = $('.js-base-container');
			let pinButton = container.find('.js-menu--pin');
			pinButton.on('click', () => {
				let hideMenu = 0;
				if (pinButton.attr('data-show') === '0') {
					hideMenu = 1;
					pinButton.removeClass('u-opacity-muted');
					container.addClass('c-menu--open');
				} else {
					pinButton.addClass('u-opacity-muted');
					container.removeClass('c-menu--open');
				}
				pinButton.attr('data-show', hideMenu);

				AppConnector.request({
					module: 'Users',
					action: 'UserPreferences',
					key: 'menuPin',
					value: hideMenu
				}).done((response) => {
					if (response.success) {
						app.showNotify({
							text: app.translate('JS_SAVE_NOTIFY_SUCCESS'),
							type: 'success'
						});
					}
				});
				setTimeout(() => {
					container.addClass('c-menu--animation');
				}, 300);
			});
		},
		registerEvents: function () {
			var thisInstance = this;
			thisInstance.recentPageViews();
			thisInstance.registerScrolbarToMenu();
			thisInstance.registerPinEvent();
			App.Fields.Tree.getInstance();
		}
	}
);
jQuery(document).ready(function () {
	Base_Header_Js.getInstance().registerEvents();
});
