/* {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
jQuery.Class(
	'Base_Helper_Js',
	{
		checkServerConfigResponseCache: '',
		langCode: '',
		/*
		 * Function to set lang code
		 */
		setLangCode: function () {
			var htmlTag = document.getElementsByTagName('html')[0];
			this.langCode = htmlTag.getAttribute('lang') ? htmlTag.getAttribute('lang') : 'en';
		},
		/*
		 * Function to get lang code
		 */
		getLangCode: function () {
			if (!this.langCode) {
				this.setLangCode();
			}
			return this.langCode;
		},
		/*
		 * Function to get the instance of Mass edit of Email
		 */
		getEmailMassEditInstance: function () {
			var className = 'Emails_MassEdit_Js';
			var emailMassEditInstance = new window[className]();
			return emailMassEditInstance;
		},
		getDayFromDate: function (date) {
			var dayOfWeek = this.getDay(date);
			return this.getLabelDayFromDate(dayOfWeek);
		},
		getDay: function (date) {
			var dateObj = new Date(date);
			if (isNaN(dateObj.getDay())) {
				dateObj = Date.parse(date);
			}
			return dateObj.getDay();
		},
		getLabelDayFromDate: function (day) {
			var dayOfWeek = day;
			var dayOfWeekLabel = '';
			switch (dayOfWeek) {
				case 0:
					dayOfWeekLabel = 'JS_SUN';
					break;
				case 1:
					dayOfWeekLabel = 'JS_MON';
					break;
				case 2:
					dayOfWeekLabel = 'JS_TUE';
					break;
				case 3:
					dayOfWeekLabel = 'JS_WED';
					break;
				case 4:
					dayOfWeekLabel = 'JS_THU';
					break;
				case 5:
					dayOfWeekLabel = 'JS_FRI';
					break;
				case 6:
					dayOfWeekLabel = 'JS_SAT';
					break;
			}
			return app.translate(dayOfWeekLabel);
		},
		/*
		 * Function to get Date Instance
		 * @params date---this is the field value
		 * @params dateFormat---user date format
		 * @return date object
		 */
		getDateInstance: function (dateTime, dateFormat) {
			var dateTimeComponents = dateTime.split(' ');
			var dateComponent = dateTimeComponents[0];
			var timeComponent = dateTimeComponents[1];
			var seconds = '00';

			var dotMode = '-';
			if (dateFormat.indexOf('-') !== -1) {
				dotMode = '-';
			}
			if (dateFormat.indexOf('.') !== -1) {
				dotMode = '.';
			}
			if (dateFormat.indexOf('/') !== -1) {
				dotMode = '/';
			}

			var splittedDate = dateComponent.split(dotMode);
			var splittedDateFormat = dateFormat.split(dotMode);
			var year = splittedDate[splittedDateFormat.indexOf('yyyy')];
			var month = splittedDate[splittedDateFormat.indexOf('mm')];
			var date = splittedDate[splittedDateFormat.indexOf('dd')];
			var dateInstance = Date.parse(year + dotMode + month + dotMode + date);
			if (year.length > 4 || month.length > 2 || date.length > 2 || dateInstance === null) {
				var errorMsg = app.translate('JS_INVALID_DATE');
				throw errorMsg;
			}

			//Before creating date object time is set to 00
			//because as while calculating date object it depends system timezone
			if (typeof timeComponent === 'undefined') {
				timeComponent = '00:00:00';
			}

			var timeSections = timeComponent.split(':');
			if (typeof timeSections[2] !== 'undefined') {
				seconds = timeSections[2];
			}

			//Am/Pm component exits
			if (typeof dateTimeComponents[2] !== 'undefined') {
				timeComponent += ' ' + dateTimeComponents[2];
				if (dateTimeComponents[2].toLowerCase() === 'pm' && timeSections[0] !== '12') {
					timeSections[0] = parseInt(timeSections[0], 10) + 12;
				}

				if (dateTimeComponents[2].toLowerCase() === 'am' && timeSections[0] === '12') {
					timeSections[0] = '00';
				}
			}
			month = month - 1;
			return new Date(year, month, date, timeSections[0], timeSections[1], seconds);
		},
		unique: function (array) {
			return array.filter(function (el, index, arr) {
				return index === arr.indexOf(el);
			});
		}
	},
	{}
);
