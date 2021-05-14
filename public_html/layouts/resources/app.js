/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
window.App = {};
var AppConnector,
	app = {
		/**
		 * Events in application
		 */
		event: new (function () {
			this.el = $({});
			this.trigger = function () {
				this.el.trigger(arguments[0], Array.prototype.slice.call(arguments, 1));
			};
			this.on = function () {
				this.el.on.apply(this.el, arguments);
			};
			this.one = function () {
				this.el.one.apply(this.el, arguments);
			};
			this.off = function () {
				this.el.off.apply(this.el, arguments);
			};
		})(),
		languageString: [],
		cacheParams: [],
		/**
		 * Function to get the module name. This function will get the value from element which has id module
		 * @return : string - module name
		 */
		getModuleName: function () {
			return app.getMainParams('module');
		},
		/**
		 * Function to get the module name. This function will get the value from element which has id module
		 * @return : string - module name
		 */
		getParentModuleName: function () {
			return this.getMainParams('parent');
		},
		/**
		 * Function returns the current view name
		 */
		getViewName: function () {
			return app.getMainParams('view');
		},
		/**
		 * Function returns the javascript controller based on the current view
		 */
		getPageController: function () {
			let moduleName = app.getModuleName();
			let view = app.getViewName();
			let moduleClassName = moduleName + '_' + view + '_Js';
			let extendModules = jQuery('#extendModules').val();
			if (typeof window[moduleClassName] == 'undefined' && extendModules != undefined) {
				moduleClassName = extendModules + '_' + view + '_Js';
			}
			if (typeof window[moduleClassName] == 'undefined') {
				moduleClassName = 'Base_' + view + '_Js';
			}
			if (typeof window[moduleClassName] != 'undefined') {
				return new window[moduleClassName]();
			}
		},
		validationEngineOptions: {
			// Avoid scroll decision and let it scroll up page when form is too big
			// Reference: http://www.position-absolute.com/articles/jquery-form-validator-because-form-validation-is-a-mess/
			scroll: false,
			promptPosition: 'topLeft',
			//to support validation for chosen select box
			prettySelect: true,
			useSuffix: '_chosen',
			usePrefix: 's2id_'
		},
		formatDate: function (date) {
			var y = date.getFullYear(),
				m = date.getMonth() + 1,
				d = date.getDate(),
				h = date.getHours(),
				i = date.getMinutes(),
				s = date.getSeconds();
			return (
				y +
				'-' +
				this.formatDateZ(m) +
				'-' +
				this.formatDateZ(d) +
				' ' +
				this.formatDateZ(h) +
				':' +
				this.formatDateZ(i) +
				':' +
				this.formatDateZ(s)
			);
		},
		formatDateZ: function (i) {
			return i <= 9 ? '0' + i : i;
		},
		howManyDaysFromDate: function (time) {
			var fromTime = time.getTime();
			var today = new Date();
			var toTime = new Date(today.getFullYear(), today.getMonth(), today.getDate()).getTime();
			return Math.floor((toTime - fromTime) / (1000 * 60 * 60 * 24)) + 1;
		},
		parseFieldInfo: function (fieldInfo) {
			return JSON.parse(fieldInfo);
		},
		parseNumberToFloat: function (val) {
			var groupSeparator = app.getMainParams('currencyGroupingSeparator');
			var decimalSeparator = app.getMainParams('currencyDecimalSeparator');
			if (val === undefined || val === '') {
				val = 0;
			}
			val = val.toString();
			val = val.split(groupSeparator).join('');
			val = val.replace(/\s/g, '').replace(decimalSeparator, '.');
			return parseFloat(val);
		},
		registerSelectField: function (container) {
			this.registerChznSelectField(container);
			App.Fields.Picklist.changeSelectElementView(container);
		},

		/**
		 * Register time field.
		 */
		registerTimeField() {
			this.registerEventForClockPicker();
		},

		/**
		 * Register event for clock picker.
		 * @param {object} timeInputs
		 */
		registerEventForClockPicker(timeInputs = $('.clockPicker')) {
			if (!timeInputs.hasClass('clockPicker')) {
				timeInputs = timeInputs.find('.clockPicker');
			}
			if (!timeInputs.length) {
				return;
			}
			let params = {
				placement: 'bottom',
				autoclose: true,
				minutestep: 5
			};
			$('.js-clock__btn').on('click', (e) => {
				e.stopPropagation();
				let tempElement = $(e.currentTarget).closest('.time').find('input.clockPicker');
				if (tempElement.attr('disabled') !== 'disabled' && tempElement.attr('readonly') !== 'readonly') {
					tempElement.clockpicker('show');
				}
			});
			let formatTimeString = (timeInput) => {
				if (params.twelvehour) {
					let meridiemTime = '';
					params.afterDone = () => {
						//format time string after picking a value
						let timeString = timeInput.val(),
							timeStringFormatted = timeString.slice(0, timeString.length - 2) + ' ' + meridiemTime;
						timeInput.val(timeStringFormatted);
						app.event.trigger('Clockpicker.changed', timeInput);
					};
					params.beforeHide = () => {
						meridiemTime = $('.clockpicker-buttons-am-pm:visible').find('a:not(.text-white-50)').text();
					};
				} else {
					params.afterDone = () => {
						app.event.trigger('Clockpicker.changed', timeInput);
					};
				}
			};
			timeInputs.each((i, e) => {
				let timeInput = $(e);
				let formatTime = timeInputs.data('format') || app.getMainParams('hourFormat');
				params.twelvehour = parseInt(formatTime) === 12 ? true : false;
				formatTimeString(timeInput);
				timeInput.clockpicker(params);
			});
		},

		registerDatePicker: function () {
			$('input.datepicker').datepicker({
				todayBtn: 'linked',
				clearBtn: true,
				autoclose: true,
				todayHighlight: false,
				enableOnReadonly: false
			});
		},
		registerDateField: function (container) {
			var thisInstance = this;
			if (typeof container === 'undefined') {
				container = jQuery('body');
			}
			if (typeof params === 'undefined') {
				params = {};
			}
			var dateFieldElements = jQuery('.dateField', container);
			params.width = '100%';
			params.singleDatePicker = true;
			params.showDropdowns = true;
			params.linkedCalendars = false;
			params.autoApply = true;
			params.autoUpdateInput = false;
			params.locale = {};
			params.locale.format = 'YYYY-MM-DD';
			params.locale.daysOfWeek = [
				app.translate('JS_DATE_WEEK_DAY_SHORT_SUNDAY'),
				app.translate('JS_DATE_WEEK_DAY_SHORT_MONDAY'),
				app.translate('JS_DATE_WEEK_DAY_SHORT_TUESDAY'),
				app.translate('JS_DATE_WEEK_DAY_SHORT_WEDNESDAY'),
				app.translate('JS_DATE_WEEK_DAY_SHORT_THURSDAY'),
				app.translate('JS_DATE_WEEK_DAY_SHORT_FRIDAY'),
				app.translate('JS_DATE_WEEK_DAY_SHORT_SATURDAY')
			];
			params.locale.monthNames = [
				app.translate('JS_DATE_MONTH_JANUARY'),
				app.translate('JS_DATE_MONTH_FEBRUARY'),
				app.translate('JS_DATE_MONTH_MARCH'),
				app.translate('JS_DATE_MONTH_APRIL'),
				app.translate('JS_DATE_MONTH_MAY'),
				app.translate('JS_DATE_MONTH_JUNE'),
				app.translate('JS_DATE_MONTH_JULY'),
				app.translate('JS_DATE_MONTH_AUGUST'),
				app.translate('JS_DATE_MONTH_SEPTEMBER'),
				app.translate('JS_DATE_MONTH_OCTOBER'),
				app.translate('JS_DATE_MONTH_NOVEMBER'),
				app.translate('JS_DATE_MONTH_DECEMBER')
			];

			dateFieldElements.each(function () {
				var element = $(this);
				var input = element.find('.dateFieldInput');
				var button = element.find('.dateFieldButton');
				if (!input.attr('id')) {
					input.attr(
						'id',
						'dateFieldInput' +
							thisInstance.generateRandomChar() +
							thisInstance.generateRandomChar() +
							thisInstance.generateRandomChar()
					);
				}
				var params_custom = params;
				var fieldInfo = app.parseFieldInfo(input.attr('data-fieldinfo'));
				if (fieldInfo['date-format-js2']) {
					params_custom.locale.format = fieldInfo['date-format-js2'];
				}
				if (fieldInfo['day-of-the-week-int']) {
					params_custom.locale.firstDay = fieldInfo['day-of-the-week-int'];
				}
				input.daterangepicker(params_custom);
				button.click(function () {
					input.focus();
				});
				input.on('apply.daterangepicker', function (ev, picker) {
					$(this).val(picker.startDate.format(params_custom.locale.format));
				});
			});
		},
		registerChznSelectField: function (parent, view, params) {
			var thisInstance = this;
			if (typeof parent == 'undefined') {
				parent = jQuery('body');
			}
			if (typeof params == 'undefined') {
				params = {};
			}
			var selectElement = jQuery('.chzn-select', parent);
			selectElement.each(function () {
				if ($(this).prop('id').length == 0) {
					$(this).attr(
						'id',
						'sel' +
							thisInstance.generateRandomChar() +
							thisInstance.generateRandomChar() +
							thisInstance.generateRandomChar()
					);
				}
			});
			selectElement
				.filter('[multiple]')
				.filter('[data-validation-engine*="validate"]')
				.on('change', function (e) {
					jQuery(e.currentTarget).trigger('focusout');
				});

			var params = {
				no_results_text: app.translate('JS_NO_RESULTS_FOUND') + ':'
			};

			var moduleName = app.getModuleName();
			if (selectElement.filter('[multiple]')) {
				params.placeholder_text_multiple = ' ' + app.translate('JS_SELECT_SOME_OPTIONS');
			}
			params.placeholder_text_single = ' ' + app.translate('JS_SELECT_AN_OPTION');
			selectElement.chosen(params);

			selectElement.each(function () {
				var select = $(this);
				// hide selected items in the chosen instance when item is hidden.
				if (select.hasClass('hideSelected')) {
					var ns = [];
					select.find('optgroup,option').each(function (n, e) {
						if (jQuery(this).hasClass('d-none')) {
							ns.push(n);
						}
					});
					if (ns.length) {
						select
							.next()
							.find('.search-choice-close')
							.each(function (n, e) {
								var element = jQuery(this);
								var index = element.data('option-array-index');
								if (jQuery.inArray(index, ns) != -1) {
									element.closest('li').remove();
								}
							});
					}
				}
				if (select.attr('readonly') == 'readonly') {
					select.on('chosen:updated', function () {
						if (select.attr('readonly')) {
							var wasDisabled = select.is(':disabled');
							var selectData = select.data('chosen');
							select.attr('disabled', 'disabled');
							if (typeof selectData == 'object') {
								selectData.search_field_disabled();
							}
							if (wasDisabled) {
								select.attr('disabled', 'disabled');
							} else {
								select.removeAttr('disabled');
							}
						}
					});
					select.trigger('chosen:updated');
				}
			});

			// Improve the display of default text (placeholder)
			var chosenSelectConainer = jQuery('.chosen-container-multi .default').css('width', '100%');
			return chosenSelectConainer;
		},
		registerSelect2Field: function (parent, params) {
			var thisInstance = this;
			if (typeof parent == 'undefined') {
				parent = jQuery('body');
			}
			if (typeof params == 'undefined') {
				params = {};
			}
			var selectElement = jQuery('.select2', parent);
			params.language = {};
			//params.theme = "bootstrap";
			params.width = '100%';
			selectElement.each(function () {
				if ($(this).prop('id').length == 0) {
					$(this).attr(
						'id',
						'sel' +
							thisInstance.generateRandomChar() +
							thisInstance.generateRandomChar() +
							thisInstance.generateRandomChar()
					);
				}
				$(this).select2(params);
			});
		},
		getUrlParam: function (name) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === name) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
		},
		generateRandomChar: function () {
			var chars, newchar, rand;
			chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ';
			rand = Math.floor(Math.random() * chars.length);
			return (newchar = chars.substring(rand, rand + 1));
		},
		registerSideLoading: function (body) {
			$(document).pjax('a[href]:not(.loadPage)', 'div.bodyContent');
			$(document).on('pjax:complete', function () {
				var pageController = app.getPageController();
				if (pageController) pageController.registerEvents();
			});
		},
		translate: function (key) {
			if (app.languageString[key] != undefined) {
				return app.languageString[key];
			} else {
				var strings = jQuery('#js_strings').text();
				if (strings != '') {
					app.languageString = JSON.parse(strings);
					if (key in app.languageString) {
						return app.languageString[key];
					}
				}
			}
			return key;
		},
		registerDataTables: function (table, options = {}) {
			if ($.fn.dataTable == undefined) {
				return false;
			}
			if (table.length == 0) {
				return false;
			}
			$.extend($.fn.dataTable.defaults, {
				language: {
					sLengthMenu: app.translate('JS_S_LENGTH_MENU'),
					sZeroRecords: app.translate('JS_NO_RESULTS_FOUND'),
					sInfo: app.translate('JS_S_INFO'),
					sInfoEmpty: app.translate('JS_S_INFO_EMPTY'),
					sSearch: app.translate('JS_SEARCH'),
					sEmptyTable: app.translate('JS_NO_RESULTS_FOUND'),
					sInfoFiltered: app.translate('JS_S_INFO_FILTERED'),
					sLoadingRecords: app.translate('JS_LOADING_OF_RECORDS'),
					sProcessing: app.translate('JS_LOADING_OF_RECORDS'),
					oPaginate: {
						sFirst: app.translate('JS_S_FIRST'),
						sPrevious: app.translate('JS_S_PREVIOUS'),
						sNext: app.translate('JS_S_NEXT'),
						sLast: app.translate('JS_S_LAST')
					},
					oAria: {
						sSortAscending: app.translate('JS_S_SORT_ASCENDING'),
						sSortDescending: app.translate('JS_S_SORT_DESCENDING')
					}
				}
			});
			return table.DataTable(options);
		},
		getMainParams: function (param, json) {
			if (app.cacheParams[param] == undefined) {
				var value = $('#' + param).val();
				app.cacheParams[param] = value;
			}
			var value = app.cacheParams[param];
			if (json) {
				if (value != '') {
					value = $.parseJSON(value);
				} else {
					value = [];
				}
			}
			return value;
		},
		setMainParams: function (param, value) {
			app.cacheParams[param] = value;
			$('#' + param).val(value);
		},
		registerModal: function (container) {
			if (typeof container === 'undefined') {
				container = $('body');
			}
			container.off('click', '.js-show-modal').on('click', '.js-show-modal', function (e) {
				e.preventDefault();
				var currentElement = $(e.currentTarget);
				var url = currentElement.data('url');

				if (typeof url !== 'undefined') {
					if (currentElement.hasClass('js-popover-tooltip')) {
						currentElement.popover('hide');
					}
					if (currentElement.hasClass('disabledOnClick')) {
						currentElement.attr('disabled', true);
					}
					var modalWindowParams = {
						url: url,
						cb: function (container) {
							var call = currentElement.data('cb');
							if (typeof call !== 'undefined') {
								if (call.indexOf('.') !== -1) {
									var callerArray = call.split('.');
									if (typeof window[callerArray[0]] === 'object') {
										window[callerArray[0]][callerArray[1]](container);
									}
								} else {
									if (typeof window[call] === 'function') {
										window[call](container);
									}
								}
							}
							currentElement.removeAttr('disabled');
						}
					};
					if (currentElement.data('modalid')) {
						modalWindowParams['id'] = currentElement.data('modalid');
					}
					app.showModalWindow(modalWindowParams);
				}
				e.stopPropagation();
			});
		},

		/**
		 * Show modal
		 * @param {string} data
		 * @param {object} container
		 * @param {object} paramsObject
		 * @param {function} cb
		 * @param {string} url
		 * @param {function} sendByAjaxCb
		 */
		showModalData(data, container, paramsObject, cb, url, sendByAjaxCb) {
			const thisInstance = this;
			let params = {
				show: true
			};
			if ($('#backgroundClosingModal').val() !== 1) {
				params.backdrop = true;
			}
			if (typeof paramsObject === 'object') {
				container.css(paramsObject);
				params = $.extend(params, paramsObject);
			}
			container.html(data);
			if (container.find('.modal').hasClass('static')) {
				params.backdrop = 'static';
			}
			// In a modal dialog elements can be specified which can receive focus even though they are not descendants of the modal dialog.
			$.fn.modal.Constructor.prototype.enforceFocus = function (e) {
				$(document)
					.off('focusin.bs.modal') // guard against infinite focus loop
					.on(
						'focusin.bs.modal',
						$.proxy(function (e) {
							if ($(e.target).hasClass('select2-search__field')) {
								return true;
							}
						}, this)
					);
			};
			const modalContainer = container.find('.modal:first');
			modalContainer.one('shown.bs.modal', function () {
				var backdrop = jQuery('.modal-backdrop');
				if (backdrop.length > 1) {
					jQuery('.modal-backdrop:not(:first)').remove();
				}
				cb(modalContainer);
			});
			$('body').append(container);
			modalContainer.modal(params);
			thisInstance.registerModalEvents(modalContainer, sendByAjaxCb);
			thisInstance.registerDataTables(modalContainer.find('.dataTable'));
		},

		/**
		 * Register modal events.
		 * @param {object} container
		 * @param {function} sendByAjaxCb
		 */
		registerModalEvents: function (container, sendByAjaxCb) {
			var form = container.find('form');
			var validationForm = false;
			if (form.hasClass('validateForm')) {
				form.validationEngine(app.validationEngineOptions);
				validationForm = true;
			}
			if (form.hasClass('sendByAjax')) {
				form.on('submit', function (e) {
					var save = true;
					e.preventDefault();
					if (validationForm && form.data('jqv').InvalidFields.length > 0) {
						app.formAlignmentAfterValidation(form);
						save = false;
					}
					if (save) {
						var progressIndicatorElement = $.progressIndicator({
							blockInfo: { enabled: true }
						});
						var formData = form.serializeFormData();
						AppConnector.request(formData)
							.done(function (responseData) {
								sendByAjaxCb(formData, responseData);
								if (responseData.success && responseData.result) {
									if (responseData.result.notify) {
										Vtiger_Helper_Js.showMessage(responseData.result.notify);
									}
									if (responseData.result.procesStop) {
										progressIndicatorElement.progressIndicator({ mode: 'hide' });
										return false;
									}
								}
								app.hideModalWindow();
								progressIndicatorElement.progressIndicator({ mode: 'hide' });
							})
							.fail(function () {
								progressIndicatorElement.progressIndicator({ mode: 'hide' });
							});
					}
				});
			}
		},

		/**
		 * Show modal window.
		 * @param {object} data
		 * @param {string} url
		 * @param {function} cb
		 * @param {object} paramsObject
		 *
		 * @return {object}
		 */
		showModalWindow: function (data, url, cb, paramsObject) {
			if (window.parent !== window) {
				this.childFrame = true;
				window.parent.app.showModalWindow(data, url, cb, paramsObject);
				return;
			}
			const thisInstance = this;
			Window.lastModalId = 'modal_' + Math.random().toString(36).substr(2, 9);
			//null is also an object
			if (typeof data === 'object' && data != null && !(data instanceof $)) {
				if (data.id != undefined) {
					Window.lastModalId = data.id;
				}
				paramsObject = data.css;
				cb = data.cb;
				url = data.url;
				if (data.sendByAjaxCb !== 'undefined') {
					var sendByAjaxCb = data.sendByAjaxCb;
				}
				data = data.data;
			}
			if (typeof url === 'function') {
				if (typeof cb === 'object') {
					paramsObject = cb;
				}
				cb = url;
				url = false;
			} else if (typeof url === 'object') {
				cb = function () {};
				paramsObject = url;
				url = false;
			}
			if (typeof cb !== 'function') {
				cb = function () {};
			}
			if (typeof sendByAjaxCb !== 'function') {
				var sendByAjaxCb = function () {};
			}
			if (paramsObject !== undefined && paramsObject.modalId !== undefined) {
				Window.lastModalId = paramsObject.modalId;
			}
			// prevent duplicate hash generation
			let container = $('#' + Window.lastModalId);
			if (container.length) {
				container.remove();
			}
			container = $('<div></div>');
			container.attr('id', Window.lastModalId).addClass('modalContainer js-modal-container');
			container.one('hidden.bs.modal', function () {
				container.remove();
				let backdrop = $('.modal-backdrop');
				let modalContainers = $('.modalContainer');
				if (modalContainers.length == 0 && backdrop.length) {
					backdrop.remove();
				}
				if (backdrop.length > 0) {
					$('body').addClass('modal-open');
				}
			});
			if (data) {
				thisInstance.showModalData(data, container, paramsObject, cb, url, sendByAjaxCb);
			} else {
				$.get(url).done(function (response) {
					thisInstance.showModalData(response, container, paramsObject, cb, url, sendByAjaxCb);
				});
			}
			return container;
		},
		hideModalWindow: function (callback, id) {
			if (id == undefined) {
				id = 'globalmodal';
			}
			var container = jQuery('#' + id);
			if (container.length <= 0) {
				return;
			}
			if (typeof callback != 'function') {
				callback = function () {};
			}
			var modalContainer = container.find('.modal');
			modalContainer.modal('hide');
			var backdrop = jQuery('.modal-backdrop:last');
			var modalContainers = jQuery('.modalContainer');
			if (modalContainers.length == 0 && backdrop.length) {
				backdrop.remove();
			}
			modalContainer.one('hidden.bs.modal', callback);
		},
		registerAdditions: function ($) {
			$.fn.serializeFormData = function () {
				var form = $(this);
				var values = form.serializeArray();
				var data = {};
				if (values) {
					$(values).each(function (k, v) {
						if (v.name in data && typeof data[v.name] != 'object') {
							var element = form.find('[name="' + v.name + '"]');
							//Only for muti select element we need to send array of values
							if (element.is('select') && element.attr('multiple') != undefined) {
								var prevValue = data[v.name];
								data[v.name] = new Array();
								data[v.name].push(prevValue);
							}
						}
						if (typeof data[v.name] == 'object') {
							data[v.name].push(v.value);
						} else {
							data[v.name] = v.value;
						}
					});
				}
				// If data-type="autocomplete", pickup data-value="..." set
				var autocompletes = $('[data-type="autocomplete"]', $(this));
				$(autocompletes).each(function (i) {
					var ac = $(autocompletes[i]);
					data[ac.attr('name')] = ac.data('value');
				});
				return data;
			};
		},
		/**
		 * Function to push down the error message size when validation is invoked
		 * @params : form Element
		 */
		formAlignmentAfterValidation: function (form) {
			// to avoid hiding of error message under the fixed nav bar
			var formError = form.find(".formError:not('.greenPopup'):first");
			if (formError.length > 0) {
				var destination = formError.offset().top;
				var resizedDestnation = destination - 105;
				jQuery('html').animate(
					{
						scrollTop: resizedDestnation
					},
					'slow'
				);
			}
		},
		getRecordList: function (params, callback) {
			app.showModalWindow(null, params, function () {
				app.event.one('AfterSelectedRecordList', function (event, item) {
					callback(item);
				});
			});
		},
		/**
		 * Open url in top window
		 * @param string url
		 */
		openUrl(url) {
			if (window.location !== window.top.location) {
				window.top.location.href = url;
			} else {
				window.location.href = url;
			}
		},
		openUrlMethodPost(url, postData) {
			let formHtml = '<form action="' + url + '" method="post">';
			$.each(postData, (index, value) => {
				formHtml += '<input type="text" name="' + index + '" value="' + value + '" />';
			});
			formHtml += '</form>';
			let form = $(formHtml);
			$('body').append(form);
			form.submit();
		},
		registerMobileMenu: function (container) {
			$('.js-sidebar-btn').on('click', (e) => {
				let mobileMenu = container.find('.js-mobile-page');
				let mobileMenuContent = container.find('.js-mobile-body');
				if (mobileMenu.hasClass('c-menu-mobile')) {
					mobileMenu.removeClass('c-menu-mobile');
					mobileMenuContent.removeClass('c-menu-mobile__content');
				} else {
					mobileMenu.addClass('c-menu-mobile');
					mobileMenuContent.addClass('c-menu-mobile__content');
				}
			});
		},

		errorLog(error, err, errorThrown) {
			if (false) {
				return;
			}
			console.warn(
				'%cYetiForce debug mode!!!',
				'color: red; font-family: sans-serif; font-size: 1.5em; font-weight: bolder; text-shadow: #000 1px 1px;'
			);
			if (typeof error === 'object' && error.responseText) {
				error = error.responseText;
			}
			if (typeof error === 'object' && error.statusText) {
				error = error.statusText;
			}
			if (error) {
				console.error(error);
			}
			if (err && err !== 'error') {
				console.error(err);
			}
			if (errorThrown) {
				console.error(errorThrown);
			}
		},
		registerModalController: function (modalId, modalContainer, cb) {
			let windowParent = this.childFrame ? window.parent : window;
			if (!modalId) {
				modalId = Window.lastModalId;
			}
			if (!modalContainer) {
				modalContainer = $('#' + modalId + ' .js-modal-data');
			}
			let moduleName = modalContainer.data('module') || 'Base';
			let modalClass = moduleName.replace(':', '_') + '_' + modalContainer.data('view') + '_JS';
			if (typeof windowParent[modalClass] === 'undefined') {
				modalClass = 'Base_' + modalContainer.data('view') + '_JS';
			}
			if (typeof windowParent[modalClass] !== 'undefined') {
				let instance = new windowParent[modalClass]();
				if (typeof cb === 'function') {
					cb(modalContainer, instance);
				}
				instance.registerEvents(modalContainer);
			}
		},
		registerSubMenu: function () {
			$('.js-submenu-toggler').on('click', (e) => {
				if (!$(e.currentTarget).hasClass('collapsed') && !$(e.target).closest('.toggler').length) {
					window.location = $(e.currentTarget).attr('href');
				}
			});
		},

		showNotify: function (customParams) {
			let params = {
				hide: false
			};
			let userParams = customParams;
			let type = 'info';
			if (typeof customParams === 'string') {
				userParams = {
					title: customParams
				};
			}
			if (typeof customParams.type !== 'undefined') {
				type = customParams.type;
			}
			if (type !== 'error') {
				params.hide = true;
			}
			return PNotify[type]($.extend(params, userParams));
		},

		/**
		 * Set Pnotify defaults options
		 */
		setPnotifyDefaultOptions() {
			PNotify.defaults.textTrusted = true; // *Trusted option enables html as parameter's value
			PNotify.defaults.titleTrusted = true;
			PNotify.defaults.sticker = false;
			PNotify.defaults.styling = 'bootstrap4';
			PNotify.defaults.icons = 'fontawesome5';
			PNotify.defaults.delay = 3000;
			PNotify.defaults.stack.maxOpen = 10;
			PNotify.defaults.stack.spacing1 = 5;
			PNotify.defaults.stack.spacing2 = 5;
			//PNotify.defaults.labels.close = app.vtranslate('JS_CLOSE');
			PNotify.defaultModules.set(PNotifyBootstrap4, {});
			PNotify.defaultModules.set(PNotifyFontAwesome5, {});
			PNotify.defaultModules.set(PNotifyMobile, {});
		},
		registerIframeAndMoreContent() {
			let showMoreModal = (e) => {
				e.preventDefault();
				e.stopPropagation();
				const btn = $(e.currentTarget);
				const message = btn.data('iframe')
					? btn.siblings('iframe').clone().show()
					: btn.closest('.js-more-content').find('.fullContent').html();
				bootbox.dialog({
					message,
					title: '<span class="mdi mdi-overscan"></span>  ' + app.translate('JS_FULL_TEXT'),
					className: 'u-word-break modal-fullscreen',
					buttons: {
						danger: {
							label: '<span class="fas fa-times mr-1"></span>' + app.translate('JS_CLOSE'),
							className: 'btn-danger',
							callback: function () {}
						}
					}
				});
			};
			$('.js-more').on('click', showMoreModal);
			$(document).on('click', '.js-more', showMoreModal);
		}
	};
$(function () {
	var container = jQuery('body');
	app.registerSelectField(container);
	app.registerDatePicker();
	app.setPnotifyDefaultOptions();
	app.registerDateField(container);
	app.registerTimeField(container);
	app.registerAdditions(jQuery);
	app.registerSubMenu();
	app.registerModal(container);
	app.registerMobileMenu(container);
	app.registerIframeAndMoreContent();
	//	app.registerSideLoading(container);
	// Instantiate Page Controller
	var pageController = app.getPageController();
	if (pageController) pageController.registerEvents();
});
