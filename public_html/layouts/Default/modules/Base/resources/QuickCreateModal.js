/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_QuickCreateModal_JS = class {
	/**
	 * Register edit view.
	 * @param {jQuery} modalContainer
	 */
	registerEditView() {
		let form = this.container.find('.js-edit-view-form');
		this.editView = Base_EditView_Js.getInstanceByModuleName(form.find('[name="module"]').val());
		this.editView.container = form;
		this.editView.form = form;
		this.editView.registerFormEvents();
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
