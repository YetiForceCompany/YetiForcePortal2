/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
"use strict";
window.Products_Preview_Js = class {
	constructor(container = $(".js-preview")) {
		this.container = container;
		this.shoppingCartBadge = $(
			".js-body-header .js-shopping-cart .js-badge"
		);
	}
	cartMethod(mode, recordId, params = {}) {
		const deferred = $.Deferred();
		AppConnector.request(
			$.extend(
				{
					module: app.getModuleName(),
					action: "ShoppingCart",
					mode: mode,
					record: recordId
				},
				params
			)
		).done(data => {
			deferred.resolve(data);
		});
		return deferred.promise();
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
	registerButtonAddToCart() {
		this.container.find(".js-add-to-cart").on("click", e => {
			let product = this.container;
			let amount = product.find(".js-amount").val();
			let amountInShoppingCart = parseFloat(
				product.data("amountInShoppingCart")
			);
			let qtyinstock = parseFloat(product.data("qtyinstock"));
			if (
				this.checkStockLevels &&
				qtyinstock - amountInShoppingCart - amount < 0
			) {
				Vtiger_Helper_Js.showPnotify({
					text: app.translate("JS_NO_SUCH_QUANTITY"),
					type: "error"
				});
			} else {
				this.cartMethod("addToCart", product.data("id"), {
					amount: product.find(".js-amount").val(),
					priceNetto: product.data("priceNetto")
				}).done(data => {
					this.shoppingCartBadge.text(
						data["result"]["numberOfItems"]
					);
					product.data(
						"amountInShoppingCart",
						amountInShoppingCart + amount
					);
				});
			}
		});
	}
	registerEvents() {
		this.container = $(".js-preview");
		this.registerAmountChange();
		this.registerButtonAddToCart();
	}
};
