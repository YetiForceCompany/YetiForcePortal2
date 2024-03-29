/* {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';
window.Documents_EditView_Js = class extends Base_EditView_Js {
	registerFileTypeChangeEvent() {
		const container = this.container.find('.js-file-upload-container'),
			fieldUrl = container.find('.js-file-upload-external'),
			fieldFile = container.find('.js-file-upload-internal');
		this.container.find('select[name="filelocationtype"]').on('change', (e) => {
			if (e.currentTarget.value === 'I') {
				fieldUrl.addClass('d-none').attr('disabled', 'disabled');
				fieldFile.removeClass('d-none').removeAttr('disabled');
			} else {
				fieldFile.addClass('d-none').attr('disabled', 'disabled');
				fieldUrl.removeClass('d-none').removeAttr('disabled');
			}
		});
	}
	/**
	 * Register form events.
	 */
	registerFormEvents() {
		super.registerFormEvents();
		this.registerFileTypeChangeEvent();
	}
};
