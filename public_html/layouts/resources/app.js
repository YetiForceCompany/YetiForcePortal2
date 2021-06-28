/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
var App = (window.App = {
	Components: {
		QuickCreate: {
			/**
			 * module quick create data cache
			 */
			moduleCache: {},
			/**
			 * Register function
			 */
			register() {
				$('body').on('click', '.js-quick-create', (e) => {
					let element = $(e.currentTarget);
					if (element.data('moduleName')) {
						App.Components.QuickCreate.createRecord(element.data('moduleName'));
					}
					if (element.data('url')) {
						let url = element.data('url');
						const progress = $.progressIndicator({ blockInfo: { enabled: true } });
						App.Components.QuickCreate.getForm(url).done((data) => {
							progress.progressIndicator({
								mode: 'hide'
							});
							App.Components.QuickCreate.showModal(data);
						});
					}
				});
			},
			/**
			 * Create record
			 *
			 * @param   {string}  moduleName
			 * @param   {object}  params
			 */
			createRecord(moduleName, params = {}) {
				let url = 'index.php?module=' + moduleName + '&view=QuickCreateModal';
				if (
					app.getViewName() === 'DetailView' ||
					(app.getViewName() === 'EditView' && app.getRecordId() !== undefined)
				) {
					url += '&sourceModule=' + app.getModuleName();
					url += '&sourceRecord=' + app.getRecordId();
				}
				const progress = $.progressIndicator({ blockInfo: { enabled: true } });
				this.getForm(url, params).done((data) => {
					progress.progressIndicator({
						mode: 'hide'
					});
					this.showModal(data, params);
				});
			},
			/**
			 * Get quick create form
			 *
			 * @param   {string}  url
			 * @param   {object}  params
			 *
			 * @return  {Promise} aDeferred
			 */
			getForm(url, params = {}) {
				const aDeferred = $.Deferred();
				let requestParams;
				requestParams = url;
				if (typeof params.data !== 'undefined') {
					requestParams = {};
					requestParams['data'] = params.data;
					requestParams['url'] = url;
				}
				AppConnector.request(requestParams).done(function (data) {
					aDeferred.resolve(data);
				});
				return aDeferred.promise();
			},
			/**
			 * Show modal
			 *
			 * @param   {string}  html
			 * @param   {object}  params
			 */
			showModal(html, params = {}) {
				const callbackAfterShownModal = params.callbackAfterShownModal || function () {};
				app.showModalWindow(html, (container, modalInstance) => {
					const callbackAfterSave = params.callbackAfterSave || function () {};
					params.callbackAfterSave = (response) => {
						callbackAfterSave(response);
						app.hideModalWindow('', container.data('modalId'));
					};
					modalInstance.editView.registerSubmit(params);
					callbackAfterShownModal(container);
					callbackAfterShownModal(container);
					container.on('click', '.js-edit-back', () => {
						app.hideModalWindow('', container.data('modalId'));
					});
				});
			}
		}
	}
});
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
		modalInstances: [],
		modalParams: [],
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
		 * Function returns the record id
		 */
		getRecordId: function () {
			let recordId;
			if ($.inArray(this.getViewName(), ['EditView', 'DetailView']) !== -1) {
				recordId = this.getMainParams('recordId');
			}
			return recordId;
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
			$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
				if (settings.jqXHR.responseJSON.error.message) {
					alert(settings.jqXHR.statusText + '\r\n' + settings.jqXHR.responseJSON.error.message);
					console.error(settings.jqXHR.responseJSON.error);
				} else {
					console.error(settings.jqXHR.responseJSON);
				}
			};
			$.extend($.fn.dataTable.defaults, {
				fixedHeader: true,
				dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
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

		/**
		 * Function to register event for ckeditor for description field
		 *
		 * @param {object} container
		 */
		registerBaseEvent(container) {
			container.on('click', '.js-history-back', () => {
				window.history.back();
			});
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
		/**
		 * Hide popover.
		 * @param {object} element
		 */
		hidePopover: function (element) {
			if (typeof element === 'undefined') {
				element = $('body .js-popover-tooltip');
			}
			element.popover('hide');
		},
		/**
		 * Hide popovers after click.
		 * @param {object} popoverParent
		 */
		hidePopoversAfterClick(popoverParent) {
			popoverParent.on('mousedown', (e) => {
				setTimeout(() => {
					popoverParent.popover('hide');
				}, 100);
			});
		},
		/**
		 * Register popover manual trigger.
		 * @param {object} element
		 * @param {integer} element
		 */
		registerPopoverManualTrigger(element, manualTriggerDelay) {
			const hideDelay = 500;
			element.on('mouseleave', (e) => {
				setTimeout(() => {
					let currentPopover = this.getBindedPopover(element);
					if (
						!$(':hover').filter(currentPopover).length &&
						!currentPopover.find('.js-popover-tooltip--record[aria-describedby]').length
					) {
						currentPopover.popover('hide');
					}
				}, hideDelay);
			});
			element.on('mouseenter', () => {
				setTimeout(() => {
					if (element.is(':hover')) {
						element.popover('show');
						let currentPopover = this.getBindedPopover(element);
						currentPopover.on('mouseleave', () => {
							setTimeout(() => {
								if (
									!$(':hover').filter(currentPopover).length &&
									!currentPopover.find('.js-popover-tooltip--record[aria-describedby]').length
								) {
									currentPopover.popover('hide'); //close current popover
								}
								if (!$(':hover').filter($('.popover')).length) {
									$('.popover').popover('hide'); //close all popovers
								}
							}, hideDelay);
						});
					}
				}, manualTriggerDelay);
			});
			app.hidePopoversAfterClick(element);
		},
		/**
		 * Register popover.
		 * @param {object} container
		 */
		registerPopover(container = $(document)) {
			window.popoverCache = {};
			container.on('mousemove', (e) => {
				app.mousePosition = { x: e.pageX, y: e.pageY };
			});
			container.on(
				'mouseenter',
				'.js-popover-tooltip, .js-popover-tooltip--record, .js-popover-tooltip--ellipsis, [data-field-type="reference"], [data-field-type="multireference"]',
				(e) => {
					let currentTarget = $(e.currentTarget);
					if (currentTarget.find('.js-popover-tooltip--record').length) {
						return;
					}
					if (!currentTarget.hasClass('popover-triggered')) {
						if (
							!currentTarget.hasClass('js-popover-tooltip--record') &&
							!currentTarget.find('.js-popover-tooltip--record').length &&
							!currentTarget.data('field-type')
						) {
							app.showPopoverElementView(currentTarget);
							currentTarget.trigger('mouseenter');
						}
					}
				}
			);
		},
		/**
		 * Show popover element view.
		 * @param {jQuery} element
		 * @param {object} params
		 * @param {HTMLElement}
		 */
		showPopoverElementView: function (selectElement = $('.js-popover-tooltip'), params = {}) {
			let defaultParams = {
				trigger: 'manual',
				manualTriggerDelay: 500,
				placement: 'auto',
				html: true,
				template:
					'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
				container: 'body',
				boundary: 'viewport',
				delay: { show: 300, hide: 100 }
			};
			selectElement.each(function (index, domElement) {
				let element = $(domElement);
				let elementParams = $.extend(true, defaultParams, params, element.data());
				if (element.data('class')) {
					elementParams.template =
						'<div class="popover ' +
						element.data('class') +
						'" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>';
				}
				if (element.hasClass('delay0')) {
					elementParams.delay = { show: 0, hide: 0 };
				}
				element.popover(elementParams);
				if (elementParams.trigger === 'manual' || typeof elementParams.trigger === 'undefined') {
					app.registerPopoverManualTrigger(element, elementParams.manualTriggerDelay);
				}
				if (elementParams.callbackShown) {
					element.on('shown.bs.popover', function (e) {
						elementParams.callbackShown(e);
					});
				}
				element.addClass('popover-triggered');
			});
			return selectElement;
		},
		/**
		 * Get binded popover
		 * @param {jQuery} element
		 * @returns {Mixed|jQuery|HTMLElement}
		 */
		getBindedPopover(element) {
			return $(`#${element.attr('aria-describedby')}`);
		},
		/**
		 * Register tabdrop manual trigger.
		 */
		registerTabdrop: function () {
			let tabs = $('.js-tabdrop');
			if (!tabs.length) return;
			let tab = tabs.find('> li');
			tab.each(function () {
				$(this).removeClass('d-none');
			});
			tabs.tabdrop({
				text: app.translate('JS_MORE')
			});
			let dropdown = tabs.find('> li.dropdown');
			dropdown.appendTo(tabs);
			tab.on('click', function (e) {
				setTimeout(function () {
					$(window).trigger('resize');
				}, 500);
			});
			$(window).trigger('resize');
		},
		registerModal: function (container) {
			if (typeof container === 'undefined') {
				container = $('body');
			}
			container.off('click', '.js-show-modal').on('click', '.js-show-modal', function (e) {
				e.preventDefault();
				let currentElement = $(e.currentTarget);
				let url = currentElement.data('url');
				if (typeof url !== 'undefined') {
					if (currentElement.hasClass('js-popover-tooltip')) {
						currentElement.popover('hide');
					}
					if (currentElement.hasClass('disabledOnClick')) {
						currentElement.attr('disabled', true);
					}
					let modalWindowParams = {
						url: url,
						currentTarget: currentElement,
						cb: function (modalContainer) {
							let call = currentElement.data('cb');
							if (typeof call !== 'undefined') {
								if (call.indexOf('.') !== -1) {
									let callerArray = call.split('.');
									if (typeof window[callerArray[0]] === 'object' || typeof window[callerArray[0]] === 'function') {
										window[callerArray[0]][callerArray[1]](modalContainer);
									}
								} else {
									if (typeof window[call] === 'function') {
										window[call](modalContainer);
									}
								}
							}
							currentElement.removeAttr('disabled');
						}
					};
					if (currentElement.data('modalId')) {
						modalWindowParams['id'] = currentElement.data('modalId');
					}
					app.showModalWindow(modalWindowParams);
				}
				e.stopPropagation();
			});
			container.off('click', '.js-show-modal-content').on('click', '.js-show-modal-content', function (e) {
				e.preventDefault();
				let currentElement = $(e.currentTarget);
				let content = currentElement.data('content');
				let title = '',
					modalClass = '';
				if (currentElement.data('title')) {
					title = currentElement.data('title');
				}
				if (currentElement.data('class')) {
					modalClass = currentElement.data('class');
				}
				app.showModalWindow(`<div class="modal" tabindex="-1" role="dialog"><div class="modal-dialog ${modalClass}" role="document"><div class="modal-content">
				<div class="modal-header"> <h5 class="modal-title">${title}</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div><div class="modal-body text-break">${content}</div></div></div></div>`);
				e.stopPropagation();
			});
		},

		/**
		 * Show modal
		 * @param {string} data
		 * @param {object} paramsObject
		 * @param {function} cb
		 * @param {string} url
		 * @param {function} sendByAjaxCb
		 */
		showModalData(data, paramsObject, cb, url, sendByAjaxCb) {
			$(data).each((i, e) => {
				let id = $(e).data('modalId');
				if (id) {
					window.lastModalId = id;
				}
			});
			const modalId = window.lastModalId;
			// prevent duplicate hash generation
			let container = $('#' + modalId);
			if (container.length) {
				container.remove();
			}
			container = $('<div></div>');
			container.attr('id', modalId).addClass('modalContainer js-modal-container');
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
			this.modalParams[modalId] = paramsObject;
			let params = {
				show: true
			};
			if ($('#backgroundClosingModal').val() !== 1) {
				params.backdrop = true;
			}
			if (typeof paramsObject === 'object') {
				if (paramsObject['css']) {
					container.css(paramsObject['css']);
				}
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
			modalContainer.one('shown.bs.modal', () => {
				let backdrop = jQuery('.modal-backdrop');
				if (backdrop.length > 1) {
					jQuery('.modal-backdrop:not(:first)').remove();
				}
				modalContainer.find('.modal-dialog').draggable({
					handle: '.modal-title'
				});
				modalContainer.find('.modal-title').css('cursor', 'move');
				let instance;
				if (this.modalInstances[modalId]) {
					instance = this.modalInstances[modalId];
				}
				app.registerFieldsEvents(container);
				this.registerDataTables(modalContainer.find('.dataTable'));
				cb(modalContainer, instance, paramsObject);
			});
			$('body').append(container);
			modalContainer.modal(params);
			this.registerModalEvents(modalContainer, sendByAjaxCb);
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
										app.showNotify({
											text: responseData.result.notify,
											type: 'success'
										});
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
		showModalWindow: function (data, url, cb, paramsObject = {}) {
			if (window.parent !== window) {
				this.childFrame = true;
				window.parent.app.showModalWindow(data, url, cb, paramsObject);
				return;
			}
			window.lastModalId = 'modal_' + Math.random().toString(36).substr(2, 9);
			//null is also an object
			if (typeof data === 'object' && data != null && !(data instanceof $)) {
				if (data.id != undefined) {
					window.lastModalId = data.id;
				}
				cb = data.cb;
				url = data.url;
				if (data.sendByAjaxCb !== 'undefined') {
					var sendByAjaxCb = data.sendByAjaxCb;
					delete data.sendByAjaxCb;
				}
				paramsObject = data;
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
				window.lastModalId = paramsObject.modalId;
			}
			if (data) {
				this.showModalData(data, paramsObject, cb, url, sendByAjaxCb);
			} else {
				$.get(url).done((response) => {
					this.showModalData(response, paramsObject, cb, url, sendByAjaxCb);
				});
			}
		},
		registerModalController: function (modalId, modalContainer, cb) {
			let windowParent = this.childFrame ? window.parent : window;
			if (!modalId) {
				modalId = window.lastModalId;
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
				let instance = new windowParent[modalClass](),
					params;
				if (typeof cb === 'function') {
					cb(modalContainer, instance);
				}
				if (this.modalParams[modalId]) {
					params = this.modalParams[modalId];
				}
				instance.registerEvents(modalContainer, params);
				this.modalInstances[modalId] = instance;
			}
		},
		/**
		 * Function which you can use to hide the modal
		 *
		 *  @param {function} callback
		 *  @param {integer} id
		 */
		hideModalWindow: function (callback, id) {
			let container;
			if (callback && typeof callback === 'object') {
				container = callback;
			} else if (id == undefined) {
				container = $('.modalContainer');
			} else {
				container = $('#' + id);
			}
			if (container.length <= 0) {
				return;
			}
			if (typeof callback !== 'function') {
				callback = function () {};
			}
			let modalContainer = container.find('.modal');
			modalContainer.modal('hide');
			let backdrop = $('.modal-backdrop:last');
			if ($('.modalContainer').length == 0 && backdrop.length) {
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
		registerSubMenu: function () {
			$('.js-submenu-toggler').on('click', (e) => {
				if (!$(e.currentTarget).hasClass('collapsed') && !$(e.target).closest('.toggler').length) {
					window.location = $(e.currentTarget).attr('href');
				}
			});
		},

		showNotifyConfirm: function (customParams, confirmFn, cancelFn) {
			let params = {
				title: '???',
				icon: 'fas fa-question-circle',
				hide: false,
				closer: false,
				sticker: false,
				destroy: true,
				stack: new PNotify.Stack({
					dir1: 'down',
					modal: true,
					firstpos1: 25,
					overlayClose: false
				}),
				modules: new Map([
					...PNotify.defaultModules,
					[
						PNotifyConfirm,
						{
							confirm: true,
							align: 'center'
						}
					]
				])
			};

			let notice = PNotify.info($.extend(params, customParams));
			if (typeof confirmFn === 'function') {
				notice.on('pnotify:confirm', confirmFn);
			}
			if (typeof cancelFn === 'function') {
				notice.on('pnotify:cancel', cancelFn);
			}
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
		setNotifyDefaultOptions() {
			PNotify.defaults.textTrusted = true; // *Trusted option enables html as parameter's value
			PNotify.defaults.titleTrusted = true;
			PNotify.defaults.sticker = false;
			PNotify.defaults.styling = 'bootstrap4';
			PNotify.defaults.icons = 'fontawesome5';
			PNotify.defaults.delay = 3000;
			PNotify.defaults.stack.maxOpen = 10;
			PNotify.defaults.stack.spacing1 = 5;
			PNotify.defaults.stack.spacing2 = 5;
			PNotify.defaults.labels.close = app.translate('JS_CLOSE');
			PNotify.defaultModules.set(PNotifyBootstrap4, {});
			PNotify.defaultModules.set(PNotifyFontAwesome5, {});
			PNotify.defaultModules.set(PNotifyMobile, {});
			PNotifyConfirm.defaults.buttons = [
				{
					text: app.translate('JS_YES'),
					addClass: 'btn-success',
					primary: true,
					promptTrigger: true,
					click: (notice, value) => {
						notice.close();
						notice.fire('pnotify:confirm', { notice, value });
					}
				},
				{
					text: app.translate('JS_NO'),
					addClass: 'btn-warning',
					click: (notice) => {
						notice.close();
						notice.fire('pnotify:cancel', { notice });
					}
				}
			];
			if (typeof window.stackContextModal === 'undefined') {
				window.stackPage = new PNotify.Stack({
					dir1: 'down',
					firstpos1: 25,
					context: document.getElementById('page'),
					modal: true,
					maxOpen: Infinity
				});
			}
			if (typeof window.stackContextModal === 'undefined') {
				window.stackPage = new PNotify.Stack({
					dir1: 'down',
					firstpos1: 25,
					context: document.getElementById('page'),
					modal: true,
					maxOpen: Infinity
				});
			}
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
		},
		processEvents: false,
		registerAfterLoginEvents: function () {
			if (this.processEvents === false) {
				let processEvents = $('#processEvents');
				if (processEvents.length === 0) {
					return;
				}
				this.processEvents = JSON.parse(processEvents.val());
			}
			if (this.processEvents.length === 0) {
				return;
			}
			let event = this.processEvents.shift();
			switch (event.type) {
				case 'modal':
					AppConnector.request(event.url)
						.done(function (requestData) {
							app.showModalWindow(requestData).one('hidden.bs.modal', function () {
								app.registerAfterLoginEvents();
							});
						})
						.fail(function (textStatus, errorThrown) {
							app.showNotify({
								title: app.translate('JS_ERROR'),
								text: errorThrown,
								type: 'error'
							});
						});
					break;
				case 'notify':
					app.showNotify(event.notify);
					app.registerAfterLoginEvents();
					break;
				default:
					return;
			}
		},
		/**
		 * Convert object to url string
		 *
		 * @param   {object}  urlData
		 * @param   {string}  entryFile
		 *
		 * @return  {string}  url
		 */
		convertObjectToUrl(urlData = {}, entryFile = 'index.php?') {
			let url = entryFile;
			Object.keys(urlData).forEach((key, n) => {
				let value = urlData[key];
				if (typeof value === 'object' || (typeof value === 'string' && value.startsWith('<'))) {
					return;
				}
				if (url !== entryFile) {
					url += '&';
				}
				url += key + '=' + value;
			});
			return url;
		},
		/**
		 * Convert url string to object
		 * @param   {string}  url
		 * @return  {object}  urlObject
		 */
		convertUrlToObject(url) {
			let urlObject = {};
			if (url.indexOf('index.php?') !== -1) {
				url = url.split('index.php?')[1];
			}
			url.split('&').forEach((el) => {
				if (el.includes('=')) {
					let values = el.split('=');
					urlObject[values[0]] = values[1];
				}
			});
			return urlObject;
		},
		registerFieldsEvents: function (container) {
			this.registerSelectField(container);
			this.registerEventForClockPicker(container.find('.clockPicker'));
			App.Fields.Date.register(container);
			App.Fields.DateTime.register(container);
			App.Fields.Date.registerRange(container);
		}
	};
CKEDITOR.disableAutoInline = true;
$(function () {
	var container = $('body');
	app.registerFieldsEvents(container);
	app.setNotifyDefaultOptions();
	app.registerAdditions(jQuery);
	app.registerPopover();
	app.registerSubMenu();
	app.registerModal(container);
	app.registerMobileMenu(container);
	app.registerTabdrop();
	App.Components.QuickCreate.register();
	app.registerIframeAndMoreContent();
	app.registerBaseEvent(container);
	app.registerAfterLoginEvents(container);
	if ($('#fingerPrint').length && typeof DeviceUUID === 'function') {
		$('#fingerPrint').val(new DeviceUUID().get());
	}
	// Instantiate Page Controller
	var pageController = app.getPageController();
	if (pageController) pageController.registerEvents();
	if (typeof $.fn.datepicker.dates[app.getMainParams('langKey')] === 'undefined') {
		$.fn.datepicker.dates[app.getMainParams('langKey')] = {
			days: App.Fields.Date.fullDaysTranslated,
			daysShort: App.Fields.Date.daysTranslated,
			daysMin: App.Fields.Date.daysTranslated,
			months: App.Fields.Date.fullMonthsTranslated,
			monthsShort: App.Fields.Date.monthsTranslated,
			today: app.translate('JS_TODAY'),
			clear: app.translate('JS_CLEAR'),
			format: app.getMainParams('userDateFormat'),
			titleFormat: 'MM yyyy' /* Leverages same syntax as 'format' */,
			weekStart: app.getMainParams('firstDayOfWeekNo'),
			applyLabel: app.translate('JS_APPLY'),
			cancelLabel: app.translate('JS_CANCEL'),
			fromLabel: app.translate('JS_FROM'),
			toLabel: app.translate('JS_TO'),
			customRangeLabel: app.translate('JS_CUSTOM'),
			weekLabel: app.translate('JS_WEEK').substr(0, 1)
		};
	}
});
