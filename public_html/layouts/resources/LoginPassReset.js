/* {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

'use strict';
window.Base_LoginPassReset_Js = class {
	/**
	 * Function to register the click event for generate button
	 */
	registerSubmitEvent() {
		this.container.on('submit', (event) => {
			let password = this.container.find('[name="password"]').val();
			let confirmPassword = this.container.find('[name="confirm_password"]').val();
			if (password !== confirmPassword) {
				event.preventDefault();
				$('.js-alert-confirm-password').removeClass('d-none');
			}
		});
	}
	/**
	 * Register events.
	 */
	registerEvents() {
		this.container = $('form');
		this.registerSubmitEvent();
	}
};
