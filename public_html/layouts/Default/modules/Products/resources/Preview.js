/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
"use strict";
window.Products_Preview_Js = class {
	container;
	registerButtonAddToCart() {
		this.container.find(".js-add-to-cart").on("click", e => {
			AppConnector.request({
				module: app.getModuleName(),
				action: "ShoppingCart",
				mode: 'addToCart',
				record: this.container.find('.js-preview-record').val(),
				amount: this.container.find('.js-amount').val(),
			}).done(data => {
				$(".js-body-header .js-shopping-cart .js-badge").text(data["result"]["numberOfItems"]);
			});

		});
	}
	registerAmountChange() {
		this.container.find(".js-amount-inc").on("click", e => {
			let amount = this.container.find(".js-amount");
			let amountVal = amount.val();
			amountVal++;
			amount.val(amountVal);
		});
		this.container.find(".js-amount-dec").on("click", e => {
			let amount = this.container.find(".js-amount");
			let amountVal = amount.val();
			amountVal--;
			if (amountVal >= 0) {
				amount.val(amountVal);
			}
		});
	}
	registerEvents() {
		this.container = $('.js-preview');
		this.registerAmountChange();
		this.registerButtonAddToCart();
	}
};
