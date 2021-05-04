/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
window.Install_Install_Js = class {
	registerSave() {
		$('.js-install').on('click', () => {
			if ($('form').validationEngine('validate')) {
				params = $('form').serializeFormData();
				params.module = app.getModuleName();
				params.action = 'Install';
				const progressInstance = $.progressIndicatorShow();
				AppConnector.request(params).done((data) => {
					progressInstance.progressIndicator({ mode: 'hide' });
					if (typeof data.result.error !== 'undefined') {
						app.showNotify({
							text: data.result.error,
							type: 'error'
						});
					} else if (typeof data.result.url !== 'undefined') {
						app.openUrl(data.result.url);
					}
				});
			}
		});
	}
	registerEvents() {
		$('form').validationEngine(app.validationEngineOptions);
		this.registerSave();
		$('select[name="lang"]').on('change', (e) => {
			$('input[name="mode"]').val('step1');
			$('form').trigger('submit');
		});
	}
};
