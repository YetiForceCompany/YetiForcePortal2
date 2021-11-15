/* {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
window.Base_Widget_Comments_Js = class {
	constructor() {
		this.container = null;
	}
	/**
	 * Load widget content
	 */
	loadContent(page = 1) {
		const deferred = $.Deferred();
		let url = this.container.data('url');
		if (url) {
			url += page ? `&page=${page}` : '';
			let progressInstance = $.progressIndicator({
				position: 'html',
				blockInfo: {
					enabled: true,
					elementToBlock: this.container
				},
				message: ' '
			});
			AppConnector.request(url)
				.done((responseData) => {
					this.container.find('.js-widget-container_content').html(responseData);
					progressInstance.progressIndicator({ mode: 'hide' });
					deferred.resolve();
				})
				.fail(function (e, er) {
					app.errorLog(e, er);
					progressInstance.progressIndicator({ mode: 'hide' });
					deferred.reject();
				});
		} else {
			deferred.reject();
		}
		return deferred.promise();
	}
	getContent(url = null) {
		const deferred = $.Deferred();
		if (url) {
			let progressInstance = $.progressIndicator({
				position: 'html',
				blockInfo: {
					enabled: true,
					elementToBlock: this.container
				},
				message: ' '
			});
			AppConnector.request(url)
				.done((responseData) => {
					progressInstance.progressIndicator({ mode: 'hide' });
					deferred.resolve(responseData);
				})
				.fail(function (e, er) {
					app.errorLog(e, er);
					progressInstance.progressIndicator({ mode: 'hide' });
					deferred.reject(false);
				});
		} else {
			deferred.reject();
		}
		return deferred.promise();
	}

	/**
	 * Change page event
	 */
	registerChangePage() {
		this.container.on('click', '.js-change-page', (e) => {
			let page = e.currentTarget.dataset.page;
			this.loadContent(page);
		});
	}

	/**
	 * Show replies
	 */
	registerShowReplies() {
		this.container.on('click', '.js-show-replies', (e) => {
			let element = $(e.currentTarget);
			let url = e.currentTarget.dataset.url;
			this.getContent(url).done((result) => {
				element.closest('.js-post-container_body').append(result);
				element.addClass('d-none');
			});
		});
	}
	/**
	 * Add comments
	 */
	registerAddComments() {
		let form = this.container.find('.js-add-comment-block form');
		form.validationEngine({ binded: false, ...app.validationEngineOptions });
		form.on('submit', (e) => {
			e.preventDefault();
			if (form.validationEngine('validate')) {
				let commentContent = form.find('.js-comment-content');
				let commentContentValue = commentContent.html();
				if ('' === commentContentValue) {
					commentContent.validationEngine(
						'showPrompt',
						app.translate('JS_LBL_COMMENT_VALUE_CANT_BE_EMPTY'),
						'error',
						'bottomLeft',
						true
					);

					return false;
				}
				let formData = form.serializeFormData();
				formData['commentcontent'] = commentContentValue;
				AppConnector.request(formData).done((response) => {
					form.find('[name="commentcontent"]').empty();
					this.loadContent();
				});
			}
		});
		this.container.on('submit', '.js-reply-comment-block form', (e) => {
			e.preventDefault();
			let formReply = $(e.currentTarget);
			formReply.validationEngine({ binded: false, ...app.validationEngineOptions });
			if (formReply.validationEngine('validate')) {
				AppConnector.request(formReply.serializeFormData()).done((response) => {
					formReply.find('[name="commentcontent"]').val('');
					let postContainer = formReply.closest('.js-post-container');
					let url = postContainer.find('.js-show-replies:first').data('url');
					this.getContent(url).done((result) => {
						postContainer.find('.js-post-container').remove();
						postContainer.find('.js-post-cancel').trigger('click');
						postContainer.find('.js-post-container_body').append(result);
						postContainer.find('.js-show-replies').addClass('d-none');
					});
				});
			}
		});
	}
	registerReply() {
		this.container.on('click', '.js-post-reply,.js-post-cancel', (e) => {
			let postContainer = $(e.currentTarget).closest('.js-post-container'),
				replyBlock = postContainer.find('.js-reply-comment-block:first'),
				replyBtn = postContainer.find('.js-post-reply:first');
			replyBlock.toggleClass('d-none');
			replyBtn.toggleClass('d-none');
		});
	}

	/**
	 * Register events
	 * @param {jQuery} container
	 */

	registerEvents(container) {
		this.container = container;
		this.loadContent();
		this.registerChangePage();
		this.registerShowReplies();
		this.registerAddComments();
		this.registerReply();
	}
};
