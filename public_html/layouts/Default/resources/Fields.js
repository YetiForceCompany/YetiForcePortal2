/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

window.App.Fields = {
	'Picklist':	{
		/**
		 * Function which will convert ui of select boxes.
		 * @params parent - select element
		 * @params view - select2
		 * @params viewParams - select2 params
		 * @returns jquery object list which represents changed select elements
		 */
		changeSelectElementView: function (parent, view, viewParams) {
			if (typeof parent === "undefined") {
				parent = $('body');
			}
			if (typeof view === "undefined") {
				const select2Elements = $('select.select2', parent).toArray();
				select2Elements.forEach((elem) => {
					this.changeSelectElementView($(elem), 'select2', viewParams);
				});
				return;
			}
			//If view is select2, This will convert the ui of select boxes to select2 elements.
			if (view === 'select2') {
				return App.Fields.Picklist.showSelect2ElementView(parent, viewParams);
			} else {
				app.errorLog(new Error(`Unknown select type [${view}]`));
			}
		}
		,
		/**
		 * Function which will show the select2 element for select boxes . This will use select2 library
		 */
		showSelect2ElementView: function (selectElement, params) {
			let self = this;
			selectElement = $(selectElement);
			if (typeof params === "undefined") {
				params = {};
			}
			if ($(selectElement).length > 1) {
				return $(selectElement).each((index, element) => {
					this.showSelect2ElementView($(element).eq(0), params);
				});
			}
			if (typeof params.dropdownParent === 'undefined') {
				const modalParent = $(selectElement).closest('.modal-body');
				if (modalParent.length) {
					params.dropdownParent = modalParent;
				}
			}
			let data = selectElement.data();
			if (data != null) {
				params = $.extend(data, params);
			}
			params.language = {};
			params.theme = "bootstrap";
			const width = $(selectElement).data('width');
			if (typeof width !== "undefined") {
				params.width = width;
			} else {
				params.width = '100%';
			}
			params.containerCssClass = 'form-control w-100';
			const containerCssClass = selectElement.data('containerCssClass');
			if (typeof containerCssClass !== "undefined") {
				params.containerCssClass += " " + containerCssClass;
			}
			params.language.noResults = function (msn) {
				return app.translate('JS_NO_RESULTS_FOUND');
			};

			// Sort DOM nodes alphabetically in select box.
			if (typeof params['customSortOptGroup'] !== "undefined" && params['customSortOptGroup']) {
				$('optgroup', selectElement).each(function () {
					var optgroup = $(this);
					var options = optgroup.children().toArray().sort(function (a, b) {
						var aText = $(a).text();
						var bText = $(b).text();
						return aText < bText ? 1 : -1;
					});
					$.each(options, function (i, v) {
						optgroup.prepend(v);
					});
				});
				delete params['customSortOptGroup'];
			}

			//formatSelectionTooBig param is not defined even it has the maximumSelectionLength,
			//then we should send our custom function for formatSelectionTooBig
			if (typeof params.maximumSelectionLength !== "undefined" && typeof params.formatSelectionTooBig === "undefined") {
				var limit = params.maximumSelectionLength;
				//custom function which will return the maximum selection size exceeds message.
				var formatSelectionExceeds = function (limit) {
					// return app.translate('JS_YOU_CAN_SELECT_ONLY') + ' ' + limit.maximum + ' ' + app.translate('JS_ITEMS');
				}
				params.language.maximumSelected = formatSelectionExceeds;
			}
			if (typeof selectElement.attr('multiple') !== "undefined" && !params.placeholder) {
				//params.placeholder = app.translate('JS_SELECT_SOME_OPTIONS');
			} else if (!params.placeholder) {
				//params.placeholder = app.translate('JS_SELECT_AN_OPTION');
			}
			if (typeof params.templateResult === "undefined") {
				params.templateResult = function (data, container) {
					if (data.element && data.element.className) {
						$(container).addClass(data.element.className);
					}
					if (typeof data.name === "undefined") {
						return data.text;
					}
					if (data.type == 'optgroup') {
						return '<strong>' + data.name + '</strong>';
					} else {
						return '<span>' + data.name + '</span>';
					}
				};
			}
			if (typeof params.templateSelection === "undefined") {
				params.templateSelection = function (data, container) {
					if (data.element && data.element.className) {
						$(container).addClass(data.element.className);
					}
					if (data.text === '') {
						return data.name;
					}
					return data.text;
				};
			}
			if (selectElement.data('ajaxSearch') === 1) {
				params.tags = false;
				// params.language.searching = function () {
				// 	return app.translate('JS_SEARCHING');
				// }
				// params.language.inputTooShort = function (args) {
				// 	var remainingChars = args.minimum - args.input.length;
				// 	return app.translate('JS_INPUT_TOO_SHORT').replace("_LENGTH_", remainingChars);
				// }
				// params.language.errorLoading = function () {
				// 	return app.translate('JS_NO_RESULTS_FOUND');
				// }
				params.placeholder = '';
				params.ajax = {
					url: selectElement.data('ajaxUrl'),
					dataType: 'json',
					delay: 250,
					method: 'POST',
					data: function (params) {
						return {
							value: params.term, // search term
							page: params.page
						};
					},
					processResults: function (data, params) {
						var items = new Array;
						if (data.success == true) {
							selectElement.find('option').each(function () {
								var currentTarget = $(this);
								items.push({
									label: currentTarget.html(),
									value: currentTarget.val(),
								});
							});
							items = items.concat(data.result.items);
						}
						return {
							results: items,
							pagination: {
								more: false
							}
						};
					},
					cache: false
				};
				params.escapeMarkup = function (markup) {
					if (markup !== "undefined")
						return markup;
				};
				var minimumInputLength = 3;
				if (selectElement.data('minimumInput') !== "undefined") {
					minimumInputLength = selectElement.data('minimumInput');
				}
				params.minimumInputLength = minimumInputLength;
				params.templateResult = function (data) {
					if (typeof data.name === "undefined") {
						return data.text;
					}
					if (data.type == 'optgroup') {
						return '<strong>' + data.name + '</strong>';
					} else {
						return '<span>' + data.name + '</span>';
					}
				};
				params.templateSelection = function (data, container) {
					if (data.text === '') {
						return data.name;
					}
					return data.text;
				};
			}
			selectElement.each(function (e) {
				var select = $(this);
				if (select.attr('readonly') == 'readonly' && !select.attr('disabled')) {
					var selectNew = select.clone().addClass('d-none');
					select.parent().append(selectNew);
					select.prop('disabled', true);
				}
				let htmlBoolParams = select.data('select');
				if (htmlBoolParams === 'tags') {
					params.tags = true;
					params.tokenSeparators = [","]
				} else {
					params[htmlBoolParams] = true;
				}
				select.select2(params)
					.on("select2:open", function (e) {
						if (select.data('unselecting')) {
							select.removeData('unselecting');
							setTimeout(function (e) {
								select.each(function () {
									$(this).select2('close');
								});
							}, 1);
						}
						var element = $(e.currentTarget);
						var instance = element.data('select2');
						instance.$dropdown.css('z-index', 1000002);
					}).on("select2:unselect", function (e) {
					select.data('unselecting', true);
				});

				if (select.hasClass('js-select2-sortable')) {
					self.registerSelect2Sortable(select, params.sortableCb);
				}
			})

			return selectElement;
		}
		,
		/**
		 * Register select2 drag and drop sorting
		 * @param {jQuery} select2 element
		 * @param {function} callback function
		 */
		registerSelect2Sortable(select, cb = () => {
		}) {
			let ul = select.next('.select2-container').first('ul.select2-selection__rendered');
			ul.sortable({
				items: 'li:not(.select2-search__field)',
				tolerance: 'pointer',
				stop: function () {
					$(ul.find('.select2-selection__choice').get().reverse()).each(function () {
						let optionTitle = $(this).attr('title');
						select.find('option').each(function () {
							if ($(this).text() === optionTitle) {
								select.prepend($(this));
							}
						});
					});
					cb(select);
				}
			});
		}
	},
	'Tree':	class {
		constructor(treeContainer = $('.js-tree-container')) {
			if( treeContainer.length > 0 ){
				this.treeInstance = treeContainer;
				this.onSelectNode = this.treeInstance.data('onSelectNode');
				this.loadTree();
			}
		}
		/**
		 * Get instance of Tree.
		 * @returns {Tree}
		 */
		static getInstance(container = $('.js-tree-container')) {
			if (typeof window.App.Fields.Tree.instance === 'undefined') {
				window.App.Fields.Tree.instance = new window.App.Fields.Tree(container);
			}
			return window.App.Fields.Tree.instance;
		}
		loadTree() {
			this.generateTree(JSON.parse(this.treeInstance.find('.js-tree-data').val()));
		}
		generateTree(treeData) {
			this.treeInstance.on('select_node.jstree', (e, data)=>{
				(new Function('return ' + this.onSelectNode)())(e, data, this.treeInstance);
			}).on('ready.jstree', ()=>{

			}).jstree({ 'core' : {
				data: treeData,
				themes: {
					name: 'proton',
					responsive: true
				},
				checkbox: {
					three_state: true,
				},
				multiple: true,
			} });
		}
	}
};
