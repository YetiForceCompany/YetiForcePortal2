/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';
window.Products_ShoppingCart_Js = class extends Products_Tree_Js {
    constructor(container = $('.js-products-container')) {
        super(container);
        this.container = container;
        this.totalPriceNetto = this.container.find('.js-total-price-netto');
        this.totalPriceBrutto = this.container.find('.js-total-price-brutto');
    }
    updateProduct(product){
        this.cartMethod('setToCart', product.data('id'), {
            amount: product.find('.js-amount').val()
        }).done((data) => {
            this.shoppingCartBadge.text(data['result']['numberOfItems']);
            this.totalPriceNetto.text(data['result']['totalPriceNetto']);
        });
    }
    registerEvents() {
        super.registerEvents();
		this.registerButtonRemoveFromCart();
    }
    registerButtonRemoveFromCart(){
		  this.container.find('.js-remove-from-cart').on('click', (e)=>{
            let product = this.getCartItem(e.currentTarget);
            this.cartMethod('removeFromCart', product.data('id')).done((data) => {
                product.remove();
                this.shoppingCartBadge.text(data['result']['numberOfItems']);
                this.totalPriceNetto.text(data['result']['totalPriceNetto']);
            });
		});
    }
    registerAmountChange(){
		this.container.find('.js-amount-inc').on('click', (e)=>{
            let product = this.getCartItem(e.currentTarget);
            let amountInput = product.find('.js-amount');
            amountInput.val(parseInt(amountInput.val()) + 1);
            this.updateProduct(product);
		});
		this.container.find('.js-amount-dec').on('click', (e)=>{
            let product = this.getCartItem(e.currentTarget);
            let amountInput = product.find('.js-amount');
            let amountVal = parseInt(amountInput.val());
            if( amountVal > 1 ){
                amountInput.val(amountVal - 1);
                this.updateProduct(product);
            }
		});
	}
}
