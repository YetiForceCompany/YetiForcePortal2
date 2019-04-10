/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';

class ProgressIndicatorHelper{
	constructor(){
		this.defaults = {
			'position': 'append',
			'mode': 'show',
			'blockInfo': {
				'elementToBlock': 'body'
			},
			'message': ''
		};
		this.imageContainerCss = {
			'text-align': 'center'
		};
		this.blockOverlayCSS = {
			'opacity': '0.2'
		};
		this.blockCss = {
			'border': '',
			'background-color': '',
			'background-clip': 'border-box',
			'border-radius': '2px'
		};
		this.showTopCSS = {
			width: '25%',
			left: '37.5%',
			position: 'fixed',
			top: '4.5%',
			'z-index': '100000'
		};
		this.showOnTop = false;
	}
	init(element, options) {
		if (typeof options === "undefined") {
			options = {};
		}
		this.options = $.extend(true, this.defaults, options);
		this.container = element;
		this.position = options.position;
		if (typeof options.imageContainerCss !== "undefined") {
			this.imageContainerCss = $.extend(true, this.imageContainerCss, options.imageContainerCss);
		}
		if (this.isBlockMode()) {
			this.elementToBlock = $(this.options.blockInfo.elementToBlock);
		}
		return this;
	}
	initActions(){
		if (this.options.mode === 'show') {
			this.show();
		} else if (this.options.mode === 'hide') {
			this.hide();
		}
	}
	isPageBlockMode(){
		if ((typeof this.elementToBlock !== "undefined") && this.elementToBlock.is('body')) {
			return true;
		}
		return false;
	}
	isBlockMode(){
		if ((typeof this.options.blockInfo !== "undefined") && (this.options.blockInfo.enabled === true)) {
			return true;
		}
		return false;
	}
	show(){
		let className = 'bigLoading';
		if (this.options.smallLoadingImage == true) {
			className = 'smallLoading';
		}
		if (this.isBlockMode()) {
			className = className + ' blockProgressContainer';
		}
		let imageHtml = '<div class="imageHolder ' + className + '">' +
			'<div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div>' +
			'<div class="sk-cube sk-cube2"></div>' +
			'<div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div>' +
			'<div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div>' +
			'<div class="sk-cube sk-cube9"></div></div></div>';
		let jQImageHtml = jQuery(imageHtml).css(this.imageContainerCss);
		let jQMessage = this.options.message;
		if (jQMessage.length == 0) {
			jQMessage = app.translate('JS_LOADING_PLEASE_WAIT');
		}
		if (!(jQMessage instanceof jQuery)) {
			jQMessage = $('<span></span>').html(jQMessage)
		}
		let messageContainer = $('<div class="message"></div>').append(jQMessage);
		jQImageHtml.append(messageContainer);
		if (this.isBlockMode()) {
			jQImageHtml.addClass('blockMessageContainer');
		}
		switch (this.position) {
			case "prepend":
				this.container.prepend(jQImageHtml);
				break;
			case "html":
				this.container.html(jQImageHtml);
				break;
			case "replace":
				this.container.replaceWith(jQImageHtml);
				break;
			default:
				this.container.append(jQImageHtml);
		}
		if (this.isBlockMode()) {
			this.blockedElement = this.elementToBlock;
			if (this.isPageBlockMode()) {
				$.blockUI({
					message: this.container,
					overlayCSS: this.blockOverlayCSS,
					css: this.blockCss,
					onBlock: this.options.blockInfo.onBlock
				});
			} else {
				this.elementToBlock.block({
					message: this.container,
					overlayCSS: this.blockOverlayCSS,
					css: this.blockCss
				});
			}
		}
		if (this.showOnTop) {
			this.container.css(this.showTopCSS).appendTo('body');
		}
	}
	hide(){
		$('.imageHolder', this.container).remove();
		if (typeof this.blockedElement !== "undefined") {
			if (this.isPageBlockMode()) {
				$.unblockUI();
			} else {
				this.blockedElement.unblock();
			}
		}
		this.container.removeData('progressIndicator');
	}
}
/**
 * Extend jQuery
 */
$.extend({
	progressIndicator(options) {
		let progressImageContainer = $('<div class="js-progress-image-container"></div>');
		let progressIndicatorInstance = new ProgressIndicatorHelper();
		progressIndicatorInstance.init(progressImageContainer, options);
		if (!progressIndicatorInstance.isBlockMode()) {
			progressIndicatorInstance.showOnTop = true;
		}
		progressIndicatorInstance.initActions();
		return progressImageContainer.data('progressIndicator', progressIndicatorInstance);
	},
	progressIndicatorShow() {
		return $.progressIndicator({
			'position': 'html',
			'blockInfo': {
				'enabled': true
			}
		});
	},
	progressIndicatorHide(){
		$('.js-progress-image-container').progressIndicator({'mode': 'hide'});
	}
});
/**
 * Extend jQuery
 */
$.fn.extend({
	progressIndicator(options) {
		let element = this;
		if (this.length <= 0) {
			element = $('body');
		}
		return element.each((index, element) => {
			let jQueryObject = $(element),
				progressIndicatorInstance;
			if (typeof jQueryObject.data('progressIndicator') !== "undefined") {
				progressIndicatorInstance = jQueryObject.data('progressIndicator');
			} else {
				progressIndicatorInstance = new ProgressIndicatorHelper();
				jQueryObject.data('progressIndicator', progressIndicatorInstance);
			}
			progressIndicatorInstance.init(jQueryObject, options).initActions();
		});
	}
});
