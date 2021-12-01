/**
 * Base edit view class
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
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
			let formData = this.form.serializeFormData();
			for (let i in formData) {
				if (!formData[i] || $.inArray(i, ['_csrf', 'action', '_fromView']) != -1) {
					delete formData[i];
				}
			}
			App.Components.QuickCreate.createRecord(moduleName, {
				data: {
					sourceRecordData: formData
				},
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
			let url = 'index.php?module=' + this.getReferencedModuleName(containerField) + '&view=RecordListModal';
			app.getRecordList(url, (e) => {
				this.setReferenceFieldValue(containerField, {
					id: e.currentTarget.dataset.id,
					name: e.currentTarget.dataset.name
				});
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
		fieldValueContender.find(`input[data-display="${fieldName}"]`).val('');
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
		fieldContainer.find(`input[data-display="${sourceField}"]`).val(params.name);
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
					if (selectedCategories.length != 0) {
						let treeText = [];
						let treeValue = [];
						$.each(selectedCategories, (index, value) => {
							treeValue.push(value['original']['tree']);
							treeText.push(value['text']);
						});
						fieldDisplayElement.val(treeText.join(','));
						fieldDisplayElement.attr('readonly', true);
						treeValueField.val(treeValue.join(','));
						app.hideModalWindow('', modalContainer.data('modalId'));
						PNotify.defaultStack.close();
					} else {
						app.showNotify({
							text: app.translate('JS_PLEASE_SELECT_ATLEAST_ONE_OPTION'),
							type: 'error'
						});
					}
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

		let beforeSaveResult = callbackBeforeSave(this.form.serializeFormData());
		if (beforeSaveResult === false) {
			progress.progressIndicator({ mode: 'hide' });
			return;
		}

		let formData = new FormData(this.form[0]);
		AppConnector.request({
			url: 'index.php',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false
		})
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
			.fail(function (textStatus, errorThrown, jqXHR) {
				progress.progressIndicator({ mode: 'hide' });
				callbackAfterSave(false);
				app.showNotify({
					type: 'error',
					title: app.translate('JS_ERROR'),
					text: jqXHR.responseJSON.error.message,
					animation: 'show'
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
	 * Register keyboard shortcuts events
	 */
	registerKeyboardShortcutsEvent() {
		document.addEventListener('keydown', (event) => {
			if (event.altKey && event.code === 'KeyS') {
				this.container.find('.js-edit-view-submit, .js-form-submit').trigger('click');
			}
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
		this.registerKeyboardShortcutsEvent();
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
