/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';
window.Products_Preview_Js = class {
	constructor(container = $('.js-preview')) {
		this.container = container;
		this.shoppingCartBadge = $('.js-body-header .js-shopping-cart .js-badge');
	}
	cartMethod(mode, recordId, params = {}) {
		const deferred = $.Deferred();
		AppConnector.request(
			$.extend(
				{
					module: app.getModuleName(),
					action: 'ShoppingCart',
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
	getCartItem(element) {
		return $(element).closest('.js-cart-item');
	}
	registerAmountChange() {
		this.container.find('.js-amount-inc').on('click', e => {
			let amount = this.getCartItem(e.currentTarget).find('.js-amount');
			let amountVal = amount.val();
			amountVal++;
			amount.val(amountVal);
		});
		this.container.find('.js-amount-dec').on('click', e => {
			let amount = this.getCartItem(e.currentTarget).find('.js-amount');
			let amountVal = amount.val();
			amountVal--;
			if (amountVal >= 0) {
				amount.val(amountVal);
			}
		});
	}
	registerButtonAddToCart() {
		this.container.find('.js-add-to-cart').on('click', e => {
			let product = this.container;
			let amountVal = product.find('.js-amount').val();
			if (parseInt(amountVal) <= 0) {
				return;
			}
			let amountInShoppingCart = parseFloat(product.data('amountInShoppingCart'));
			let qtyinstock = parseFloat(product.data('qtyinstock'));
			if (this.checkStockLevels && qtyinstock - amountInShoppingCart - amountVal < 0) {
				Vtiger_Helper_Js.showPnotify({
					text: app.translate('JS_NO_SUCH_QUANTITY'),
					type: 'error'
				});
			} else {
				const amountVal = product.find('.js-amount').val();
				this.cartMethod('addToCart', this.container.find('.js-preview-record').val(), {
					amount: product.find('.js-amount').val(),
					priceNetto: product.data('priceNetto'),
					priceGross: product.data('priceGross')
				}).done(data => {
					if (data['result']['error']) {
						Vtiger_Helper_Js.showPnotify({
							text: data['result']['error'],
							type: 'error'
						});
					} else {
						this.shoppingCartBadge.text(data['result']['numberOfItems']);
						const notifyText =
							amountVal > 1
								? app.translate('JS_ADDED_ITEMS_TO_CART').replace('${amount}', amountVal)
								: app.translate('JS_ADDED_ITEM_TO_CART');
						Vtiger_Helper_Js.showPnotify({
							text: notifyText,
							type: 'success'
						});
						product.data('amountInShoppingCart', amountInShoppingCart + amountVal);
					}
				});
			}
		});
	}
	registerButtonAddToCartForBundles() {
		this.container.find('.js-add-to-cart-bundles').on('click', e => {
			let product = this.getCartItem(e.currentTarget);
			let amount = product.find('.js-amount').val();
			if (parseInt(amount) <= 0) {
				return;
			}
			let amountInShoppingCart = parseFloat(product.data('amountInShoppingCart'));
			let qtyinstock = parseFloat(product.data('qtyinstock'));
			if (this.checkStockLevels && qtyinstock - amountInShoppingCart - amount < 0) {
				Vtiger_Helper_Js.showPnotify({
					text: app.translate('JS_NO_SUCH_QUANTITY'),
					type: 'error'
				});
			} else {
				const amount = product.find('.js-amount').val();
				this.cartMethod('addToCart', product.data('id'), {
					amount: amount,
					priceNetto: product.data('priceNetto'),
					priceGross: product.data('priceGross')
				}).done(data => {
					if (data['result']['error']) {
						Vtiger_Helper_Js.showPnotify({
							text: data['result']['error'],
							type: 'error'
						});
					} else {
						this.shoppingCartBadge.text(data['result']['numberOfItems']);
						const notifyText =
							amount > 1
								? app.translate('JS_ADDED_ITEMS_TO_CART').replace('${amount}', amount)
								: app.translate('JS_ADDED_ITEM_TO_CART');
						Vtiger_Helper_Js.showPnotify({
							text: notifyText,
							type: 'success'
						});
						product.data('amountInShoppingCart', amountInShoppingCart + amount);
					}
				});
			}
		});
	}
	registerEvents() {
		this.container = $('.js-preview');
		this.registerAmountChange();
		this.registerButtonAddToCart();
		this.registerButtonAddToCartForBundles();
	}
};
