/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */
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
	formatDateZ: function (i) {
		return (i <= 9 ? '0' + i : i);
	},
	howManyDaysFromDate: function (time) {
		var fromTime = time.getTime();
		var today = new Date();
		var toTime = new Date(today.getFullYear(), today.getMonth(), today.getDate()).getTime();
		return Math.floor(((toTime - fromTime) / (1000 * 60 * 60 * 24))) + 1;
	},
	showSelectElement: function (parent, view, params) {
		var thisInstance = this;
		var selectElement = jQuery();
		if (typeof parent == 'undefined') {
			parent = jQuery('body');
		}
		if (typeof params == 'undefined') {
			params = {};
		}
		selectElement = jQuery('.chzn-select', parent);
		// generate random ID
		selectElement.each(function () {
			if ($(this).prop("id").length == 0) {
				$(this).attr('id', "sel" + thisInstance.generateRandomChar() + thisInstance.generateRandomChar() + thisInstance.generateRandomChar());
			}
		});

		selectElement.chosen(params);
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
		if(customParams != undefined){
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
}

jQuery(document).ready(function () {
	app.showSelectElement(jQuery('body'));
	app.registerSideLoading(jQuery('body'));
	// Instantiate Page Controller
	var pageController = app.getPageController();
	if (pageController)
		pageController.registerEvents();
});
