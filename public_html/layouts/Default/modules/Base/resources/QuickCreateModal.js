/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_QuickCreateModal_JS = class {
	/**
	 * Register edit view.
	 * @param {jQuery} modalContainer
	 */
	registerEditView() {
		let form = this.container.find('.js-edit-view-form');
		let moduleName = form.find('[name="module"]').val();
		let modalClass = moduleName + '_EditView_Js';
		if (typeof window[modalClass] === 'undefined') {
			modalClass = 'Base_EditView_Js';
		}
		if (typeof window[modalClass] !== 'undefined') {
			let instance = new window[modalClass]();
			instance.container = form;
			instance.form = form;
			instance.registerEvents();
		}
	}
	/**
	 * Register modal events.
	 * @param {jQuery} modalContainer
	 */
	registerEvents(modalContainer) {
		this.container = modalContainer;
		this.registerEditView();
	}
};
