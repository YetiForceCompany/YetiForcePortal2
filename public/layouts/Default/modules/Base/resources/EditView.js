/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
jQuery.Class("Base_EditView_Js", {
}, {
	container: false,
	getContainer: function () {
		if (this.container == false) {
			this.container = jQuery('.mainContent');
		}
		return this.container;
	},
	referenceModulePopupRegisterEvent: function (container) {
		var thisInstance = this;
		if (container == undefined) {
			container = this.getContainer();
		}
		container.on('click', '.relatedPopup', function (e) {
			var element = jQuery(e.currentTarget);
			var containerField = element.closest('.fieldValue');
			var sourceField = containerField.find('.sourceField');
			var name = sourceField.attr('name');
			var label = sourceField.data('fieldLabel');

			var url = 'index.php?module=' + thisInstance.getReferencedModuleName(containerField) + '&view=ListView';
			var callbackFunction = function (data) {
				var list = new Base_ListView_Js();
				var table = list.registerDataTable();
				table.$('.listViewEntries tbody tr').off('click').on('click', function (e) {
					e.stopPropagation();
					e.preventDefault();
					if ($.contains(jQuery(e.currentTarget).find('td:first-child').get(0), e.target)) {
						return;
					}
					var tr = jQuery(e.currentTarget).closest('tr');
					var params = {
						id: tr.data('record'),
						name: tr.data('name')
					}
					thisInstance.setReferenceFieldValue(containerField, params);
					app.hideModalWindow();
				});
			}
			AppConnector.request(url).then(function (data) {
				if (data) {
					data = jQuery(data)//
					data.find('.widget_header').remove();
					var html = '<div class="modal fade modal' + name + '" id="modal' + name + '"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">\
				<button class="close" data-dismiss="modal" title="' + app.translate('LBL_CLOSE') + '">x</button>\
				<h3 class="modal-title">' + label + ' </h3>\
			</div>\
			<div class="modal-body">';
					html += data.html();
					html += '</div></div></div><div>';
					app.showModalWindow(html, callbackFunction);
				}
			}, function (e, err) {
				console.log([e, err])
			});
		});
		container.find('.referenceModulesList').chosen().change(function (e) {
			var element = jQuery(e.currentTarget);
			var parentElem = element.closest('.fieldValue');
			var popupReferenceModule = element.val();
			var referenceModuleElement = jQuery('input[name="popupReferenceModule"]', parentElem);
			var prevSelectedReferenceModule = referenceModuleElement.val();
			referenceModuleElement.val(popupReferenceModule);

			//If Reference module is changed then we should clear the previous value
			if (prevSelectedReferenceModule != popupReferenceModule) {
				parentElem.find('.clearReferenceSelection').trigger('click');
			}
		});
	},
	getReferencedModuleName: function (parenElement) {
		return jQuery('input[name="popupReferenceModule"]', parenElement).val();
	},
	registerClearReferenceSelectionEvent: function (container) {
		var thisInstance = this;
		container.on('click', '.clearReferenceSelection', function (e) {
			var element = jQuery(e.currentTarget);
			thisInstance.clearFieldValue(element);
			e.preventDefault();
		})
	},
	clearFieldValue: function (element) {
		var thisInstance = this;
		var fieldValueContener = element.closest('.fieldValue');
		var fieldNameElement = fieldValueContener.find('.sourceField');
		var fieldName = fieldNameElement.attr('name');
		var referenceModule = fieldValueContener.find('input[name="popupReferenceModule"]').val();
		var formElement = fieldValueContener.closest('form');

		fieldNameElement.val('');
		fieldValueContener.find('#' + fieldName + '_display').removeAttr('readonly').val('');
	},
	setReferenceFieldValue: function (container, params) {
		var thisInstance = this;
		var sourceField = container.find('input.sourceField').attr('name');
		var fieldElement = container.find('input[name="' + sourceField + '"]');
		var sourceFieldDisplay = sourceField + "_display";
		var fieldDisplayElement = container.find('input[name="' + sourceFieldDisplay + '"]');
		var popupReferenceModule = container.find('input[name="popupReferenceModule"]').val();

		var selectedName = params.name;
		var id = params.id;

		fieldElement.val(id)
		fieldDisplayElement.val(selectedName).attr('readonly', true);
	},
	registerValidationsFields: function (container) {
		var thisInstance = this;
		var params = app.validationEngineOptions;
		container.validationEngine(params);
	},
	registerMaskFields: function (container) {
		var thisInstance = this;
		container.find(":input").inputmask();
	},
	registerRecordSave: function (container) {
		var formElement = container.find('form');
		formElement.on('submit', function (e) {
			if (formElement.validationEngine('validate') === true) {
				e.preventDefault();
				var form = jQuery(e.currentTarget);
				var formData = form.serializeFormData();
				AppConnector.request(formData).then(function (data) {
					var data = JSON.parse(data);
					var response = data.result;
					if (response.id) {
						window.location.href = 'index.php?module=' + app.getModuleName() + '&view=DetailView&record=' + response.id;
					} else {
						alert(response.message);
					}
				}, function (e, err) {
					console.log([e, err])
				});
			}else{
				app.formAlignmentAfterValidation(formElement);
			}
		})
	},
	registerEvents: function () {
		var container = this.getContainer();
		container.find('form').validationEngine(app.validationEngineOptions);
		this.referenceModulePopupRegisterEvent();
		this.registerClearReferenceSelectionEvent(container);
		this.registerValidationsFields(container);
		this.registerMaskFields(container);
		this.registerRecordSave(container);

	}
});
