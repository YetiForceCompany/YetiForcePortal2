/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

jQuery.Class("Base_Header_Js", {
	quickCreateModuleCache: {},
	self: false,
	getInstance: function () {
		if (this.self != false) {
			return this.self;
		}
		this.self = new Base_Header_Js();
		return this.self;
	}
}, {
	recentPageViews: function () {
		var thisInstance = this;
		var maxValues = 20;
		var BtnText = '';
		var BtnLink = 'javascript:void();';
		var key = 'yf_history_portal_';
		var history = localStorage.getItem(key);
		if (history != "" && history != null) {
			var sp = history.toString().split("_|_");
			var item = sp[sp.length - 1].toString().split("|");
			BtnText = item[0];
			BtnLink = item[1];
		}
		var htmlContent = '<ul class="dropdown-menu float-right historyList" role="menu">';
		var date = new Date().getTime();
		var howManyDays = -1;
		var writeSelector = true;
		if (sp != null) {
			for (var i = sp.length - 1; i >= 0; i--) {
				item = sp[i].toString().split("|");
				var d = new Date();
				var t = '';
				if (item[2] != undefined) {
					d.setTime(item[2]);
					var hours = app.formatDateZ(d.getHours());
					var minutes = app.formatDateZ(d.getMinutes());
					if (writeSelector && (howManyDays != app.howManyDaysFromDate(d))) {
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
					if (writeSelector)
						t = '<span class="historyHour">' + hours + ":" + minutes + "</span> | ";
					else
						t = app.formatDate(d) + ' | ';
				}
				var format = $('#userDateFormat').val() + '' + $('#userDateFormat').val();
				htmlContent += '<li><a href="' + item[1] + '">' + t + item[0] + '</a></li>';
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
		htmlContent += '<li class="divider"></li><li><a class="clearHistory" href="#">' + app.translate('JS_CLEAR_HISTORY') + '</a></li>';
		htmlContent += '</ul>';
		$(".showHistoryBtn").after(htmlContent);
		this.registerClearHistory();
	},
	getHistoryLabel: function () {
		var label = "";
		$(".breadcrumbsLinks span").each(function (index) {
			label += $(this).text();
		});
		return label;
	},
	registerClearHistory: function () {
		$(".historyBtn .clearHistory").click(function () {
			var key = 'yf_history_portal_';
			localStorage.removeItem(key);
			var htmlContent = '<li class="divider"></li><li><a class="clearHistory" href="#">' + app.translate('JS_CLEAR_HISTORY') + '</a></li>';
			$(".historyBtn .dropdown-menu").html(htmlContent);
		});
	},
	registerChangeCompany: function () {
		$('#modalSelectCompanies').on('show.bs.modal', function (relatedTarget) {
			let modal = $(relatedTarget.target);
			let select = modal.find('select').addClass('select2');
			App.Fields.Picklist.showSelect2ElementView(select);
			modal.find(".btn-primary").click(function () {
				AppConnector.request({
					module: app.getModuleName(),
					action: 'ChangeCompany',
					record: modal.find("#companyId").val()
				}).then(function (data) {
					window.location.href = 'index.php';
				}, function (e, err) {
					console.log([e, err])
				});
			});
		});
	},
	registerEvents: function () {
		var thisInstance = this;
		thisInstance.recentPageViews();
		thisInstance.registerChangeCompany();
		App.Fields.Tree.getInstance();
	},
});
jQuery(document).ready(function () {
	Base_Header_Js.getInstance().registerEvents();
});
