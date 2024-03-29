/**
 * Password change modal class
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
'use strict';

window.Base_PasswordChangeModal_JS = class {
	/**
	 * Function to register the submit event of form.
	 */
	registerSubmitEvent() {
		let formElement = this.container.find('form');
		formElement.validationEngine(app.validationEngineOptions);
		formElement.on('submit', function (e) {
			e.preventDefault();
			formElement.validationEngine('showPrompt', '', '', 'topLeft', true);
			if (formElement.validationEngine('validate') === true) {
				let formData = formElement.serializeFormData();
				AppConnector.request(formData).done((data) => {
					if (data.success === true) {
						app.showNotify({
							text: data.result,
							type: 'success'
						});
						app.hideModalWindow();
					}
				});
			}
		});
	}

	/**
	 * Register modal events.
	 * @param {jQuery} modalContainer
	 */
	registerEvents(modalContainer) {
		this.container = modalContainer;
		this.registerSubmitEvent();
	}
};
