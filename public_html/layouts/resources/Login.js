/* {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

'use strict';
window.Base_Login_Js = class {
	/**
	 *  Function sets the default language of the user
	 */
	registerDefaultLanguage() {
		this.container
			.find('[name="language"]')
			.find('option')
			.each(function () {
				let element = $(this);
				if (navigator.language.split('-', 1) === element.val().split('-', 1)) {
					element.attr('selected', true);
				}
			});
	}
	/**
	 * Register events.
	 */
	registerEvents() {
		this.container = $('form');
		this.registerDefaultLanguage();
	}
};
