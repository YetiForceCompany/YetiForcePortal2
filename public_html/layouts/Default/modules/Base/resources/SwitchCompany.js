/**
 * Switch company modal class
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author  Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
'use strict';

window.Base_SwitchCompany_JS = class {
	/**
	 * Function to register the submit event of form.
	 */
	registerSubmitEvent() {
		this.container.on('click', '.js-modal__save', (e) => {
			AppConnector.request({
				module: app.getModuleName(),
				action: 'ChangeCompany',
				record: this.container.find('#companyId').val()
			}).done(() => {
				window.location.href = 'index.php';
			});
			e.preventDefault();
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
