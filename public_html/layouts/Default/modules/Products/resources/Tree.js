/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

window.Products_Tree_Js = class {
	constructor(container = $('.js-products-container')) {
		console.log('Products_Tree_Js: ' + container.length);
		this.container = container;
	}
	registerEvents() {
		this.registerAmountChange();
		this.registerButtonAddToCart();
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
