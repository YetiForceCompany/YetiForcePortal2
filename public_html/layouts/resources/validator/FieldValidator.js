/* {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
Base_Validator_Js(
	'Base_Email_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var emailInstance = new Base_Email_Validator_Js();
			emailInstance.setElement(field);
			var response = emailInstance.validate();
			if (response != true) {
				return emailInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the email field data
		 */
		validate: function () {
			var fieldValue = this.getFieldValue();
			return this.validateValue(fieldValue);
		},
		/**
		 * Function to validate the email field data
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validateValue: function (fieldValue) {
			var emailFilter =
				/^[_/a-zA-Z0-9*]+([!"#$%&'()*+,./:;<=>?\^_`{|}~-]?[a-zA-Z0-9/_/-])*@[a-zA-Z0-9]+([\_\-\.]?[a-zA-Z0-9]+)*\.([\-\_]?[a-zA-Z0-9])+(\.?[a-zA-Z0-9]+)?$/;
			var illegalChars = /[\(\)\<\>\,\;\:\\\"\[\]]/;

			if (!emailFilter.test(fieldValue)) {
				this.setError(app.translate('JS_PLEASE_ENTER_VALID_EMAIL_ADDRESS'));
				return false;
			} else if (fieldValue.match(illegalChars)) {
				this.setError(app.translate('JS_CONTAINS_ILLEGAL_CHARACTERS'));
				return false;
			}
			var field = this.getElement();
			var fieldData = field.data();
			var fieldInfo = fieldData.fieldinfo;
			if (
				fieldInfo &&
				fieldInfo.restrictedDomains &&
				fieldInfo.restrictedDomains.indexOf(fieldValue.split('@').pop()) != -1
			) {
				this.setError(app.translate('JS_EMAIL_RESTRICTED_DOMAINS'));
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_UserName_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var usernameInstance = new Base_UserName_Validator_Js();
			usernameInstance.setElement(field);
			var response = usernameInstance.validate();
			if (response != true) {
				return usernameInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the User Name
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var fieldValue = this.getFieldValue();
			var negativeRegex = /^[a-zA-Z0-9_.@]{3,32}$/;
			var result = negativeRegex.test(fieldValue);
			if (!result) {
				var errorInfo = app.translate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_PositiveNumber_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var positiveNumberInstance = new Base_PositiveNumber_Validator_Js();
			positiveNumberInstance.setElement(field);
			var response = positiveNumberInstance.validate();
			if (response != true) {
				return positiveNumberInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var fieldValue = this.getFieldValue();
			var negativeRegex = /(^[-]+\d+)$/;
			parseFieldValue = app.parseNumberToFloat(this.getFieldValue());
			if (isNaN(parseFieldValue) || fieldValue < 0 || fieldValue.match(negativeRegex)) {
				var errorInfo = app.translate('JS_ACCEPT_POSITIVE_NUMBER');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_Integer_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var integerInstance = new Base_Integer_Validator_Js();
			integerInstance.setElement(field);
			var response = integerInstance.validate();
			if (response != true) {
				return integerInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Integre field data
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			let fieldValue = this.getFieldValue(),
				integerRegex = /(^[-+]?\d+)$/;
			if (!fieldValue.match(integerRegex)) {
				var errorInfo = app.translate('JS_PLEASE_ENTER_INTEGER_VALUE');
				this.setError(errorInfo);
				return false;
			}
			let fieldInfo = this.getElement().data().fieldinfo;
			if (!fieldInfo || !fieldInfo.maximumlength) {
				return true;
			}
			let ranges = fieldInfo.maximumlength.split(',');
			if (ranges.length === 2) {
				if (fieldValue > parseFloat(ranges[1]) || fieldValue < parseFloat(ranges[0])) {
					errorInfo = app.translate('JS_ERROR_MAX_VALUE');
					this.setError(errorInfo);
					return false;
				}
			} else {
				if (fieldValue > parseFloat(ranges[0]) || fieldValue < 0) {
					errorInfo = app.translate('JS_ERROR_MAX_VALUE');
					this.setError(errorInfo);
					return false;
				}
			}
			return true;
		}
	}
);

Base_PositiveNumber_Validator_Js(
	'Base_Percentage_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var percentageInstance = new Base_Percentage_Validator_Js();
			percentageInstance.setElement(field);
			var response = percentageInstance.validate();
			if (response != true) {
				return percentageInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the percentage field data
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate() {
			const response = this._super();
			if (response != true) {
				return response;
			} else {
				if (App.Fields.Double.formatToDb(this.getFieldValue()) > 100) {
					this.setError(app.translate('JS_PERCENTAGE_VALUE_SHOULD_BE_LESS_THAN_100'));
					return false;
				}
				return true;
			}
		}
	}
);

Base_Validator_Js(
	'Base_Url_Validator_Js',
	{
		/**
		 * Function which invokes field validation
		 * @param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			let validatorInstance = new Base_Url_Validator_Js();
			validatorInstance.setElement(field);
			const result = validatorInstance.validate();
			if (result === true) {
				return result;
			} else {
				return validatorInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Url
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			let fieldValue = this.getFieldValue();
			let regexp = /(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/gi;
			let result = regexp.test(fieldValue);
			if (!result) {
				if (
					fieldValue.indexOf('http://') === 0 ||
					fieldValue.indexOf('https://') === 0 ||
					fieldValue.indexOf('ftp://') === 0 ||
					fieldValue.indexOf('ftps://') === 0 ||
					fieldValue.indexOf('telnet://') === 0 ||
					fieldValue.indexOf('smb://') === 0 ||
					fieldValue.indexOf('www.') === 0
				) {
					result = true;
				}
			}
			if (!result) {
				let errorInfo = app.translate('JS_CONTAINS_ILLEGAL_CHARACTERS'); //"Please enter valid url";
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_MultiSelect_Validator_Js',
	{
		invokeValidation: function (field, rules, i, options) {
			var validatorInstance = new Base_MultiSelect_Validator_Js();
			validatorInstance.setElement(field);
			var result = validatorInstance.validate();
			if (result == true) {
				return result;
			} else {
				return validatorInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Multi select
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var fieldInstance = this.getElement();
			var selectElementValue = fieldInstance.val();
			if (selectElementValue == null) {
				var errorInfo = app.translate('JS_PLEASE_SELECT_ATLEAST_ONE_OPTION');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Email_Validator_Js(
	'Base_MultiEmails_Validator_Js',
	{
		invokeValidation: function (field) {
			var validatorInstance = new Base_MultiEmails_Validator_Js();
			validatorInstance.setElement(field);
			var result = validatorInstance.validate();
			if (!result) {
				return validatorInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Multi select
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var fieldInstance = this.getElement();
			var fieldInstanceValue = fieldInstance.val();
			if (fieldInstanceValue != '') {
				var emailsArr = fieldInstanceValue.split(',');
				var i;
				for (i = 0; i < emailsArr.length; ++i) {
					var result = this.validateValue(emailsArr[i]);
					if (result == false) {
						return result;
					}
				}
				return true;
			}
		}
	}
);

Base_PositiveNumber_Validator_Js(
	'Base_GreaterThanZero_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var GreaterThanZeroInstance = new Base_GreaterThanZero_Validator_Js();
			GreaterThanZeroInstance.setElement(field);
			var response = GreaterThanZeroInstance.validate();
			if (response != true) {
				return GreaterThanZeroInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers and greater than zero value
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var response = this._super();
			if (response != true) {
				return response;
			} else {
				var fieldValue = this.getFieldValue();
				if (fieldValue == 0) {
					var errorInfo = app.translate('JS_VALUE_SHOULD_BE_GREATER_THAN_ZERO');
					this.setError(errorInfo);
					return false;
				}
			}
			return true;
		}
	}
);

Base_PositiveNumber_Validator_Js(
	'Base_WholeNumber_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var instance = new Base_WholeNumber_Validator_Js();
			instance.setElement(field);
			var response = instance.validate();
			if (response != true) {
				return instance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers and whole Number
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var response = this._super();
			if (response != true) {
				return response;
			}
			var field = this.getElement();
			var fieldValue = this.getFieldValue();
			var fieldData = field.data();
			var fieldInfo = fieldData.fieldinfo;
			if (fieldValue % 1 != 0) {
				if (!jQuery.isEmptyObject(fieldInfo)) {
					var errorInfo = app.translate('INVALID_NUMBER_OF') + ' ' + fieldInfo.label;
				} else {
					var errorInfo = app.translate('INVALID_NUMBER');
				}
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_lessThanToday_Validator_Js',
	{},
	{
		/**
		 * Function to validate the birthday field
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var field = this.getElement();
			var fieldData = field.data();
			var fieldDateFormat = fieldData.dateFormat;
			var fieldInfo = fieldData.fieldinfo;
			var fieldValue = this.getFieldValue();
			try {
				var fieldDateInstance = Base_Helper_Js.getDateInstance(fieldValue, fieldDateFormat);
			} catch (err) {
				this.setError(err);
				return false;
			}
			fieldDateInstance.setHours(0, 0, 0, 0);
			var todayDateInstance = new Date();
			todayDateInstance.setHours(0, 0, 0, 0);
			var comparedDateVal = todayDateInstance - fieldDateInstance;
			if (comparedDateVal <= 0) {
				var errorInfo = fieldInfo.label + ' ' + app.translate('JS_SHOULD_BE_LESS_THAN_CURRENT_DATE');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_lessThanOrEqualToToday_Validator_Js',
	{},
	{
		/**
		 * Function to validate the datesold field
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var field = this.getElement();
			var fieldData = field.data();
			var fieldDateFormat = fieldData.dateFormat;
			var fieldInfo = fieldData.fieldinfo;
			var fieldValue = this.getFieldValue();
			try {
				var fieldDateInstance = Base_Helper_Js.getDateInstance(fieldValue, fieldDateFormat);
			} catch (err) {
				this.setError(err);
				return false;
			}
			fieldDateInstance.setHours(0, 0, 0, 0);
			var todayDateInstance = new Date();
			todayDateInstance.setHours(0, 0, 0, 0);
			var comparedDateVal = todayDateInstance - fieldDateInstance;
			if (comparedDateVal < 0) {
				var errorInfo =
					fieldInfo.label +
					' ' +
					app.translate('JS_SHOULD_BE_LESS_THAN_OR_EQUAL_TO') +
					' ' +
					app.translate('JS_CURRENT_DATE');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_greaterThanOrEqualToToday_Validator_Js',
	{},
	{
		/**
		 * Function to validate the dateinservice field
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var field = this.getElement();
			var fieldData = field.data();
			var fieldDateFormat = fieldData.dateFormat;
			var fieldInfo = fieldData.fieldinfo;
			var fieldValue = this.getFieldValue();
			try {
				var fieldDateInstance = Base_Helper_Js.getDateInstance(fieldValue, fieldDateFormat);
			} catch (err) {
				this.setError(err);
				return false;
			}
			fieldDateInstance.setHours(0, 0, 0, 0);
			var todayDateInstance = new Date();
			todayDateInstance.setHours(0, 0, 0, 0);
			var comparedDateVal = todayDateInstance - fieldDateInstance;
			if (comparedDateVal > 0) {
				var errorInfo =
					fieldInfo.label +
					' ' +
					app.translate('JS_SHOULD_BE_GREATER_THAN_OR_EQUAL_TO') +
					' ' +
					app.translate('JS_CURRENT_DATE');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_greaterThanDependentField_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var fieldForValidation = field[0];
			if (jQuery(fieldForValidation).attr('name') == 'followup_date_start') {
				var dependentFieldList = new Array('date_start');
			}
			var instance = new Base_greaterThanDependentField_Validator_Js();
			instance.setElement(field);
			var response = instance.validate(dependentFieldList);
			if (response != true) {
				return instance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the birthday field
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function (dependentFieldList) {
			var field = this.getElement();
			var fieldInfo = field.data('fieldinfo');
			var fieldLabel;
			if (typeof fieldInfo == 'undefined') {
				fieldLabel = jQuery(field).attr('name');
			} else {
				fieldLabel = fieldInfo.label;
			}
			var contextFormElem = field.closest('form');
			for (var i = 0; i < dependentFieldList.length; i++) {
				var dependentField = dependentFieldList[i];
				var dependentFieldInContext = jQuery('input[name=' + dependentField + ']', contextFormElem);
				if (dependentFieldInContext.length > 0) {
					var dependentFieldLabel = dependentFieldInContext.data('fieldinfo').label;
					var fieldDateInstance = this.getDateTimeInstance(field);
					var dependentFieldDateInstance = this.getDateTimeInstance(dependentFieldInContext);
					var comparedDateVal = fieldDateInstance - dependentFieldDateInstance;
					if (comparedDateVal < 0) {
						var errorInfo =
							fieldLabel +
							' ' +
							app.translate('JS_SHOULD_BE_GREATER_THAN_OR_EQUAL_TO') +
							' ' +
							dependentFieldLabel +
							'';
						this.setError(errorInfo);
						return false;
					}
				}
			}
			return true;
		},
		getDateTimeInstance: function (field) {
			var dateFormat = field.data('dateFormat');
			var fieldValue = field.val();
			try {
				var dateTimeInstance = Base_Helper_Js.getDateInstance(fieldValue, dateFormat);
			} catch (err) {
				this.setError(err);
				return false;
			}
			return dateTimeInstance;
		}
	}
);

Base_Validator_Js(
	'Base_dateAndTimeGreaterThanDependentField_Validator_Js',
	{},
	{
		fieldDateTime: '',
		fieldDateTimeInstance: [],
		dateFormat: '',
		/**
		 * Function to validate the date field
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function (dependentFieldList) {
			var thisInstance = this;
			var field = this.getElement();
			var fieldDateTime = '';
			var fieldDateTimeInstance = [];
			var contextFormElem = field.closest('form');
			var view = contextFormElem.attr('name');
			if (view == 'EditView') {
				return true;
			}
			var j = 0;
			for (var i = 0; i < dependentFieldList.length; i++) {
				var dependentField = dependentFieldList[i];
				var dependentFieldInContext = jQuery('input[name=' + dependentField + ']', contextFormElem);
				if (dependentFieldInContext.length > 0) {
					if (typeof dependentFieldInContext.data('dateFormat') == 'undefined' && fieldDateTime) {
						fieldDateTime += ' ' + dependentFieldInContext.val();
						fieldDateTimeInstance[j] = Base_Helper_Js.getDateInstance(fieldDateTime, dateFormat);
						j++;
					} else if (typeof dependentFieldInContext.data('dateFormat') != 'undefined') {
						var dateFormat = dependentFieldInContext.data('dateFormat');
						fieldDateTime = dependentFieldInContext.val();
					}
				}
			}
			return thisInstance.difference(fieldDateTimeInstance);
		},
		difference: function (fieldDateTimeInstance) {
			if (fieldDateTimeInstance.length == 2) {
				var comparedDateVal = fieldDateTimeInstance[1] - fieldDateTimeInstance[0];
				if (comparedDateVal < 0) {
					var errorInfo = app.translate('JS_AN_INCORRECT_RANGE_OF_DATES_WAS_ENTERED');
					this.setError(errorInfo);
					return false;
				}
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_futureEventCannotBeHeld_Validator_Js',
	{},
	{
		/**
		 * Function to validate event status , which cannot be held for future events
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function (dependentFieldList) {
			var field = this.getElement();
			var fieldLabel = field.data('fieldinfo').label;
			var status = field.val();
			var contextFormElem = field.closest('form');
			for (var i = 0; i < dependentFieldList.length; i++) {
				var dependentField = dependentFieldList[i];
				var dependentFieldInContext = jQuery('input[name=' + dependentField + ']', contextFormElem);
				if (dependentFieldInContext.length > 0) {
					var dependentFieldLabel = dependentFieldInContext.data('fieldinfo').label;
					var todayDateInstance = new Date();
					var dateFormat = dependentFieldInContext.data('dateFormat');
					var time = jQuery('input[name=time_start]', contextFormElem);
					var fieldValue = dependentFieldInContext.val() + ' ' + time.val();
					var dependentFieldDateInstance = Base_Helper_Js.getDateInstance(fieldValue, dateFormat);
					var comparedDateVal = todayDateInstance - dependentFieldDateInstance;
					if (comparedDateVal < 0 && status == 'Held') {
						var errorInfo =
							fieldLabel + ' ' + app.translate('JS_FUTURE_EVENT_CANNOT_BE_HELD') + ' ' + dependentFieldLabel + '';
						this.setError(errorInfo);
						return false;
					}
				}
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_lessThanDependentField_Validator_Js',
	{},
	{
		/**
		 * Function to validate the birthday field
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function (dependentFieldList) {
			var field = this.getElement();
			var fieldLabel = field.data('fieldinfo').label;
			var contextFormElem = field.closest('form');
			//No need to validate if value is empty
			if (field.val().length == 0) {
				return;
			}
			for (var i = 0; i < dependentFieldList.length; i++) {
				var dependentField = dependentFieldList[i];
				var dependentFieldInContext = jQuery('input[name=' + dependentField + ']', contextFormElem);
				if (dependentFieldInContext.length > 0) {
					var dependentFieldLabel = dependentFieldInContext.data('fieldinfo').label;
					var fieldDateInstance = this.getDateTimeInstance(field);
					//No need to validate if value is empty
					if (dependentFieldInContext.val().length == 0) {
						continue;
					}
					var dependentFieldDateInstance = this.getDateTimeInstance(dependentFieldInContext);
					var comparedDateVal = fieldDateInstance - dependentFieldDateInstance;
					if (comparedDateVal > 0) {
						var errorInfo =
							fieldLabel + ' ' + app.translate('JS_SHOULD_BE_LESS_THAN_OR_EQUAL_TO') + ' ' + dependentFieldLabel + '';
						this.setError(errorInfo);
						return false;
					}
				}
			}
			return true;
		},
		getDateTimeInstance: function (field) {
			var dateFormat = field.data('dateFormat');
			var fieldValue = field.val();
			try {
				var dateTimeInstance = Base_Helper_Js.getDateInstance(fieldValue, dateFormat);
			} catch (err) {
				this.setError(err);
				return false;
			}
			return dateTimeInstance;
		}
	}
);

Base_Validator_Js(
	'Base_Currency_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var currencyValidatorInstance = new Base_Currency_Validator_Js();
			currencyValidatorInstance.setElement(field);
			var response = currencyValidatorInstance.validate();
			if (response != true) {
				return currencyValidatorInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Currency Field
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			let response = this._super();
			if (response != true) {
				return response;
			}
			let fieldData = this.getElement().data();
			let decimalSeparator = fieldData.decimalSeparator ? fieldData.decimalSeparator : CONFIG.currencyDecimalSeparator;
			let groupSeparator = fieldData.groupSeparator ? fieldData.groupSeparator : CONFIG.currencyGroupingSeparator;

			let strippedValue = this.getFieldValue().replace(decimalSeparator, '');
			let spacePattern = /\s/;
			if (spacePattern.test(decimalSeparator) || spacePattern.test(groupSeparator))
				strippedValue = strippedValue.replace(/ /g, '');
			let errorInfo;
			if (groupSeparator === '$') {
				groupSeparator = '\\$';
			}
			if (groupSeparator === '.') {
				groupSeparator = '\\.';
			}

			let regex = new RegExp(groupSeparator, 'g');
			strippedValue = strippedValue.replace(regex, '');

			if (isNaN(strippedValue)) {
				errorInfo = app.translate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(errorInfo);
				return false;
			}
			let negativeNumber = fieldData.fieldinfo && fieldData.fieldinfo.fieldtype === 'NN';
			if (!negativeNumber && strippedValue < 0) {
				errorInfo = app.translate('JS_ACCEPT_POSITIVE_NUMBER');
				this.setError(errorInfo);
				return false;
			}
			const maximumLength = typeof fieldData.fieldinfo !== 'undefined' ? fieldData.fieldinfo.maximumlength : null;
			if (maximumLength && strippedValue > parseFloat(maximumLength)) {
				errorInfo = app.translate('JS_ERROR_MAX_VALUE');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);
Base_Validator_Js(
	'Base_NumberUserFormat_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var instance = new Base_NumberUserFormat_Validator_Js();
			instance.setElement(field);
			var response = instance.validate();
			if (response != true) {
				return instance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var response = this._super();
			if (response != true) {
				return response;
			}
			var fieldValue = this.getFieldValue();
			var decimalSeparator = app.getMainParams('currencyDecimalSeparator');
			var groupSeparator = app.getMainParams('currencyGroupingSeparator');
			fieldValue = fieldValue.split(groupSeparator).join('');

			var spacePattern = /\s/;
			if (spacePattern.test(decimalSeparator) || spacePattern.test(groupSeparator))
				fieldValue = fieldValue.replace(/ /g, '');

			var strippedValue = fieldValue.replace(decimalSeparator, '.');
			var errorInfo;

			if (isNaN(strippedValue)) {
				errorInfo = app.translate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(errorInfo);
				return false;
			}
			if (strippedValue < 0) {
				errorInfo = app.translate('JS_ACCEPT_POSITIVE_NUMBER');
				this.setError(errorInfo);
				return false;
			}
			strippedValue = parseFloat(strippedValue);
			if (strippedValue != strippedValue.toString()) {
				errorInfo = app.translate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_ReferenceField_Validator_Js',
	{},
	{
		/**
		 * Function to validate the Positive Numbers and whole Number
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var field = this.getElement();
			var parentElement = field.closest('.fieldValue');
			var referenceField = parentElement.find('.sourceField');
			var referenceFieldValue = referenceField.val();
			var fieldInfo = referenceField.data().fieldinfo;
			if (referenceFieldValue == '') {
				var errorInfo = app.translate('JS_REQUIRED_FIELD');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_Double_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			let doubleValidator = new Base_Double_Validator_Js();
			doubleValidator.setElement(field);
			let response = doubleValidator.validate();
			if (response != true) {
				return doubleValidator.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Decimal field data
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			let response = this._super();
			if (response === true) {
				let fieldValue = this.getFieldValue();
				let doubleRegex = /(^[-+]?\d+)(\.\d+)?$/;
				if (!fieldValue.toString().match(doubleRegex)) {
					let errorInfo = app.translate('JS_PLEASE_ENTER_DECIMAL_VALUE');
					this.setError(errorInfo);
					return false;
				}
				let fieldInfo = this.getElement().data().fieldinfo;
				if (!fieldInfo || !fieldInfo.maximumlength) {
					return true;
				}
				let maximumLength = fieldInfo.maximumlength,
					minimumLength = -maximumLength;
				fieldValue = parseFloat(fieldValue);
				let ranges = maximumLength.split(',');
				if (ranges.length === 2) {
					maximumLength = ranges[1];
					minimumLength = ranges[0];
				}
				if (fieldValue > parseFloat(maximumLength) || fieldValue < parseFloat(minimumLength)) {
					errorInfo = app.translate('JS_ERROR_MAX_VALUE');
					this.setError(errorInfo);
					return false;
				}
			}
			return response;
		},
		/**
		 * Overwrites base function to avoid trimming and validate white spaces
		 * @return fieldValue
		 * */
		getFieldValue: function () {
			return App.Fields.Double.formatToDb(this.getElement().val());
		}
	}
);

Base_Validator_Js(
	'Base_Date_Validator_Js',
	{
		/**
		 * Function which invokes field validation
		 * @param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			let dateValidatorInstance = new Base_Date_Validator_Js();
			dateValidatorInstance.setElement(field);
			let response = dateValidatorInstance.validate();
			if (response != true) {
				return dateValidatorInstance.getError();
			}
			return response;
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers and whole Number
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			let field = this.getElement();
			let fieldData = field.data();
			let fieldDateFormat = fieldData.dateFormat;
			let fieldValue = this.getFieldValue();
			try {
				if (fieldData.calendarType === 'range') {
					fieldValue = fieldValue.split(',');
					if (fieldValue.length !== 2) {
						throw new Error();
					}
				} else {
					fieldValue = [fieldValue];
				}
				fieldValue.forEach((key) => {
					Base_Helper_Js.getDateInstance(key, fieldDateFormat);
				});
			} catch (err) {
				let errorInfo = app.translate('JS_PLEASE_ENTER_VALID_DATE');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_Time_Validator_Js',
	{
		/**
		 * Function which invokes field validation
		 * @param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var validatorInstance = new Base_Time_Validator_Js();
			validatorInstance.setElement(field);
			var result = validatorInstance.validate();
			if (result == true) {
				return result;
			} else {
				return validatorInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Time Fields
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			let format = app.getMainParams('hourFormat');
			if (this.field.data('format') && [12, 24].indexOf(this.field.data('format')) != -1) {
				format = this.field.data('format');
			}
			let regexp = '';
			switch (format) {
				case 12:
					regexp = new RegExp('^([0][0-9]|1[0-2]):([0-5][0-9])([ ]PM|[ ]AM|PM|AM)$');
					break;
				default:
					regexp = new RegExp('^(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])$');
					break;
			}
			if (!regexp.test(this.getFieldValue())) {
				let errorInfo = app.translate('JS_PLEASE_ENTER_VALID_TIME');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

//Calendar Specific validators
// We have placed it here since quick create will not load module specific validators

Base_greaterThanDependentField_Validator_Js(
	'Calendar_greaterThanDependentField_Validator_Js',
	{},
	{
		getDateTimeInstance: function (field) {
			var form = field.closest('form');
			if (field.attr('name') == 'date_start') {
				var timeField = form.find('[name="time_start"]');
				var timeFieldValue = timeField.val();
			} else if (field.attr('name') == 'due_date') {
				var timeField = form.find('[name="time_end"]');
				if (timeField.length > 0) {
					var timeFieldValue = timeField.val();
				} else {
					//Max value for the day
					timeFieldValue = '11:59 PM';
				}
			}

			var dateFieldValue = field.val() + ' ' + timeFieldValue;
			var dateFormat = field.data('dateFormat');
			return Base_Helper_Js.getDateInstance(dateFieldValue, dateFormat);
		}
	}
);

Base_Validator_Js(
	'Calendar_greaterThanToday_Validator_Js',
	{},
	{
		/**
		 * Function to validate the birthday field
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var field = this.getElement();
			var fieldData = field.data();
			var fieldDateFormat = fieldData.dateFormat;
			var fieldInfo = fieldData.fieldinfo;
			var fieldValue = this.getFieldValue();
			try {
				var fieldDateInstance = Base_Helper_Js.getDateInstance(fieldValue, fieldDateFormat);
			} catch (err) {
				this.setError(err);
				return false;
			}
			fieldDateInstance.setHours(0, 0, 0, 0);
			var todayDateInstance = new Date();
			todayDateInstance.setHours(0, 0, 0, 0);
			var comparedDateVal = todayDateInstance - fieldDateInstance;
			if (comparedDateVal >= 0) {
				var errorInfo = fieldInfo.label + ' ' + app.translate('JS_SHOULD_BE_GREATER_THAN_CURRENT_DATE');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Calendar_RepeatMonthDate_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var repeatMonthDateValidatorInstance = new Calendar_RepeatMonthDate_Validator_Js();
			repeatMonthDateValidatorInstance.setElement(field);
			var response = repeatMonthDateValidatorInstance.validate();
			if (response != true) {
				return repeatMonthDateValidatorInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers and whole Number
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var fieldValue = this.getFieldValue();

			if (
				parseInt(parseFloat(fieldValue)) != fieldValue ||
				fieldValue == '' ||
				parseInt(fieldValue) > '31' ||
				parseInt(fieldValue) <= 0
			) {
				var result = app.translate('JS_NUMBER_SHOULD_BE_LESS_THAN_32');
				this.setError(result);
				return false;
			}
			return true;
		}
	}
);

Base_WholeNumber_Validator_Js(
	'Base_WholeNumberGreaterThanZero_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var WholeNumberGreaterThanZero = new Base_WholeNumberGreaterThanZero_Validator_Js();
			WholeNumberGreaterThanZero.setElement(field);
			var response = WholeNumberGreaterThanZero.validate();
			if (response != true) {
				return WholeNumberGreaterThanZero.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers and greater than zero value
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var response = this._super();
			if (response != true) {
				return response;
			} else {
				var fieldValue = this.getFieldValue();
				if (fieldValue == 0) {
					var errorInfo = app.translate('JS_VALUE_SHOULD_BE_GREATER_THAN_ZERO');
					this.setError(errorInfo);
					return false;
				}
			}
			return true;
		}
	}
);
Base_Validator_Js(
	'Base_AlphaNumeric_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var alphaNumericInstance = new Base_AlphaNumeric_Validator_Js();
			alphaNumericInstance.setElement(field);
			var response = alphaNumericInstance.validate();
			if (response != true) {
				return alphaNumericInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var field = this.getElement();
			var fieldValue = field.val();
			var alphaNumericRegex = /^[a-z0-9 _-]*$/i;
			if (!fieldValue.match(alphaNumericRegex)) {
				var errorInfo = app.translate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);
Base_Validator_Js(
	'Base_AlphaNumericWithSlashesCurlyBraces_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var alphaNumericInstance = new Base_AlphaNumericWithSlashesCurlyBraces_Validator_Js();
			alphaNumericInstance.setElement(field);
			var response = alphaNumericInstance.validate();
			if (response != true) {
				return alphaNumericInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var field = this.getElement();
			var fieldValue = field.val();
			var alphaNumericRegex = /^[\/a-z\\0-9{} _-]*$/i;
			if (!fieldValue.match(alphaNumericRegex)) {
				var errorInfo = app.translate('JS_CONTAINS_ILLEGAL_CHARACTERS');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);
Base_Validator_Js(
	'Base_InputMask_Validator_Js',
	{
		/**
		 *Function which invokes field validation
		 *@param accepts field element as parameter
		 * @return error if validation fails true on success
		 */
		invokeValidation: function (field, rules, i, options) {
			var maskInstance = new Base_InputMask_Validator_Js();
			maskInstance.setElement(field);
			var response = maskInstance.validate();
			if (response != true) {
				return maskInstance.getError();
			}
		}
	},
	{
		/**
		 * Function to validate the Positive Numbers
		 * @return true if validation is successfull
		 * @return false if validation error occurs
		 */
		validate: function () {
			var response = this._super();
			if (response != true) {
				return response;
			}
			var field = this.getElement();
			var fieldValue = field.val();
			if (field.inputmask('hasMaskedValue')) {
				var unMaskedValue = field.inputmask('unmaskedvalue');
				var getmetadata = field.inputmask('getmetadata');
				var maskLength =
					(getmetadata.match(/9/g) || []).length +
					(getmetadata.match(/A/g) || []).length +
					(getmetadata.match(/'*'/g) || []).length;
				if (unMaskedValue.length != 0 && maskLength > unMaskedValue.length) {
					var errorInfo = app.translate('JS_INVALID_LENGTH');
					this.setError(errorInfo);
					window.inputMaskValidation = true;
					return false;
				} else {
					window.inputMaskValidation = false;
				}
			}
			if (window.inputMaskValidation) {
				var errorInfo = app.translate('JS_INVALID_LENGTH');
				this.setError(errorInfo);
				return false;
			}
			return true;
		}
	}
);

Base_Validator_Js(
	'Base_MaxSizeInByte_Validator_Js',
	{
		invokeValidation(field, rules, i, options) {
			const instance = new Base_MaxSizeInByte_Validator_Js();
			instance.setElement(field);
			if (instance.validate() != true) {
				return instance.getError();
			}
		}
	},
	{
		validate() {
			let response = this._super();
			if (response != true) {
				return response;
			}
			const field = this.getElement();
			const fieldValue = field.val();
			if (
				field.data('fieldinfo').maximumlength &&
				(typeof TextEncoder === 'function'
					? new TextEncoder().encode(fieldValue).byteLength > field.data('fieldinfo').maximumlength
					: fieldValue.length > field.data('fieldinfo').maximumlength)
			) {
				this.setError(app.translate('JS_MAXIMUM_TEXT_SIZE_IN_BYTES') + ' ' + field.data('fieldinfo').maximumlength);
				return false;
			}
			return true;
		}
	}
);

Base_Double_Validator_Js('Base_Advpercentage_Validator_Js', {});
