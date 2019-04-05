/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

window.Products_Tree_Js = class {
	constructor(container = $('.js-products-container')) {
		console.log('Products_Tree_Js: ' + container.length);
		this.container = container;
		//this.init(container);
	}
	init(container = $('.js-products-container')){
		this.container = container;
		this.registerEvents();
	}
	registerEvents() {
		this.registerAmountChange();
		this.registerButtonAddToCart();
		this.registerPagination();
	}

	registerAmountChange(){
		this.container.find('.js-amount-inc').on('click', (e)=>{
			let amount = this.getCartItem(e.currentTarget).find('.js-amount');
			let amountVal = amount.val();
			amountVal++;
			amount.val(amountVal);
		});
		this.container.find('.js-amount-dec').on('click', (e)=>{
			let amount = this.getCartItem(e.currentTarget).find('.js-amount');
			let amountVal = amount.val();
			amountVal--;
			if(amountVal >= 0){
				amount.val(amountVal);
			}
		});
	}
	registerPagination(){
		this.container.find('.js-page-item').on('click', (e)=>{
			this.loadPage($(e.currentTarget).data('page'));
		});
		this.container.find('.js-page-next').on('click', (e)=>{
			let page = this.container.find('.js-pagination-list').data('page');
			this.loadPage(++page);
		});
		this.container.find('.js-page-previous').on('click', (e)=>{
			let page = this.container.find('.js-pagination-list').data('page');
			this.loadPage(--page);
		});
	}

	loadPage(page){
		const progressInstance = $.progressIndicatorShow();
		AppConnector.request({
			module: app.getModuleName(),
			view: 'Tree',
			page: page
		}).then((data) =>{
			progressInstance.progressIndicator({'mode': 'hide'});
			//progressInstance.progressIndicatorHide();
			$('.js-main-container').html(data);
			this.init();
		}, (e, err) => {

		});
	}

	registerButtonAddToCart(){
		this.container.find('.js-add-to-cart').on('click', (e)=>{
			console.log('add to cart');
			let product = this.getCartItem(e.currentTarget);
			this.addToCart(product.data('id'));
		});
	}
	addToCart(recordId){
		AppConnector.request({
			module: app.getModuleName(),
			action: 'AddToCart',
			record: recordId
		}).then( (data) =>{
			console.log('DATA:' + JSON.stringify(data));
		}, (e, err) => {

		});
	}
	getCartItem(element){
		return  $(element).closest('.js-cart-item');
	}
}
