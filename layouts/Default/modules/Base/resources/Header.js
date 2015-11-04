/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

jQuery.Class("Vtiger_Header_Js", {
	quickCreateModuleCache: {},
	self: false,
	getInstance: function () {
		if (this.self != false) {
			return this.self;
		}
		this.self = new Vtiger_Header_Js();
		return this.self;
	}
}, {	
	recentPageViews: function () {
		var thisInstance = this;
		var maxValues = 20;
		var BtnText = '';
		var BtnLink = 'javascript:void();';
		var history = localStorage.history;
		if (history != "" && history != null) {
			var sp = history.toString().split(",");
			var item = sp[sp.length - 1].toString().split("|");
			BtnText = item[0];
			BtnLink = item[1];			
		}		
		var htmlContent = '<ul class="dropdown-menu pull-right historyList" role="menu">';
		var date = new Date().getTime();
		var howmanyDays = -1;
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
					if(writeSelector && (howmanyDays != app.howManyDaysFromDate(d))){
						howmanyDays = app.howManyDaysFromDate(d);
						if(howmanyDays == 0){
							htmlContent += '<li class="selectorHistory">' + app.translate('JS_TODAY') + '</li>';
						}
						else if(howmanyDays == 1){
							htmlContent += '<li class="selectorHistory">' + app.translate('JS_YESTERDAY') + '</li>';
						}
						else{
							htmlContent += '<li class="selectorHistory">' + app.translate('JS_OLDER') + '</li>';
							writeSelector = false;
						}
					}
					if(writeSelector)
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
			localStorage.history = sp.toString();
			
		} else {
			var stack = new Array();
			var Label = this.getHistoryLabel();
			if (Label.length > 1) {
				stack.push(this.getHistoryLabel() + '|' + document.URL + '|' + date);
				localStorage.history = stack.toString();
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
			localStorage.history = "";
			var htmlContent = '<li class="divider"></li><li><a class="clearHistory" href="#">' + app.translate('JS_CLEAR_HISTORY') + '</a></li>';
			$(".historyBtn .dropdown-menu").html(htmlContent);
		});
	},	
	registerEvents: function () {
		var thisInstance = this;
		thisInstance.recentPageViews();		
		thisInstance.buttonsInHeaderBar();
	},
	mainMenuHide: function(){
		$('.mobileLeftPanel').removeClass('showMainMenu');
	},
	actionMenuHide: function(){
		$('.actionMenu').removeClass('showActionMenu');
	},
	buttonsInHeaderBar: function(){
		var thisInstance = this;
		$('.rightHeaderBtnMenu').click(function(){
			$('.mobileLeftPanel').toggleClass('showMainMenu');
			thisInstance.actionMenuHide();
		});
		$('.actionMenuBtn ').click(function(){
			$('.actionMenu').toggleClass('showActionMenu');
			thisInstance.mainMenuHide();
		});
	},
});
jQuery(document).ready(function () {
	Vtiger_Header_Js.getInstance().registerEvents();
});
