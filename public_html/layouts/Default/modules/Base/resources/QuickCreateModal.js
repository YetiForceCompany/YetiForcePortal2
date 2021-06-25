/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_QuickCreateModal_JS = class {
	/**
	 * Register edit view.
	 * @param {jQuery} modalContainer
	 */
	registerEditView() {
		let form = this.container.find('.js-edit-view-form');
		let instance = Base_EditView_Js.getInstanceByModuleName(form.find('[name="module"]').val());
		instance.container = form;
		instance.form = form;
		instance.registerEvents();
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
