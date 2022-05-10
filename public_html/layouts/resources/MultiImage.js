/* {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

class MultiImage {
	/**
	 * Create class instance
	 *
	 * @param {HTMLElement|jQuery} inputElement - input type file element inside component
	 */
	constructor(element) {
		const thisInstance = this;
		this.elements = {};
		this.options = {
			showCarousel: true
		};
		this.detailView = false;
		this.elements.fileInput = element.find('.js-multi-image__file').eq(0);
		if (this.elements.fileInput.length === 0) {
			this.detailView = true;
		}
		this.elements.component = element.eq(0);
		this.elements.form = element.closest('form').eq(0);
		this.elements.addButton = this.elements.component.find('.js-multi-image__file-btn').eq(0);
		this.elements.values = this.elements.component.find('.js-multi-image__values').eq(0);
		this.elements.progressBar = this.elements.component.find('.js-multi-image__progress-bar').eq(0);
		this.elements.progress = this.elements.component.find('.js-multi-image__progress').eq(0);
		this.elements.result = this.elements.component.find('.js-multi-image__result').eq(0);
		this.fieldInfo = this.elements.values.data('fieldinfo');
		this.options.formats = this.fieldInfo.formats;
		this.options.limit = this.fieldInfo.limit;
		if (!this.detailView) {
			this.files = JSON.parse(this.elements.values.val());
		} else {
			this.files = this.elements.values.data('value');
		}
		if (!this.detailView) {
			this.elements.fileInput.fileupload({
				dataType: 'json',
				replaceFileInput: false,
				fileInput: this.fileInput,
				autoUpload: false,
				add: this.add.bind(this),
				change: this.change.bind(this),
				fail: this.uploadError.bind(this)
			});
		}
		this.elements.component.on('click', '.js-multi-image__popover-img', function (e) {
			thisInstance.zoomPreview($(this).data('hash'));
		});
		this.elements.component.on('click', '.js-multi-image__popover-btn-zoom', function (e) {
			e.preventDefault();
			thisInstance.zoomPreview($(this).data('hash'));
		});
		this.elements.component.on('click', '.js-multi-image__popover-btn-download', function (e) {
			e.preventDefault();
			thisInstance.download($(this).data('hash'));
		});
		if (!this.detailView) {
			this.elements.component.on('click', '.js-multi-image__popover-btn-delete', function (e) {
				e.preventDefault();
				thisInstance.deleteFile($(this).data('hash'));
			});
		}
		this.loadExistingFiles();
	}

	/**
	 * Prevent form submission
	 *
	 * @param {Event} e
	 */
	addButtonClick(e) {
		e.preventDefault();
		this.elements.fileInput.trigger('click');
	}

	/**
	 * Get file information
	 *
	 * @param {String} hash - file id
	 * @returns {Object}
	 */
	getFileInfo(hash) {
		for (let i = 0, len = this.files.length; i < len; i++) {
			const file = this.files[i];
			if (file.hash === hash) {
				return file;
			}
		}
		app.errorLog(`File '${hash}' not found.`);
		app.showNotify({
			text: app.translate('JS_INVALID_FILE_HASH') + ` [${hash}]`,
			type: 'error'
		});
	}

	/**
	 * Add property to file info object
	 *
	 * @param {String} hash - file id
	 * @param {String} propertyName
	 * @param {any} value
	 * @returns {Object}
	 */
	addFileInfoProperty(hash, propertyName, value) {
		const fileInfo = this.getFileInfo(hash);
		fileInfo[propertyName] = value;
		return fileInfo;
	}

	/**
	 * Error event handler from file upload request
	 *
	 * @param {Event} e
	 * @param {Object} data
	 */
	uploadError(e, data) {
		app.errorLog('File upload error.');
		const { jqXHR, files } = data;
		if (typeof jqXHR.responseJSON === 'undefined' || jqXHR.responseJSON === null) {
			App.Fields.MultiImage.currentFileUploads--;
			return app.showNotify({
				text: app.translate('JS_FILE_UPLOAD_ERROR'),
				type: 'error'
			});
		}
		const response = jqXHR.responseJSON;
		// first try to show error for concrete file
		if (
			typeof response.result !== 'undefined' &&
			typeof response.result.attach !== 'undefined' &&
			Array.isArray(response.result.attach)
		) {
			response.result.attach.forEach((fileAttach) => {
				App.Fields.MultiImage.currentFileUploads--;
				this.deleteFile(fileAttach.hash, false);
				if (typeof fileAttach.error === 'string') {
					app.showNotify({
						text: fileAttach.error + ` [${fileAttach.name}]`,
						type: 'error'
					});
				} else {
					app.showNotify({
						text: app.translate('JS_FILE_UPLOAD_ERROR') + ` [${fileAttach.name}]`,
						type: 'error'
					});
				}
			});
			this.updateFormValues();
			return;
		}
		// else show default upload error
		files.forEach((file) => {
			App.Fields.MultiImage.currentFileUploads--;
			this.deleteFile(file.hash, false);
			app.showNotify({
				text: app.translate('JS_FILE_UPLOAD_ERROR') + ` [${file.name}]`,
				type: 'error'
			});
		});
		this.updateFormValues();
	}

	/**
	 * Update form input values
	 */
	updateFormValues() {
		const formValues = this.files.map((file) => {
			return { key: file.key, name: file.name, size: file.size };
		});
		this.elements.values.val(JSON.stringify(formValues));
	}

	/**
	 * Validate file
	 *
	 * @param {Object} file
	 * @returns {boolean}
	 */
	validateFile(file) {
		let valid = false;
		this.options.formats.forEach((format) => {
			if (file.type === 'image/' + format) {
				valid = true;
			}
		});
		if (!valid) {
			app.showNotify({
				text: `${app.translate('JS_INVALID_FILE_TYPE')} [${file.name}]\n${app.translate(
					'JS_AVAILABLE_FILE_TYPES'
				)}  [${this.options.formats.join(', ')}]`,
				type: 'error'
			});
		}
		return valid;
	}

	/**
	 * Show limit error
	 */
	showLimitError() {
		this.elements.fileInput.val('');
		app.showNotify({
			text: `${app.translate('JS_FILE_LIMIT')} [${this.options.limit}]`,
			type: 'error'
		});
	}

	/**
	 * Get only valid files from list
	 *
	 * @param {Array} files
	 * @returns {Array}
	 */
	filterValidFiles(files) {
		if (files.length + this.files.length > this.options.limit) {
			this.showLimitError();
			return [];
		}
		return files.filter((file) => {
			return this.validateFile(file);
		});
	}

	/**
	 * Set files hash
	 * @param {Array} files
	 * @returns {Array}
	 */
	setFilesHash(files) {
		const addedFiles = [];
		for (let i = 0, len = files.length; i < len; i++) {
			const file = files[i];
			if (typeof file.hash === 'undefined') {
				if (this.files.length < this.options.limit) {
					file.hash = this.generateRandomHash(CONFIG.userId);
					this.files.push({ hash: file.hash, imageSrc: file.imageSrc, name: file.name, file });
					addedFiles.push(file);
				} else {
					this.showLimitError();
					return addedFiles;
				}
			}
		}
		return addedFiles;
	}

	/**
	 * Add event handler from jQuery-file-upload
	 *
	 * @param {Event} e
	 * @param {object} data
	 */
	add(e, data) {
		return;
	}

	/**
	 * Progressall event handler from jQuery-file-upload
	 *
	 * @param {Event} e
	 * @param {Object} data
	 */
	progressAll(e, data) {
		const progress = parseInt((data.loaded / data.total) * 100, 10);
		this.elements.progressBar.css({ width: progress + '%' });
		if (progress === 100) {
			setTimeout(() => {
				this.elements.progress.addClass('d-none');
				this.elements.progressBar.css({ width: '0%' });
			}, 1000);
		} else {
			this.elements.progress.removeClass('d-none');
		}
	}

	/**
	 * Dragover event handler from jQuery-file-upload
	 *
	 * @param {Event} e
	 */
	dragOver(e) {
		this.elements.component.addClass('c-multi-image__drop-effect');
	}

	/**
	 * Dragleave event handler
	 * @param {Event} e
	 */
	dragLeave(e) {
		this.elements.component.removeClass('c-multi-image__drop-effect');
	}

	/**
	 * Download file according to source type (base64/file from server)
	 *
	 * @param {String} hash
	 */
	download(hash) {
		const fileInfo = this.getFileInfo(hash);
		if (fileInfo.imageSrc.substr(0, 8).toLowerCase() === 'file.php') {
			return this.downloadFile(hash);
		} else {
			return this.downloadBase64(hash);
		}
	}

	/**
	 * Download file that exists on the server already
	 * @param {String} hash
	 */
	downloadFile(hash) {
		const fileInfo = this.getFileInfo(hash);
		const link = document.createElement('a');
		$(link).css('display', 'none');
		if (typeof link.download === 'string') {
			document.body.appendChild(link); // Firefox requires the link to be in the body
			link.download = fileInfo.name;
			link.href = fileInfo.imageSrc;
			link.click();
			document.body.removeChild(link); // remove the link when done
		} else {
			location.replace(fileInfo.imageSrc);
		}
	}

	/**
	 * Download file from base64 image
	 *
	 * @param {String} hash
	 */
	downloadBase64(hash) {
		const fileInfo = this.getFileInfo(hash);
		const imageUrl =
			`data:application/octet-stream;filename=${fileInfo.name};base64,` + fileInfo.imageSrc.split(',')[1];
		const link = document.createElement('a');
		$(link).css('display', 'none');
		if (typeof link.download === 'string') {
			document.body.appendChild(link); // Firefox requires the link to be in the body
			link.download = fileInfo.name;
			link.href = imageUrl;
			link.click();
			document.body.removeChild(link); // remove the link when done
		} else {
			location.replace(imageUrl);
		}
	}

	/**
	 * Display modal window with large preview
	 *
	 * @param {string} hash
	 */
	zoomPreview(hash) {
		const self = this;
		let fileInfo = this.getFileInfo(hash);
		const titleTemplate = () => {
			const titleObject = document.createElement('span');
			const icon = document.createElement('i');
			icon.setAttribute('class', `fa fa-image`);
			titleObject.appendChild(icon);
			titleObject.appendChild(document.createTextNode(` ${fileInfo.name}`));
			return titleObject.innerHTML;
		};

		let buttons = [];
		if (!self.detailView) {
			buttons.push({
				text: app.translate('JS_DELETE'),
				icon: 'fa fa-trash-alt',
				class: 'float-left btn btn-danger js-delete'
			});
		}
		buttons.push(
			{
				text: app.translate('JS_DOWNLOAD'),
				icon: 'fa fa-download',
				class: 'float-left btn btn-success js-success'
			},
			{
				text: app.translate('JS_CLOSE'),
				icon: 'fa fa-times',
				class: 'btn btn-warning',
				data: { dismiss: 'modal' }
			}
		);
		app.showModalHtml({
			class: 'modal-lg',
			header: titleTemplate(),
			footerButtons: buttons,
			body: self.options.showCarousel
				? self.generateCarousel(hash)
				: `<img src="${fileInfo.imageSrc}" class="w-100" />`,
			cb: (modal) => {
				modal.on('click', '.js-delete', function () {
					self.deleteFile(fileInfo.hash);
					app.hideModalWindow();
				});
				modal.on('click', '.js-success', function () {
					self.download(fileInfo.hash);
					app.hideModalWindow();
				});
				if (self.options.showCarousel) {
					modal.find(`#carousel-${hash}`).on('slid.bs.carousel', (e) => {
						fileInfo = self.getFileInfo($(e.relatedTarget).data('hash'));
						modal.find('.js-modal-title').html(titleTemplate());
					});
				}
			}
		});
	}

	/**
	 * Remove file from preview and from file list
	 *
	 * @param {String} hash
	 */
	deleteFileCallback(hash) {
		const fileInfo = this.getFileInfo(hash);
		if (fileInfo.previewElement) {
			fileInfo.previewElement.popover('dispose').remove();
		}
		this.files = this.files.filter((file) => file.hash !== fileInfo.hash);
		this.updateFormValues();
	}

	/**
	 * Delete image from input field
	 * Should be called with this pointing on button element with data-hash attribute
	 *
	 * @param {string} hash
	 * @param {boolean} showConfirmation - dialog?
	 */
	deleteFile(hash, showConfirmation = true) {
		if (showConfirmation) {
			const fileInfo = this.getFileInfo(hash);
			app.showConfirmModal({
				title: fileInfo.name,
				text: app.translate('JS_DELETE_FILE_CONFIRMATION'),
				titleTrusted: false,
				icon: 'fa fa-trash-alt',
				confirmedCallback: () => {
					this.deleteFileCallback(hash);
				}
			});
		} else {
			this.deleteFileCallback(hash);
		}
	}

	/**
	 * File change event handler from jQuery-file-upload
	 *
	 * @param {Event} e
	 * @param {object} data
	 */
	change(e, data) {
		this.clearFilesInput();
		data.files = this.filterValidFiles(data.files);
		data.files = this.setFilesHash(data.files);
		if (data.files.length) {
			this.generatePreviewElements(data.files, (element) => {
				this.redraw();
			});
		}
	}

	clearFilesInput() {
		this.files.forEach((file) => {
			if (file.file) {
				this.deleteFile(file.hash, false);
			}
		});
	}
	/**
	 * Generate and apply popover to preview
	 *
	 * @param {File} file
	 * @param {string} template
	 * @param {string} imageSrc
	 * @returns {jQuery}
	 */
	addPreviewPopover(file, template, imageSrc) {
		const thisInstance = this;
		let fileSize = '';
		const fileInfo = this.getFileInfo(file.hash);
		if (typeof fileInfo.size !== 'undefined') {
			fileSize = `<div class="p-1 ml-1 bg-white border rounded small position-absolute">${fileInfo.size}</div>`;
		}
		let deleteBtn = '';
		if (!this.detailView) {
			deleteBtn = `<button class="btn btn-sm btn-danger c-btn-collapsible js-multi-image__popover-btn-delete mb-1" type="button" data-hash="${
				file.hash
			}" data-js="click" title="${app.translate('JS_DELETE')}"><i class="fa fa-trash-alt"></i></button>`;
		}
		return $(template).popover({
			container: thisInstance.elements.component,
			title: `<div class="u-text-ellipsis"><i class="fa fa-image"></i> ${file.name}</div>`,
			html: true,
			sanitize: false,
			trigger: 'focus',
			placement: 'top',
			content: `<img src="${imageSrc}" class="w-100 js-multi-image__popover-img c-multi-image__popover-img" data-hash="${file.hash}" data-js="click"/>`,
			template: `<div class="popover" role="tooltip">
				<div class="arrow"></div>
				<h3 class="popover-header"></h3>
				<div class="popover-body"></div>
				<div class="text-right popover-footer js-multi-image__popover-actions">
					${fileSize}
					${deleteBtn}
					<button class="btn btn-sm btn-success js-multi-image__popover-btn-download mb-1" type="button" data-hash="${
						file.hash
					}" data-js="click"><i class="fa fa-download" title="${app.translate(
				'JS_DOWNLOAD'
			)}"></i> <span class="c-btn-collapsible__text"></span></button>
					<button class="btn btn-sm btn-primary js-multi-image__popover-btn-zoom mb-1 mr-1" type="button" data-hash="${
						file.hash
					}" data-js="click"><i class="fa fa-search-plus" title="${app.translate(
				'JS_ZOOM_IN'
			)}"></i> <span class="c-btn-collapsible__text"></span></button>
				</div>
			</div>`
		});
	}

	/**
	 * Remove preview popover
	 *
	 * @param {String} hash
	 */
	removePreviewPopover(hash) {
		const fileInfo = this.getFileInfo(hash);
		if (typeof fileInfo.previewElement !== 'undefined') {
			fileInfo.previewElement.popover('dispose');
		}
	}

	/**
	 * Hide popovers when user starts moving file preview
	 *
	 * @param {Event} e
	 * @param {Object} ui
	 */
	sortOver(e, ui) {
		this.elements.result.find('.js-multi-image__preview').popover('hide');
	}

	/**
	 * Update file position according to elements order
	 *
	 * @param {Event} e
	 * @param {Object} ui
	 */
	sortStop(e, ui) {
		const actualElements = this.elements.result.find('.js-multi-image__preview').toArray();
		this.files = actualElements.map((element) => {
			for (let i = 0, len = this.files.length; i < len; i++) {
				const elementHash = $(element).data('hash');
				if (this.files[i].hash === elementHash) {
					return this.files[i];
				}
			}
		});
		this.redraw();
	}

	/**
	 * Redraw view according to in-memory positions
	 */
	redraw() {
		this.files.forEach((file) => {
			this.elements.result.append(file.previewElement);
		});
		this.updateFormValues();
	}

	/**
	 * Enable drag and drop files repositioning
	 */
	enableDragNDrop() {
		this.elements.result
			.sortable({
				handle: '.js-multi-image__preview-img',
				items: '.js-multi-image__preview',
				over: this.sortOver.bind(this),
				stop: this.sortStop.bind(this)
			})
			.disableSelection()
			.on('mousedown', '.js-multi-image__preview-img', function (e) {
				this.focus(); // focus to show popover
			});
	}
	generatePreviewElements(files, callback) {
		files.forEach((file) => {
			if (file instanceof File) {
				let template = $(this.generatePreviewFromFile(file));
				file.preview = template;
				this.addFileInfoProperty(file.hash, 'previewElement', file.preview);
				callback(template);
			} else {
				this.generatePreviewFromValue(file, (template, imageSrc) => {
					file.preview = this.addPreviewPopover(file, template, imageSrc);
					this.addFileInfoProperty(file.hash, 'previewElement', file.preview);
					callback(file.preview);
				});
			}
		});
	}

	/**
	 * Generate preview of image as html string
	 *
	 * @param {File} file
	 * @param {function} callback
	 */
	generatePreviewFromFile(file, callback) {
		return `<div class="mr-1 js-multi-image__preview d-none" id="js-multi-image__preview-hash-${
			file.hash
		}" data-hash="${file.hash}" data-js="container|click">
			<button class="btn btn-sm btn-danger c-btn-collapsible js-multi-image__popover-btn-delete mr-1" type="button" data-hash="${
				file.hash
			}" data-js="click" title="${app.translate('JS_DELETE')}"><i class="fa fa-trash-alt"></i></button>${file.name}
		</div>`;
	}

	/**
	 * Generate preview of image as html string from existing values
	 *
	 * @param {File} file
	 * @param {function} callback
	 */
	generatePreviewFromValue(file, callback) {
		callback(
			`<div class="d-inline-block mr-1 js-multi-image__preview" id="js-multi-image__preview-hash-${file.hash}" data-hash="${file.hash}" data-js="container|click">
				<div class="img-thumbnail js-multi-image__preview-img c-multi-image__preview-img" data-hash="${file.hash}" data-js="drag" style="background-image:url(${file.imageSrc})" tabindex="0" title="${file.name}"></div>
		</div>`,
			file.imageSrc
		);
	}

	/**
	 * Load files that were in valueInput as json string
	 */
	loadExistingFiles() {
		this.files = this.files
			.map((file) => {
				file.hash = this.generateRandomHash(CONFIG.userId);
				return file;
			})
			.slice(0, this.options.limit);
		this.generatePreviewElements(this.files, (element) => {
			this.elements.result.append(element);
		});
		this.updateFormValues();
	}

	/**
	 * Generate carousel for all files in large preview
	 *
	 * @param {String} hash
	 */
	generateCarousel(hash) {
		if (this.files.length <= 1) {
			const fileInfo = this.getFileInfo(hash);
			return `<img class="d-block w-100" src="${fileInfo.imageSrc}">`;
		}
		let template = `<div id="carousel-${hash}" class="carousel slide c-carousel" data-ride="carousel" data-js="container">
		  <div class="carousel-inner">`;
		this.files.forEach((file) => {
			template += `<div class="carousel-item c-carousel__item`;
			if (file.hash === hash) {
				template += ` active`;
			}
			template += `" data-hash="${file.hash}">
		      <img class="d-block w-100 c-carousel__image" src="${file.imageSrc}">
		    </div>`;
		});
		template += `<a class="carousel-control-prev c-carousel__prevnext-btn c-carousel__prev-btn" href="#carousel-${hash}" role="button" data-slide="prev" data-js="click">
		    <span class="fas fa-caret-left fa-2x c-carousel__prev-icon mr-1" aria-hidden="true"></span>
		  </a>
		  <a class="carousel-control-next c-carousel__prevnext-btn c-carousel__next-btn" href="#carousel-${hash}" role="button" data-slide="next" data-js="click">
		    <span class="fas fa-caret-right fa-2x c-carousel__next-icon ml-1" aria-hidden="true"></span>
		  </a>
		</div>`;
		return template;
	}

	/**
	 * generate random hash
	 * @returns {string}
	 */
	generateRandomHash(prefix = '') {
		prefix = prefix.toString();
		const hash =
			Math.random().toString(36).substr(2, 10) +
			Math.random().toString(36).substr(2, 10) +
			new Date().valueOf() +
			Math.random().toString(36).substr(2, 6);
		return prefix ? prefix + hash : hash;
	}
}
