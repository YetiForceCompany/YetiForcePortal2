/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

window.Base_EditView_Js = class {
	constructor() {
		this.container = undefined;
		this.form = undefined;
	}
	/**
	 * Get container.
	 */
	getContainer() {
		if (this.container === undefined) {
			this.container = jQuery('.mainContent');
			this.form = this.container.find('form');
		}
		return this.container;
	}
	/**
	 * Register reference modal events.
	 */
	registerReferenceModalEvent() {
		this.form.on('click', '.relatedPopup', (e) => {
			let containerField = $(e.currentTarget).closest('.fieldValue');
			let url = 'index.php?module=' + this.getReferencedModuleName(containerField) + '&view=RecordList';
			app.getRecordList(url, function (selectedItems) {
				this.setReferenceFieldValue(containerField, selectedItems);
			});
		});
		this.form.find('.js-reference-list').on('change', (e) => {
			let element = $(e.currentTarget);
			let parentElem = element.closest('.fieldValue');
			let popupReferenceModule = element.val();
			let referenceModuleElement = $('input[name="popupReferenceModule"]', parentElem);
			let prevSelectedReferenceModule = referenceModuleElement.val();
			referenceModuleElement.val(popupReferenceModule);
			$('.js-quick-create', parentElem).data('moduleName', popupReferenceModule);
			if (prevSelectedReferenceModule != popupReferenceModule) {
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
		return $('input[name="popupReferenceModule"]', parenElement).val();
	}
	/**
	 * Register clear reference selection events.
	 */
	registerClearReferenceSelectionEvent() {
		this.form.on('click', '.js-clear-reference', (e) => {
			this.clearFieldValue($(e.currentTarget));
			e.preventDefault();
		});
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
		fieldValueContender
			.find('#' + fieldName + '_display')
			.removeAttr('readonly')
			.val('');
	}
	/**
	 * Set reference field value.
	 *
	 * @param {jQuery} container
	 * @param {object} params
	 */
	setReferenceFieldValue(container, params) {
		let sourceField = container.find('input.sourceField').attr('name');
		container.find('input[name="' + sourceField + '"]').val(params.id);
		container
			.find('input[name="' + sourceField + '_display"]')
			.val(params.name)
			.attr('readonly', true);
	}
	/**
	 * Register fields validations .
	 */
	registerFieldsValidations() {
		this.form.validationEngine(app.validationEngineOptions);
	}
	/**
	 * Register mask fields.
	 */
	registerMaskFields() {
		this.form.find(':input').inputmask();
	}
	/**
	 * Register record save.
	 */
	registerRecordSaveEvent() {
		this.form.on('submit', (e) => {
			if (this.form.validationEngine('validate') === true) {
				e.preventDefault();
				let formData = this.form.serializeFormData();
				AppConnector.request(formData).done((response) => {
					let data = JSON.parse(response);
					data = data.result;
					if (data.id) {
						window.location.href = 'index.php?module=' + app.getModuleName() + '&view=DetailView&record=' + data.id;
					} else {
						alert(data.message);
					}
				});
			} else {
				app.formAlignmentAfterValidation(formElement);
			}
		});
	}
	/**
	 * Register tree.
	 */
	registerTree() {
		this.form.find('.js-tree-select').on('click', (e) => {
			let containerField = $(e.currentTarget).closest('.js-tree-content'),
				treeValueField = containerField.find('.js-tree-value'),
				fieldDisplayElement = containerField.find('input[name="' + treeValueField.attr('name') + '_display"]'),
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
				fieldDisplayElement = containerField.find('input[name="' + treeValueField.attr('name') + '_display"]');
			fieldDisplayElement.val('');
			fieldDisplayElement.attr('readonly', false);
			treeValueField.val('');
		});
	}
	/**
	 * Register edit view events.
	 */
	registerEvents() {
		this.getContainer();
		this.registerReferenceModalEvent();
		this.registerClearReferenceSelectionEvent();
		this.registerFieldsValidations();
		this.registerMaskFields();
		this.registerRecordSaveEvent();
		this.registerTree();
		this.container.find('.js-form-submit').on('click', (e) => {
			this.form.submit();
		});
	}
};
