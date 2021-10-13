/**
 * Base list view class
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
'use strict';

window.Base_ListView_Js = class {
	/**
	 * Register data table
	 */
	registerDataTable() {
		this.dataTable = app.registerDataTables(this.table, {
			order: [],
			processing: true,
			serverSide: true,
			searching: false,
			orderCellsTop: true,
			deferRender: true,
			ajax: {
				url: 'index.php',
				type: 'POST',
				data: (data) => {
					$.extend(data, this.listForm.serializeFormData());
				},
				error: function (jqXHR, ajaxOptions, thrownError) {
					app.errorLog(jqXHR, thrownError);
					app.showNotify({
						text: thrownError,
						type: 'error',
						stack: window.stackPage
					});
				}
			}
		});
		this.listForm.find('input,select').on('change', () => {
			this.dataTable.ajax.reload();
		});
	}
	/**
	 * Register records events
	 */
	registerListEvents() {
		const self = this;
		this.table.on('click', '.js-delete-record', (e) => {
			app.showNotifyConfirm(
				{
					title: app.translate('JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE')
				},
				function () {
					AppConnector.request({
						data: {},
						url: $(e.currentTarget).data('url')
					}).done((data) => {
						if (data.result) {
							self.dataTable.ajax.reload();
						}
					});
				}
			);
		});
		this.table.on('click', '.js-search-records', () => {
			this.dataTable.ajax.reload();
		});
		this.table.on('click', '.js-clear-search', () => {
			this.table.find('.js-filter-field').each(function () {
				this.value = '';
			});
			this.dataTable.ajax.reload();
		});
		this.table.on('click', 'tbody tr', function () {
			let element = jQuery(this);
			if (element.prop('tagName') !== 'A') {
				window.location.href = jQuery(this).find('.js-detail-view').attr('href');
			}
		});
	}
	/**
	 * Register custom view event
	 */
	registerCustomView() {
		let customFilter = this.listForm.find('.js-cv-list');
		App.Fields.Picklist.showSelect2ElementView(customFilter);
		customFilter.on('change', (_) => {
			$.progressIndicatorShow();
			this.reloadView(false);
		});
		this.listForm.on('click', '.js-filter-tab', (e) => {
			$.progressIndicatorShow();
			this.container.find('[name="cvId"]').val(e.currentTarget.dataset.cvid);
			this.reloadView(false);
		});
	}
	/**
	 * Reload view
	 * @param   {boolean}  onlyData
	 */
	reloadView(onlyData = true) {
		if (onlyData) {
			this.dataTable.ajax.reload();
		} else {
			window.location.href = app.convertObjectToUrl({
				module: this.container.find('#module').val(),
				view: this.container.find('#view').val(),
				cvId: this.container.find('[name="cvId"]').val()
			});
		}
	}
	/**
	 * Register tree.
	 */
	registerTree() {
		this.listForm.find('.js-tree-select').on('click', (e) => {
			let containerField = $(e.currentTarget).closest('.js-tree-content'),
				treeValueField = containerField.find('.js-tree-value'),
				fieldDisplayElement = containerField.find(`input[data-display="${treeValueField.attr('date-field-name')}"]`),
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
					console.log(treeValue.join(','));
					treeValueField.val(treeValue.join(','));
					treeValueField.trigger('change');
					app.hideModalWindow();
				});
			});
		});
		this.listForm.find('.js-tree-clear').on('click', (e) => {
			let containerField = $(e.currentTarget).closest('.js-tree-content'),
				treeValueField = containerField.find('.js-tree-value'),
				fieldDisplayElement = containerField.find(`input[data-display="${treeValueField.attr('date-field-name')}"]`);
			fieldDisplayElement.val('');
			fieldDisplayElement.attr('readonly', false);
			treeValueField.val('');
			treeValueField.trigger('change');
		});
	}
	/**
	 * Register modal events.
	 */
	registerEvents() {
		this.container = $('#page');
		this.listForm = $('.js-form-container');
		this.table = this.listForm.find('.js-list-view-table');
		this.registerDataTable();
		this.registerListEvents();
		this.registerTree();
		this.registerCustomView();
	}
};
