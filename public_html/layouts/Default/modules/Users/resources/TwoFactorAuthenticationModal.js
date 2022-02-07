/* {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_TwoFactorAuthenticationModal_JS = class {
	/**
	 * Function to register the click event for generate button
	 */
	registerSubmitEvent() {
		let methods = this.container.find('#methods');
		let code = this.container.find('#user_code');
		let secret = this.container.find('#secret');
		let form = this.container.find('form');
		form.validationEngine(app.validationEngineOptions);
		this.container.find('.js-modal__save').on('click', () => {
			if (form.validationEngine('validate')) {
				AppConnector.request({
					module: 'Users',
					action: 'TwoFactorAuthenticationModal',
					method: methods.val(),
					code: code.val(),
					secret: secret.val()
				})
					.done(function (responseData) {
						if (responseData['result']) {
							app.showNotify({
								text: responseData['result'],
								type: 'success'
							});
							app.hideModalWindow();
						}
					})
					.fail((error, title) => {
						app.showNotify({
							text: title,
							type: 'error'
						});
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
