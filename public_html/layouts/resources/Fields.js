/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

window.App.Fields = {
	Date: {
		months: [
			'JS_JAN',
			'JS_FEB',
			'JS_MAR',
			'JS_APR',
			'JS_MAY_SHORT',
			'JS_JUN',
			'JS_JUL',
			'JS_AUG',
			'JS_SEP',
			'JS_OCT',
			'JS_NOV',
			'JS_DEC'
		],
		monthsTranslated: [
			'JS_JAN',
			'JS_FEB',
			'JS_MAR',
			'JS_APR',
			'JS_MAY_SHORT',
			'JS_JUN',
			'JS_JUL',
			'JS_AUG',
			'JS_SEP',
			'JS_OCT',
			'JS_NOV',
			'JS_DEC'
		].map((monthName) => app.translate(monthName)),
		fullMonths: [
			'JS_JANUARY',
			'JS_FEBRUARY',
			'JS_MARCH',
			'JS_APRIL',
			'JS_MAY',
			'JS_JUNE',
			'JS_JULY',
			'JS_AUGUST',
			'JS_SEPTEMBER',
			'JS_OCTOBER',
			'JS_NOVEMBER',
			'JS_DECEMBER'
		],
		fullMonthsTranslated: [
			'JS_JANUARY',
			'JS_FEBRUARY',
			'JS_MARCH',
			'JS_APRIL',
			'JS_MAY',
			'JS_JUNE',
			'JS_JULY',
			'JS_AUGUST',
			'JS_SEPTEMBER',
			'JS_OCTOBER',
			'JS_NOVEMBER',
			'JS_DECEMBER'
		].map((monthName) => app.translate(monthName)),
		days: ['JS_SUN', 'JS_MON', 'JS_TUE', 'JS_WED', 'JS_THU', 'JS_FRI', 'JS_SAT'],
		daysTranslated: ['JS_SUN', 'JS_MON', 'JS_TUE', 'JS_WED', 'JS_THU', 'JS_FRI', 'JS_SAT'].map((monthName) =>
			app.translate(monthName)
		),
		fullDays: ['JS_SUNDAY', 'JS_MONDAY', 'JS_TUESDAY', 'JS_WEDNESDAY', 'JS_THURSDAY', 'JS_FRIDAY', 'JS_SATURDAY'],
		fullDaysTranslated: [
			'JS_SUNDAY',
			'JS_MONDAY',
			'JS_TUESDAY',
			'JS_WEDNESDAY',
			'JS_THURSDAY',
			'JS_FRIDAY',
			'JS_SATURDAY'
		].map((monthName) => app.translate(monthName)),

		/**
		 * Register DatePicker
		 * @param {$} parentElement
		 * @param {boolean} registerForAddon
		 * @param {object} customParams
		 */
		register(parentElement, registerForAddon, customParams, className = 'dateField') {
			if (typeof parentElement === 'undefined') {
				parentElement = $('body');
			} else {
				parentElement = $(parentElement);
			}
			if (typeof registerForAddon === 'undefined') {
				registerForAddon = true;
			}
			let elements = $('.' + className, parentElement);
			if (parentElement.hasClass(className)) {
				elements = parentElement;
			}
			if (elements.length === 0) {
				return;
			}
			if (registerForAddon === true) {
				const parentDateElem = elements.closest('.date');
				$('.js-date__btn', parentDateElem).on('click', function inputGroupAddonClickHandler(e) {
					// Using focus api of DOM instead of jQuery because show api of datePicker is calling e.preventDefault
					// which is stopping from getting focus to input element
					$(e.currentTarget)
						.closest('.date')
						.find('input.' + className)
						.get(0)
						.focus();
				});
			}
			let format = app.getMainParams('dateFormat');
			const elementDateFormat = elements.data('dateFormat');
			if (typeof elementDateFormat !== 'undefined') {
				format = elementDateFormat;
			}
			let params = {
				todayBtn: 'linked',
				clearBtn: true,
				language: app.getMainParams('langKey'),
				weekStart: app.getMainParams('firstDayOfWeekNo'),
				autoclose: true,
				todayHighlight: true,
				format: format
			};
			if (typeof customParams !== 'undefined') {
				params = $.extend(params, customParams);
			}
			elements.each((index, element) => {
				$(element).datepicker(
					$.extend(
						true,
						Object.assign(params, { enableOnReadonly: !element.hasAttribute('readonly') }),
						$(element).data('params')
					)
				);
			});
			return elements;
		},

		/**
		 * Register dateRangePicker
		 * @param {jQuery} parentElement
		 * @param {object} customParams
		 */
		registerRange(parentElement, customParams = {}) {
			if (typeof parentElement === 'undefined') {
				parentElement = $('body');
			} else {
				parentElement = $(parentElement);
			}
			let elements = $('.dateRangeField', parentElement);
			if (parentElement.hasClass('dateRangeField')) {
				elements = parentElement;
			}
			if (elements.length === 0) {
				return;
			}
			let format = app.getMainParams('userDateFormat').toUpperCase();
			const elementDateFormat = elements.data('dateFormat');
			if (typeof elementDateFormat !== 'undefined') {
				format = elementDateFormat.toUpperCase();
			}
			let ranges = {};
			ranges[app.translate('JS_TODAY')] = [moment(), moment()];
			ranges[app.translate('JS_TOMORROW')] = [moment().add(1, 'days'), moment().add(1, 'days')];
			ranges[app.translate('JS_YESTERDAY')] = [moment().subtract(1, 'days'), moment().subtract(1, 'days')];
			ranges[app.translate('JS_LAST_7_DAYS')] = [moment().subtract(6, 'days'), moment()];
			ranges[app.translate('JS_NEXT_7_DAYS')] = [moment(), moment().add(6, 'days')];
			ranges[app.translate('JS_CURRENT_MONTH')] = [moment().startOf('month'), moment().endOf('month')];
			ranges[app.translate('JS_NEXT_MONTH')] = [
				moment().add(1, 'month').startOf('month'),
				moment().add(1, 'month').endOf('month')
			];
			ranges[app.translate('JS_LAST_MONTH')] = [
				moment().subtract(1, 'month').startOf('month'),
				moment().subtract(1, 'month').endOf('month')
			];
			ranges[app.translate('JS_NEXT_MONTH')] = [
				moment().add(1, 'month').startOf('month'),
				moment().add(1, 'month').endOf('month')
			];
			ranges[app.translate('JS_LAST_3_MONTHS')] = [
				moment().subtract(3, 'month').startOf('month'),
				moment().subtract(1, 'month').endOf('month')
			];
			ranges[app.translate('JS_NEXT_3_MONTHS')] = [moment().startOf('month'), moment().add(3, 'month').endOf('month')];
			ranges[app.translate('JS_LAST_6_MONTHS')] = [
				moment().subtract(6, 'month').startOf('month'),
				moment().subtract(1, 'month').endOf('month')
			];
			ranges[app.translate('JS_NEXT_6_MONTHS')] = [moment().startOf('month'), moment().add(6, 'month').endOf('month')];
			let params = {
				autoUpdateInput: false,
				autoApply: true,
				ranges: ranges,
				locale: {
					format: format,
					separator: ',',
					applyLabel: app.translate('JS_APPLY'),
					cancelLabel: app.translate('JS_CANCEL'),
					fromLabel: app.translate('JS_FROM'),
					toLabel: app.translate('JS_TO'),
					customRangeLabel: app.translate('JS_CUSTOM'),
					weekLabel: app.translate('JS_WEEK').substr(0, 1),
				}
			};

			if (typeof customParams !== 'undefined') {
				params = $.extend(params, customParams);
			}
			parentElement
				.find('.js-date__btn')
				.off()
				.on('click', (e) => {
					$(e.currentTarget).parent().next('.dateRangeField')[0].focus();
				});
			elements.each((index, element) => {
				let el = $(element);
				let currentParams = $.extend(true, params, el.data('params'));
				el.daterangepicker(currentParams)
					.on('apply.daterangepicker', function (ev, picker) {
						$(this).val(
							picker.startDate.format(currentParams.locale.format) +
								',' +
								picker.endDate.format(currentParams.locale.format)
						);
						$(this).trigger('change');
					})
					.on('show.daterangepicker', (ev, picker) => {
						App.Fields.Utils.positionPicker(ev, picker);
					})
					.on('showCalendar.daterangepicker', (ev, picker) => {
						App.Fields.Utils.positionPicker(ev, picker);
						picker.container.addClass('js-visible');
					})
					.on('hide.daterangepicker', (ev, picker) => {
						picker.container.removeClass('js-visible');
					});
			});
		}
	},
	DateTime: class DateTime {
		constructor(container, params) {
			this.container = container;
			this.init(container, params);
		}
		/**
			* Register function
			* @param {jQuery} container
			* @param {Object} params
			*/
		static register(container, params) {
			if (typeof container === 'undefined') {
				container = $('body');
			}
			if (container.hasClass('dateTime') && !container.prop('disabled')) {
				return new DateTime(container);
			}
			const instances = [];
			container.find('.dateTime:not([disabled])').each((_, e) => {
				let element = $(e);
				instances.push(new DateTime(element, $.extend(params, element.data())));
			});
			return instances;
		}
		/**
		 * Initialization datetime
		 */
		init() {
			$('.input-group-text', this.container).on('click', function (e) {
				$(e.currentTarget).closest('.dateTime').find('input.dateTimePickerField').get(0).focus();
			});

			let dateFormat = app.getMainParams('userDateFormat').toUpperCase();
			const elementDateFormat = this.container.data('dateFormat');
			if (typeof elementDateFormat !== 'undefined') {
				dateFormat = elementDateFormat.toUpperCase();
			}
			let hourFormat = app.getMainParams('userTimeFormat');
			const elementHourFormat = this.container.data('hourFormat');
			if (typeof elementHourFormat !== 'undefined') {
				hourFormat = elementHourFormat;
			}
			let timePicker24Hour = true;
			let timeFormat = 'HH:mm';
			if (hourFormat != '24') {
				timePicker24Hour = false;
				timeFormat = 'hh:mm A';
			}
			const format = dateFormat + ' ' + timeFormat;
			let isDateRangePicker = this.container.data('calendarType') !== 'range';
			let params = {
				parentEl: this.container,
				singleDatePicker: isDateRangePicker,
				showDropdowns: true,
				timePicker: true,
				autoUpdateInput: false,
				timePicker24Hour: timePicker24Hour,
				timePickerIncrement: 1,
				autoApply: true,
				opens: 'left',
				locale: {
					format: format,
					separator: ','
				}
			};
			if (typeof customParams !== 'undefined') {
				params = $.extend(params, customParams);
			}
			this.container
				.daterangepicker(params)
				.on('apply.daterangepicker', function applyDateRangePickerHandler(ev, picker) {
					if (isDateRangePicker) {
						$(this).val(picker.startDate.format(format));
					} else {
						$(this).val(picker.startDate.format(format) + ',' + picker.endDate.format(format));
					}
				})
		}
	},

	Text: {
		Editor: class {
			constructor(container, params) {
				this.container = container;
				this.init(container, params);
			}
			/**
			 * Register function
			 * @param {jQuery} container
			 * @param {Object} params
			 */
			static register(container, params) {
				if (typeof container === 'undefined') {
					container = $('body');
				}
				if (container.hasClass('js-editor') && !container.prop('disabled')) {
					return new App.Fields.Text.Editor(container, $.extend(params, container.data()));
				}
				const instances = [];
				container.find('.js-editor:not([disabled])').each((_, e) => {
					let element = $(e);
					instances.push(new App.Fields.Text.Editor(element, $.extend(params, element.data())));
				});
				return instances;
			}
			/**
			 * Initiation
			 * @param {jQuery} element
			 * @param {Object} params
			 */
			init(element, params) {
				let config = {};
				if (element.hasClass('js-editor--basic')) {
					config.toolbar = 'Min';
				}
				if (element.data('height')) {
					config.height = element.data('height');
				}
				params = $.extend(config, params);
				this.isModal = element.closest('.js-modal-container').length;
				if (this.isModal) {
					let self = this;
					this.progressInstance = $.progressIndicator({
						blockInfo: {
							enabled: true,
							onBlock: () => {
								self.loadEditor(element, params);
							}
						}
					});
				} else {
					App.Fields.Text.destroyEditor(element);
					this.loadEditor(element, params);
				}
			}

			/*
			 *Function to set the textArea element
			 */
			setElement(element) {
				this.element = $(element);
				return this;
			}

			/*
			 *Function to get the textArea element
			 */
			getElement() {
				return this.element;
			}

			/*
			 * Function to return Element's id atrribute value
			 */
			getElementId() {
				return this.getElement().attr('id');
			}

			/*
			 * Function to get the instance of ckeditor
			 */
			getEditorInstanceFromName() {
				return CKEDITOR.instances[this.getElementId()];
			}

			/*
			 * Function to load CkEditor
			 * @param {HTMLElement|jQuery} element on which CkEditor has to be loaded
			 * @param {Object} customConfig custom configurations for ckeditor
			 */
			loadEditor(element, customConfig) {
				this.setElement(element);
				const instance = this.getEditorInstanceFromName(),
					self = this;
				let config = {
					language: CONFIG.langKey,
					allowedContent: true,
					disableNativeSpellChecker: false,
					extraAllowedContent: 'div{page-break-after*}',
					format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
					removeButtons: '',
					enterMode: CKEDITOR.ENTER_BR,
					shiftEnterMode: CKEDITOR.ENTER_P,
					emojiEnabled: false,
					mentionsEnabled: false,
					on: {
						instanceReady: function (evt) {
							evt.editor.on('blur', function () {
								evt.editor.updateElement();
							});
							if (self.isModal) {
								self.progressInstance.progressIndicator({ mode: 'hide' });
							}
						}
					},
					removePlugins: 'scayt',
					extraPlugins:
						'colorbutton,pagebreak,colordialog,find,selectall,showblocks,div,print,font,justify,bidi,ckeditor-image-to-base',
					toolbar: 'Full',
					toolbar_Full: [
						{
							name: 'clipboard',
							items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
						},
						{ name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
						{ name: 'links', items: ['Link', 'Unlink'] },
						{
							name: 'insert',
							items: ['ckeditor-image-to-base', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak']
						},
						{ name: 'tools', items: ['Maximize', 'ShowBlocks'] },
						{ name: 'paragraph', items: ['Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv'] },
						{ name: 'document', items: ['Source', 'Print'] },
						'/',
						{ name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
						{
							name: 'basicstyles',
							items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']
						},
						{ name: 'colors', items: ['TextColor', 'BGColor'] },
						{
							name: 'paragraph',
							items: [
								'NumberedList',
								'BulletedList',
								'-',
								'JustifyLeft',
								'JustifyCenter',
								'JustifyRight',
								'JustifyBlock',
								'-',
								'BidiLtr',
								'BidiRtl'
							]
						},
						{ name: 'basicstyles', items: ['CopyFormatting', 'RemoveFormat'] }
					],
					toolbar_Min: [
						{
							name: 'basicstyles',
							items: ['Bold', 'Italic', 'Underline', 'Strike']
						},
						{ name: 'colors', items: ['TextColor', 'BGColor'] },
						{ name: 'tools', items: ['Maximize'] },
						{
							name: 'paragraph',
							items: [
								'NumberedList',
								'BulletedList',
								'-',
								'JustifyLeft',
								'JustifyCenter',
								'JustifyRight',
								'JustifyBlock',
								'-',
								'BidiLtr',
								'BidiRtl'
							]
						},
						{ name: 'basicstyles', items: ['CopyFormatting', 'RemoveFormat', 'Source'] }
					],
					toolbar_Micro: [
						{
							name: 'basicstyles',
							items: ['Bold', 'Italic', 'Underline', 'Strike']
						},
						{ name: 'colors', items: ['TextColor', 'BGColor'] },
						{
							name: 'paragraph',
							items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
						},
						{ name: 'basicstyles', items: ['CopyFormatting', 'RemoveFormat'] }
					],
					toolbar_Clipboard: [
						{ name: 'document', items: ['Print'] },
						{ name: 'basicstyles', items: ['CopyFormatting', 'RemoveFormat'] },
						{
							name: 'clipboard',
							items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
						}
					],
					toolbar_PDF: [
						{
							name: 'clipboard',
							items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
						},
						{ name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-'] },
						{ name: 'links', items: ['Link', 'Unlink'] },
						{
							name: 'insert',
							items: ['ckeditor-image-to-base', 'Table', 'HorizontalRule', 'PageBreak']
						},
						{ name: 'tools', items: ['Maximize', 'ShowBlocks'] },
						{ name: 'document', items: ['Source'] },
						'/',
						{ name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
						{
							name: 'basicstyles',
							items: ['Bold', 'Italic', 'Underline', 'Strike']
						},
						{ name: 'colors', items: ['TextColor', 'BGColor'] },
						{
							name: 'paragraph',
							items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight']
						},
						{ name: 'basicstyles', items: ['CopyFormatting', 'RemoveFormat'] }
					]
				};
				if (typeof customConfig !== 'undefined') {
					config = $.extend(config, customConfig);
				}
				config = Object.assign(config, element.data());
				if (instance) {
					CKEDITOR.remove(instance);
				}
				element.ckeditor(config);
			}
		},

		/**
		 * Destroy ckEditor
		 * @param {jQuery} element
		 */
		destroyEditor(element) {
			if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && element.attr('id') in CKEDITOR.instances) {
				CKEDITOR.instances[element.attr('id')].destroy();
			}
		}
	},

	Picklist: {
		/**
		 * Function which will convert ui of select boxes.
		 * @params parent - select element
		 * @params view - select2
		 * @params viewParams - select2 params
		 * @returns jquery object list which represents changed select elements
		 */
		changeSelectElementView: function (parent, view, viewParams) {
			if (typeof parent === 'undefined') {
				parent = $('body');
			}
			if (typeof view === 'undefined') {
				const select2Elements = $('select.select2', parent).toArray();
				select2Elements.forEach((elem) => {
					this.changeSelectElementView($(elem), 'select2', viewParams);
				});
				return;
			}
			//If view is select2, This will convert the ui of select boxes to select2 elements.
			if (view === 'select2') {
				return App.Fields.Picklist.showSelect2ElementView(parent, viewParams);
			} else {
				app.errorLog(new Error(`Unknown select type [${view}]`));
			}
		},
		/**
		 * Function which will show the select2 element for select boxes . This will use select2 library
		 */
		showSelect2ElementView: function (selectElement, params) {
			let self = this;
			selectElement = $(selectElement);
			if (typeof params === 'undefined') {
				params = {};
			}
			if ($(selectElement).length > 1) {
				return $(selectElement).each((index, element) => {
					this.showSelect2ElementView($(element).eq(0), params);
				});
			}
			if (typeof params.dropdownParent === 'undefined') {
				const modalParent = $(selectElement).closest('.modal-body');
				if (modalParent.length) {
					params.dropdownParent = modalParent;
				}
			}
			let data = selectElement.data();
			if (data != null) {
				params = $.extend(data, params);
			}
			params.language = {};
			params.theme = 'bootstrap';
			const width = $(selectElement).data('width');
			if (typeof width !== 'undefined') {
				params.width = width;
			} else {
				params.width = '100%';
			}
			params.containerCssClass = 'form-control w-100';
			const containerCssClass = selectElement.data('containerCssClass');
			if (typeof containerCssClass !== 'undefined') {
				params.containerCssClass += ' ' + containerCssClass;
			}
			params.language.noResults = function (msn) {
				return app.translate('JS_NO_RESULTS_FOUND');
			};

			// Sort DOM nodes alphabetically in select box.
			if (typeof params['customSortOptGroup'] !== 'undefined' && params['customSortOptGroup']) {
				$('optgroup', selectElement).each(function () {
					var optgroup = $(this);
					var options = optgroup
						.children()
						.toArray()
						.sort(function (a, b) {
							var aText = $(a).text();
							var bText = $(b).text();
							return aText < bText ? 1 : -1;
						});
					$.each(options, function (i, v) {
						optgroup.prepend(v);
					});
				});
				delete params['customSortOptGroup'];
			}

			//formatSelectionTooBig param is not defined even it has the maximumSelectionLength,
			//then we should send our custom function for formatSelectionTooBig
			if (typeof params.maximumSelectionLength !== 'undefined' && typeof params.formatSelectionTooBig === 'undefined') {
				var limit = params.maximumSelectionLength;
				//custom function which will return the maximum selection size exceeds message.
				var formatSelectionExceeds = function (limit) {
					// return app.translate('JS_YOU_CAN_SELECT_ONLY') + ' ' + limit.maximum + ' ' + app.translate('JS_ITEMS');
				};
				params.language.maximumSelected = formatSelectionExceeds;
			}
			if (typeof selectElement.attr('multiple') !== 'undefined' && !params.placeholder) {
				//params.placeholder = app.translate('JS_SELECT_SOME_OPTIONS');
			} else if (!params.placeholder) {
				//params.placeholder = app.translate('JS_SELECT_AN_OPTION');
			}
			if (typeof params.templateResult === 'undefined') {
				params.templateResult = function (data, container) {
					if (data.element && data.element.className) {
						$(container).addClass(data.element.className);
					}
					if (typeof data.name === 'undefined') {
						return data.text;
					}
					if (data.type == 'optgroup') {
						return '<strong>' + data.name + '</strong>';
					} else {
						return '<span>' + data.name + '</span>';
					}
				};
			}
			if (typeof params.templateSelection === 'undefined') {
				params.templateSelection = function (data, container) {
					if (data.element && data.element.className) {
						$(container).addClass(data.element.className);
					}
					if (data.text === '') {
						return data.name;
					}
					return data.text;
				};
			}
			if (selectElement.data('ajaxSearch') === 1) {
				params.tags = false;
				// params.language.searching = function () {
				// 	return app.translate('JS_SEARCHING');
				// }
				// params.language.inputTooShort = function (args) {
				// 	var remainingChars = args.minimum - args.input.length;
				// 	return app.translate('JS_INPUT_TOO_SHORT').replace("_LENGTH_", remainingChars);
				// }
				// params.language.errorLoading = function () {
				// 	return app.translate('JS_NO_RESULTS_FOUND');
				// }
				params.placeholder = '';
				params.ajax = {
					url: selectElement.data('ajaxUrl'),
					dataType: 'json',
					delay: 250,
					method: 'POST',
					data: function (params) {
						return {
							value: params.term, // search term
							page: params.page
						};
					},
					processResults: function (data, params) {
						var items = new Array();
						if (data.success == true) {
							selectElement.find('option').each(function () {
								var currentTarget = $(this);
								items.push({
									label: currentTarget.html(),
									value: currentTarget.val()
								});
							});
							items = items.concat(data.result.items);
						}
						return {
							results: items,
							pagination: {
								more: false
							}
						};
					},
					cache: false
				};
				params.escapeMarkup = function (markup) {
					if (markup !== 'undefined') return markup;
				};
				var minimumInputLength = 3;
				if (selectElement.data('minimumInput') !== 'undefined') {
					minimumInputLength = selectElement.data('minimumInput');
				}
				params.minimumInputLength = minimumInputLength;
				params.templateResult = function (data) {
					if (typeof data.name === 'undefined') {
						return data.text;
					}
					if (data.type == 'optgroup') {
						return '<strong>' + data.name + '</strong>';
					} else {
						return '<span>' + data.name + '</span>';
					}
				};
				params.templateSelection = function (data, container) {
					if (data.text === '') {
						return data.name;
					}
					return data.text;
				};
			}
			selectElement.each(function (e) {
				var select = $(this);
				if (select.attr('readonly') == 'readonly' && !select.attr('disabled')) {
					var selectNew = select.clone().addClass('d-none');
					select.parent().append(selectNew);
					select.prop('disabled', true);
				}
				let htmlBoolParams = select.data('select');
				if (htmlBoolParams === 'tags') {
					params.tags = true;
					params.tokenSeparators = [','];
				} else {
					params[htmlBoolParams] = true;
				}
				select
					.select2(params)
					.on('select2:open', function (e) {
						if (select.data('unselecting')) {
							select.removeData('unselecting');
							setTimeout(function (e) {
								select.each(function () {
									$(this).select2('close');
								});
							}, 1);
						}
						var element = $(e.currentTarget);
						var instance = element.data('select2');
						instance.$dropdown.css('z-index', 1000002);
					})
					.on('select2:unselect', function (e) {
						select.data('unselecting', true);
					});

				if (select.hasClass('js-select2-sortable')) {
					self.registerSelect2Sortable(select, params.sortableCb);
				}
			});

			return selectElement;
		},
		/**
		 * Register select2 drag and drop sorting
		 * @param {jQuery} select2 element
		 * @param {function} callback function
		 */
		registerSelect2Sortable(select, cb = () => {}) {
			let ul = select.next('.select2-container').first('ul.select2-selection__rendered');
			ul.sortable({
				items: 'li:not(.select2-search__field)',
				tolerance: 'pointer',
				stop: function () {
					$(ul.find('.select2-selection__choice').get().reverse()).each(function () {
						let optionTitle = $(this).attr('title');
						select.find('option').each(function () {
							if ($(this).text() === optionTitle) {
								select.prepend($(this));
							}
						});
					});
					cb(select);
				}
			});
		}
	},
	Tree: class {
		constructor(treeContainer = $('.js-tree-container')) {
			if (treeContainer.length > 0) {
				this.treeInstance = treeContainer;
				this.loadTree();
			}
		}
		/**
		 * Get instance of Tree.
		 * @returns {Tree}
		 */
		static getInstance(container = $('.js-tree-container')) {
			if (typeof window.App.Fields.Tree.instance === 'undefined') {
				window.App.Fields.Tree.instance = new window.App.Fields.Tree(container);
			}
			return window.App.Fields.Tree.instance;
		}
		/**
		 * Load tree.
		 */
		loadTree() {
			this.generateTree(JSON.parse(this.treeInstance.find('.js-tree-data').val()));
		}
		/**
		 * Generate tree.
		 * @param {object} treeData
		 */
		generateTree(treeData) {
			this.treeInstance.jstree({
				core: {
					data: treeData,
					multiple: false,
					themes: {
						name: 'proton',
						responsive: true
					}
				}
			});
		}
	},
	MultiTree: class {
		constructor(treeContainer = $('.js-tree-container')) {
			if (treeContainer.length > 0) {
				this.treeInstance = treeContainer;
				this.loadTree();
			}
		}
		/**
		 * Get instance of Tree.
		 * @returns {Tree}
		 */
		static getInstance(container = $('.js-tree-container')) {
			if (typeof window.App.Fields.MultiTree.instance === 'undefined') {
				window.App.Fields.MultiTree.instance = new window.App.Fields.MultiTree(container);
			}
			return window.App.Fields.MultiTree.instance;
		}
		/**
		 * Load tree.
		 */
		loadTree() {
			this.generateTree(JSON.parse(this.treeInstance.find('.js-tree-data').val()));
		}
		/**
		 * Generate tree.
		 * @param {object} treeData
		 */
		generateTree(treeData) {
			let plugins = [];
			plugins.push('category');
			plugins.push('checkbox');
			this.treeInstance.jstree({
				core: {
					data: treeData,
					multiple: true,
					themes: {
						name: 'proton',
						responsive: true
					}
				},
				checkbox: {
					three_state: false
				},
				plugins: plugins
			});
		}
	},
	Integer: {
		/**
		 * Function returns the integer in user specified format.
		 * @param {number} value
		 * @param {int} numberOfDecimal
		 * @returns {string}
		 */
		formatToDisplay(value) {
			if (!value) {
				value = 0;
			}
			let groupSeparator = app.getMainParams('currencyGroupingSeparator');
			let groupingPattern = app.getMainParams('currencyGroupingPattern');
			value = parseFloat(value).toFixed(1);
			let integer = value.toString().split('.')[0];
			if (integer.length > 3) {
				if (groupingPattern === '123,456,789') {
					integer = integer.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1' + groupSeparator);
				} else if (groupingPattern === '123456,789') {
					integer = integer.slice(0, -3) + groupSeparator + integer.slice(-3);
				} else if (groupingPattern === '12,34,56,789') {
					integer =
						integer.slice(0, -3).replace(/(\d)(?=(\d\d)+(?!\d))/g, '$1' + groupSeparator) +
						groupSeparator +
						integer.slice(-3);
				}
			}
			return integer;
		}
	},
	Double: {
		/**
		 * Function returns the currency in user specified format.
		 * @param {number} value
		 * @param {boolean} numberOfDecimal
		 * @param {int} numberOfDecimal
		 * @returns {string}
		 */
		formatToDisplay(value, fixed = true, numberOfDecimal = app.getMainParams('numberOfCurrencyDecimal')) {
			if (!value) {
				value = 0;
			}
			value = parseFloat(value);
			if (fixed) {
				value = value.toFixed(numberOfDecimal);
			}
			let a = value.toString().split('.');
			let integer = App.Fields.Integer.formatToDisplay(a[0]);
			let decimal = a[1];
			if (numberOfDecimal) {
				if (app.getMainParams('truncateTrailingZeros')) {
					if (decimal) {
						let d = '';
						for (var i = 0; i < decimal.length; i++) {
							if (decimal[decimal.length - i - 1] !== '0') {
								d = decimal[decimal.length - i - 1] + d;
							}
						}
						decimal = d;
					}
				}
				if (decimal) {
					return integer + app.getMainParams('currencyDecimalSeparator') + decimal;
				}
			}
			return integer;
		},

		/**
		 * Function to get value for db format.
		 * @param {string} value
		 * @returns {number}
		 */
		formatToDb(value) {
			if (value == undefined || value == '') {
				value = 0;
			}
			value = value.toString();
			value = value.split(app.getMainParams('currencyGroupingSeparator')).join('');
			value = value.replace(/\s/g, '').replace(app.getMainParams('currencyDecimalSeparator'), '.');
			return parseFloat(value);
		}
	},

	Utils: {
		positionPicker(ev, picker) {
			let offset = picker.element.offset();
			let $window = $(window);
			if (offset.left - $window.scrollLeft() + picker.container.outerWidth() > $window.width()) {
				picker.opens = 'left';
			} else {
				picker.opens = 'right';
			}
			picker.move();
			if (offset.top - $window.scrollTop() + picker.container.outerHeight() > $window.height()) {
				picker.drops = 'up';
			} else {
				picker.drops = 'down';
			}
			picker.move();
		}
	}
};
