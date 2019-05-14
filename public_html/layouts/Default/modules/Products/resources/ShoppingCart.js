/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
"use strict";
window.Products_ShoppingCart_Js = class extends Products_Tree_Js {
	constructor(container = $(".js-products-container")) {
		super(container);
		this.container = container;
		this.totalPriceNetto = this.container.find(".js-total-price-netto");
		this.totalPriceBrutto = this.container.find(".js-total-price-brutto");
	}
	updateProduct(product) {
		this.cartMethod("setToCart", product.data("id"), {
			amount: product.find(".js-amount").val(),
			priceNetto: product.data("priceNetto")
		}).done(data => {
			this.shoppingCartBadge.text(data["result"]["numberOfItems"]);
			this.totalPriceNetto.text(data["result"]["totalPriceNetto"]);
		});
	}

	registerButtonRemoveFromCart() {
		this.container.find(".js-remove-from-cart").on("click", e => {
			let product = this.getCartItem(e.currentTarget);
			this.cartMethod("removeFromCart", product.data("id")).done(data => {
				product.remove();
				this.shoppingCartBadge.text(data["result"]["numberOfItems"]);
				this.totalPriceNetto.text(data["result"]["totalPriceNetto"]);
			});
		});
	}
	registerAmountChange() {
		this.container.find(".js-amount-inc").on("click", e => {
			let product = this.getCartItem(e.currentTarget);
			let amountInput = product.find(".js-amount");
			let quantity = product.data("qtyinstock");
			if (quantity > 0) {
				amountInput.val(parseInt(amountInput.val()) + 1);
				product.data("qtyinstock", quantity - 1);
				console.log("qtyinstock: " + product.data("qtyinstock"));
				this.updateProduct(product);
			} else {
				product.find(".js-no-such-quantity").removeClass("d-none");
			}
		});
		this.container.find(".js-amount-dec").on("click", e => {
			let product = this.getCartItem(e.currentTarget);
			let amountInput = product.find(".js-amount");
			let amountVal = parseInt(amountInput.val());
			let quantity = product.data("qtyinstock");
			if (amountVal > 1) {
				amountInput.val(amountVal - 1);
				product.data("qtyinstock", quantity + 1);
				if (!product.find(".js-no-such-quantity").hasClass("d-none")) {
					product.find(".js-no-such-quantity").addClass("d-none");
				}
				this.updateProduct(product);
			}
		});
	}
	registerChangeAddress() {
		let addresses = JSON.parse(this.container.find(".js-addresses").val());
		let self = this;
		this.container.find(".js-select-address").on("change", e => {
			const type = $(e.currentTarget).val();
			const data = addresses["data"][type];
			Object.keys(data).forEach(function(fieldname) {
				let value = data[fieldname];
				fieldname = fieldname.substring(0, fieldname.length - 1);
				self.container.find('[name="' + fieldname + '"]').val(value);
			});
			let form = this.container.find(".js-form-address");
			AppConnector.request({
				module: app.getModuleName(),
				action: "ShoppingCart",
				mode: "changeAddress",
				addresslevel1: form.find('[name="addresslevel1"]').val(),
				addresslevel2: form.find('[name="addresslevel2"]').val(),
				addresslevel3: form.find('[name="addresslevel3"]').val(),
				addresslevel4: form.find('[name="addresslevel4"]').val(),
				addresslevel5: form.find('[name="addresslevel5"]').val(),
				addresslevel6: form.find('[name="addresslevel6"]').val(),
				addresslevel7: form.find('[name="addresslevel7"]').val(),
				addresslevel8: form.find('[name="addresslevel8"]').val(),
				localnumber: form.find('[name="localnumber"]').val(),
				buildingnumber: form.find('[name="buildingnumber"]').val(),
				pobox: form.find('[name="pobox"]').val()
			});
		});
		this.container.find(".js-select-address").trigger("change");
	}

	registerEvents() {
		super.registerEvents();
		this.registerButtonRemoveFromCart();
		this.registerChangeAddress();
	}
};
