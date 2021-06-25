/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_EditView_Js = class {
	/**
	 * Function to get Instance by name
	 *
	 * @param {string} moduleName Name of the module to create instance
	 *
	 * @returns {Base_EditView_Js}
	 */
	static getInstanceByModuleName(moduleName) {
		if (typeof moduleName === 'undefined') {
			moduleName = app.getModuleName();
		}
		let modalClass = moduleName + '_EditView_Js',
			instance;
		if (typeof window[modalClass] === 'undefined') {
			modalClass = 'Base_EditView_Js';
		}
		if (typeof window[modalClass] !== 'undefined') {
			instance = new window[modalClass]();
		}
		instance.moduleName = moduleName;
		return instance;
	}
	/**
	 * Constructor.
	 */
	constructor() {
		this.container = undefined;
		this.form = undefined;
		this.moduleName = undefined;
	}
	/**
	 * Get container.
	 */
	getContainer() {
		if (this.container === undefined) {
			this.container = jQuery('.mainContent');
			this.form = this.container.find('form');
			this.moduleName = this.form.find('[name="module"]').val();
		}
		return this.container;
	}
	/**
	 * Register reference events.
	 */
	registerReferenceEvent() {
		this.form.on('click', '.js-add-reference', (e) => {
			let element = $(e.currentTarget);
			let moduleName = element.data('moduleName');
			let containerField = element.closest('.fieldValue');
			App.Components.QuickCreate.createRecord(moduleName, {
				callbackAfterSave: (response) => {
					this.setReferenceFieldValue(containerField, response);
				}
			});
		});
		this.form.on('click', '.js-clear-reference', (e) => {
			this.clearFieldValue($(e.currentTarget));
		});
		this.form.on('click', '.js-select-reference', (e) => {
			let containerField = $(e.currentTarget).closest('.fieldValue');
			let url = 'index.php?module=' + this.getReferencedModuleName(containerField) + '&view=RecordList';
			app.getRecordList(url, function (selectedItems) {
				this.setReferenceFieldValue(containerField, selectedItems);
			});
		});
		this.form.find('.js-reference-list').on('change', (e) => {
			let element = $(e.currentTarget);
			let parentElem = element.closest('.fieldValue');
			let referenceModule = element.val();
			let referenceModuleElement = $('.js-reference-module', parentElem);
			let prevSelectedReferenceModule = referenceModuleElement.val();
			referenceModuleElement.val(referenceModule);
			$('.js-quick-create', parentElem).data('moduleName', referenceModule);
			if (prevSelectedReferenceModule != referenceModule) {
				//If Reference module is changed then we should clear the previous value
				parentElem.find('.js-clear-reference').trigger('click');
			}
		});
	}
	/**
	 * Get referenced module name.
	 *
	 * @param {jQuery} parenElement
	 */
	getReferencedModuleName(parenElement) {
		return $('.js-reference-module', parenElement).val();
	}
	/**
	 * Clear field value.
	 *
	 * @param {jQuery} element
	 */
	clearFieldValue(element) {
		let fieldValueContender = element.closest('.fieldValue');
		let fieldNameElement = fieldValueContender.find('.sourceField');
		let fieldName = fieldNameElement.attr('name');
		fieldNameElement.val('');
		fieldValueContender.find(`input[data-display="${fieldName}"]`).removeAttr('readonly').val('');
	}
	/**
	 * Set reference field value.
	 *
	 * @param {jQuery} fieldContainer
	 * @param {object} params
	 */
	setReferenceFieldValue(fieldContainer, params) {
		let sourceField = fieldContainer.find('input.sourceField').attr('name');
		fieldContainer.find('input[name="' + sourceField + '"]').val(params.id);
		fieldContainer.find(`input[data-display="${sourceField}"]`).val(params.name).attr('readonly', true);
	}
	/**
	 * Register fields validations .
	 */
	registerFieldsValidations() {
		this.form.validationEngine(app.validationEngineOptions);
	}
	/**
	 * Register tree.
	 */
	registerTree() {
		this.form.find('.js-tree-select').on('click', (e) => {
			let containerField = $(e.currentTarget).closest('.js-tree-content'),
				treeValueField = containerField.find('.js-tree-value'),
				fieldDisplayElement = containerField.find(`input[data-display="${treeValueField.attr('name')}"]`),
				multiple = treeValueField.data('multiple');
			app.showModalWindow(containerField.find('.js-tree-modal-window').clone(), function (modalContainer) {
				let jstreeInstance = modalContainer.find('.js-tree-jstree');
				if (multiple === 1) {
					new window.App.Fields.MultiTree(jstreeInstance);
				} else {
					new window.App.Fields.Tree(jstreeInstance);
				}
				modalContainer.find('.js-tree-modal-select').on('click', function () {
					let selectedCategories = [];
					$.each(jstreeInstance.jstree('get_selected', true), (index, value) => {
						selectedCategories.push(value);
					});
					let treeText = [];
					let treeValue = [];
					$.each(selectedCategories, (index, value) => {
						treeValue.push(value['original']['tree']);
						treeText.push(value['text']);
					});
					fieldDisplayElement.val(treeText.join(','));
					fieldDisplayElement.attr('readonly', true);
					treeValueField.val(treeValue.join(','));
					app.hideModalWindow();
				});
			});
		});
		this.form.find('.js-tree-clear').on('click', (e) => {
			let containerField = $(e.currentTarget).closest('.js-tree-content'),
				treeValueField = containerField.find('.js-tree-value'),
				fieldDisplayElement = containerField.find(`input[data-display="${treeValueField.attr('name')}"]`);
			fieldDisplayElement.val('');
			fieldDisplayElement.attr('readonly', false);
			treeValueField.val('');
		});
	}
	/**
	 * Save record
	 */
	save(params) {
		if (!this.form.validationEngine('validate')) {
			app.formAlignmentAfterValidation(this.form);
			return;
		}
		const callbackBeforeSave = params.callbackBeforeSave || function () {};
		const callbackAfterSave = params.callbackAfterSave || function () {};
		let progress = $.progressIndicator({
			message: app.translate('JS_SAVE_LOADER_INFO'),
			position: 'html',
			blockInfo: {
				enabled: true
			}
		});
		let formData = this.form.serializeFormData();
		let beforeSaveResult = callbackBeforeSave(formData);
		if (beforeSaveResult === false) {
			progress.progressIndicator({ mode: 'hide' });
			return;
		}
		AppConnector.request(formData)
			.done((response) => {
				progress.progressIndicator({ mode: 'hide' });
				if (response.success) {
					app.showNotify({
						text: app.translate('JS_SAVE_NOTIFY_SUCCESS'),
						type: 'success'
					});
				}
				callbackAfterSave(response['result']);
			})
			.fail(function (textStatus, errorThrown) {
				callbackAfterSave(false);
				app.showNotify({
					text: errorThrown,
					title: app.translate('JS_ERROR'),
					type: 'error'
				});
			});
	}
	/**
	 * Register edit view events
	 */
	registerEditViewEvents() {
		this.registerSubmit({
			callbackAfterSave: (response) => {
				if (response) {
					window.location.href = 'index.php?module=' + this.moduleName + '&view=DetailView&record=' + response.id;
				}
			}
		});
		this.container.find('.js-edit-back').on('click', () => {
			window.history.back();
		});
	}
	registerSubmit(params) {
		this.container.find('.js-edit-view-submit, .js-form-submit').on('click', () => {
			this.save(params);
		});
	}
	/**
	 * Register form events.
	 */
	registerFormEvents() {
		this.getContainer();
		this.registerReferenceEvent();
		this.registerFieldsValidations();
		this.registerTree();
		this.form.find(':input').inputmask();
	}
	/**
	 * Register edit view events.
	 */
	registerEvents() {
		this.getContainer();
		this.registerFormEvents();
		this.registerEditViewEvents();
	}
};
