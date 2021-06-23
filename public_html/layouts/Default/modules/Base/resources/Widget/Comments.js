/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
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
					aDeferred.reject();
				});
		} else {
			aDeferred.reject();
		}
		return deferred.promise();
	}
	registerChangePage() {
		this.container.on('click', '.js-change-page', (e) => {
			let page = e.currentTarget.dataset.page;
			this.loadContent(page);
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
	}
};
