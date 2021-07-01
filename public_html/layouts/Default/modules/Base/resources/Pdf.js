/* {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_Pdf_JS = class {
	/**
	 * Function to register the click event for generate button
	 */
	registerSubmitEvent() {
		this.container.find('#pdfExportModal').on('submit', (e) => {
			const templateIds = [];
			this.container.find('[type="checkbox"].js-template').each(function () {
				if ($(this).is(':checked')) {
					templateIds.push($(this).val());
				}
			});
			this.container.find('[name="templates"]').val(JSON.stringify(templateIds));
		});
	}
	/**
	 * Validate submit button
	 */
	validateSubmit() {
		let disabled = true;
		this.container.find('[type="checkbox"].js-template').each(function () {
			if ($(this).prop('checked')) {
				disabled = false;
				return false;
			}
		});
		this.container.find('#generatePdf').attr('disabled', disabled);
	}
	/**
	 * Register validate submit
	 */
	registerValidateSubmit() {
		this.validateSubmit();
		this.container.find('[type="checkbox"].js-template').on('change', () => {
			this.validateSubmit();
		});
	}
	/**
	 * Register modal events.
	 * @param {jQuery} modalContainer
	 */
	registerEvents(modalContainer) {
		this.container = modalContainer;
		this.registerSubmitEvent();
		this.registerValidateSubmit();
	}
};
