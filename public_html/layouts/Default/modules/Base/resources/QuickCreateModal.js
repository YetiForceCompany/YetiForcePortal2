/**
 * Base quick create modal class
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
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
