/* {[The file is published on the basis of YetiForce Public License 2.0 that can be found in the following directory: licenses/License.html or yetiforce.com]} */
var app = {
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
	 * Function returns the current view name
	 */
	getViewName: function () {
		return app.getMainParams('view');
	},
	/**
	 * Function returns the javascript controller based on the current view
	 */
	getPageController: function () {
		var moduleName = app.getModuleName();
		var view = app.getViewName()

		var moduleClassName = moduleName + "_" + view + "_Js";
		var extendModules = jQuery('#extendModules').val();
		if (typeof window[moduleClassName] == 'undefined' && extendModules != undefined) {
			moduleClassName = extendModules + "_" + view + "_Js";
		}
		if (typeof window[moduleClassName] == 'undefined') {
			moduleClassName = "Base_" + view + "_Js";
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
		useSuffix: "_chosen",
		usePrefix: "s2id_",
	},
	formatDate: function (date) {
		var y = date.getFullYear(),
				m = date.getMonth() + 1,
				d = date.getDate(),
				h = date.getHours(),
				i = date.getMinutes(),
				s = date.getSeconds();
		return y + '-' + this.formatDateZ(m) + '-' + this.formatDateZ(d) + ' ' + this.formatDateZ(h) + ':' + this.formatDateZ(i) + ':' + this.formatDateZ(s);
	},
	formatDateZ: function (i) {
		return (i <= 9 ? '0' + i : i);
	},
	howManyDaysFromDate: function (time) {
		var fromTime = time.getTime();
		var today = new Date();
		var toTime = new Date(today.getFullYear(), today.getMonth(), today.getDate()).getTime();
		return Math.floor(((toTime - fromTime) / (1000 * 60 * 60 * 24))) + 1;
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
		val = val.split(groupSeparator).join("");
		val = val.replace(/\s/g, "").replace(decimalSeparator, ".");
		return parseFloat(val);
	},
	registerSelectField: function (container) {
		this.registerChznSelectField(container);
		this.registerSelect2Field(container);
	},
	registerTimeField: function (container) {
		var thisInstance = this;
		if (typeof container === 'undefined') {
			container = jQuery('body');
		}
		if (typeof params === 'undefined') {
			params = {};
		}
		var timeFieldElements = jQuery('.timeField', container);
		params.autoclose = true;
		timeFieldElements.each(function () {
			var element = $(this);
			var input = element.find(".timeFieldInput");
			var button = element.find(".timeFieldButton");
			if (!input.attr("id")) {
				input.attr('id', "timeFieldInput" + thisInstance.generateRandomChar() + thisInstance.generateRandomChar() + thisInstance.generateRandomChar());
			}
			var params_custom = params;
			var fieldInfo = app.parseFieldInfo(input.attr("data-fieldinfo"));
			if (fieldInfo['time-format'] == 12) {
				params_custom.twelvehour = true;
			} else if (fieldInfo['time-format'] == 24) {
				params_custom.twelvehour = false;
			}
			input.clockpicker(params_custom);
			button.click(function (e) {
				e.stopPropagation();
				input.clockpicker('toggle');
			});
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
		params.width = "100%";
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
			var input = element.find(".dateFieldInput");
			var button = element.find(".dateFieldButton");
			if (!input.attr("id")) {
				input.attr('id', "dateFieldInput" + thisInstance.generateRandomChar() + thisInstance.generateRandomChar() + thisInstance.generateRandomChar());
			}
			var params_custom = params;
			var fieldInfo = app.parseFieldInfo(input.attr("data-fieldinfo"));
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
			if ($(this).prop("id").length == 0) {
				$(this).attr('id', "sel" + thisInstance.generateRandomChar() + thisInstance.generateRandomChar() + thisInstance.generateRandomChar());
			}
		});
		selectElement.filter('[multiple]').filter('[data-validation-engine*="validate"]').on('change', function (e) {
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
					if (jQuery(this).hasClass('hide')) {
						ns.push(n);
					}
				});
				if (ns.length) {
					select.next().find('.search-choice-close').each(function (n, e) {
						var element = jQuery(this);
						var index = element.data('option-array-index');
						if (jQuery.inArray(index, ns) != -1) {
							element.closest('li').remove();
						}
					})
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
		params.width = "100%";
		selectElement.each(function () {
			if ($(this).prop("id").length == 0) {
				$(this).attr('id', "sel" + thisInstance.generateRandomChar() + thisInstance.generateRandomChar() + thisInstance.generateRandomChar());
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
		chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
		rand = Math.floor(Math.random() * chars.length);
		return newchar = chars.substring(rand, rand + 1);
	},
	registerSideLoading: function (body) {
		$(document).pjax('a[href]:not(.loadPage)', 'div.bodyContent');
		$(document).on('pjax:complete', function () {
			var pageController = app.getPageController();
			if (pageController)
				pageController.registerEvents();
		})
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
	registerDataTables: function (table, customParams) {
		if ($.fn.dataTable == undefined) {
			return false;
		}
		if (table.length == 0) {
			return false;
		}
		var params = {language: {
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
		}
		if (customParams != undefined) {
			params = jQuery.extend(params, customParams);
		}
		$.extend($.fn.dataTable.defaults, params);
		return table.DataTable();
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
	showModalWindow: function (data, url, cb, paramsObject) {
		var thisInstance = this;
		var id = 'globalmodal';
		//null is also an object
		if (typeof data == 'object' && data != null && !(data instanceof jQuery)) {
			if (data.id != undefined) {
				id = data.id;
			}
			paramsObject = data.css;
			cb = data.cb;
			url = data.url;
			if (data.sendByAjaxCb != 'undefined') {
				var sendByAjaxCb = data.sendByAjaxCb;
			}
			data = data.data;
		}
		if (typeof url == 'function') {
			if (typeof cb == 'object') {
				paramsObject = cb;
			}
			cb = url;
			url = false;
		} else if (typeof url == 'object') {
			cb = function () {
			};
			paramsObject = url;
			url = false;
		}
		if (typeof cb != 'function') {
			cb = function () {
			}
		}
		if (typeof sendByAjaxCb != 'function') {
			var sendByAjaxCb = function () {
			}
		}

		var container = jQuery('#' + id);
		if (container.length) {
			container.remove();
		}
		container = jQuery('<div></div>');
		container.attr('id', id).addClass('modalContainer');

		var showModalData = function (data) {
			var params = {
				'show': true,
			};
			if (jQuery('#backgroundClosingModal').val() != 1) {
				params.backdrop = 'static';
			}
			if (typeof paramsObject == 'object') {
				container.css(paramsObject);
				params = jQuery.extend(params, paramsObject);
			}
			container.html(data);

			// In a modal dialog elements can be specified which can receive focus even though they are not descendants of the modal dialog.
			$.fn.modal.Constructor.prototype.enforceFocus = function (e) {
				$(document).off('focusin.bs.modal') // guard against infinite focus loop
						.on('focusin.bs.modal', $.proxy(function (e) {
							if ($(e.target).hasClass('select2-search__field')) {
								return true;
							}
						}, this))
			};
			var modalContainer = container.find('.modal:first');
			modalContainer.modal(params);
			jQuery('body').append(container);
			app.showChznSelectElement(modalContainer.find('select.chzn-select'));
			app.showSelect2Element(modalContainer.find('select.select2'));

			thisInstance.registerDataTables(modalContainer.find('.dataTable'));
			modalContainer.one('shown.bs.modal', function () {
				var backdrop = jQuery('.modal-backdrop');
				if (backdrop.length > 1) {
					jQuery('.modal-backdrop:not(:first)').remove();
				}
				cb(modalContainer);
			})
		}
		if (data) {
			showModalData(data)

		} else {
			jQuery.get(url).then(function (response) {
				showModalData(response);
			});
		}
		container.one('hidden.bs.modal', function () {
			container.remove();
			var backdrop = jQuery('.modal-backdrop');
			var modalContainers = jQuery('.modalContainer');
			if (modalContainers.length == 0 && backdrop.length) {
				backdrop.remove();
			}
			if (backdrop.length > 0) {
				$('body').addClass('modal-open');
			}
		});
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
			callback = function () {
			};
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
					if (v.name in data && (typeof data[v.name] != 'object')) {
						var element = form.find('[name="' + v.name + '"]');
						//Only for muti select element we need to send array of values
						if (element.is('select') && element.attr('multiple') != undefined) {
							var prevValue = data[v.name];
							data[v.name] = new Array();
							data[v.name].push(prevValue)
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
		}
	},
	/**
	 * Function to push down the error message size when validation is invoked
	 * @params : form Element
	 */
	formAlignmentAfterValidation: function (form) {
		// to avoid hiding of error message under the fixed nav bar
		var formError = form.find(".formError:not('.greenPopup'):first")
		if (formError.length > 0) {
			var destination = formError.offset().top;
			var resizedDestnation = destination - 105;
			jQuery('html').animate({
				scrollTop: resizedDestnation
			}, 'slow');
		}
	},
}

jQuery(document).ready(function () {
	var container = jQuery('body');
	app.registerSelectField(container);
	app.registerDateField(container);
	app.registerTimeField(container);
	app.registerAdditions(jQuery);
//	app.registerSideLoading(container);
	// Instantiate Page Controller
	var pageController = app.getPageController();
	if (pageController)
		pageController.registerEvents();
});
