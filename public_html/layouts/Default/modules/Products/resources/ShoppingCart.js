/* {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
'use strict';
window.Products_ShoppingCart_Js = class extends Products_Tree_Js {
	constructor(container = $('.js-products-container')) {
		super(container);
		this.container = container;
		this.checkStockLevels = this.container.data('check-stock-levels');
		this.totalPriceNetto = this.container.find('.js-total-price-netto');
		this.totalPriceGross = this.container.find('.js-total-price-gross');
		this.addressSelect = this.container.find('.js-select-address');
		this.shippingPrice = this.container.find('.js-shipping-price');
		this.formElement = this.container.find('form');
		this.btnProceedToCheckout = this.container.find('.js-btn-proceed-to-checkout');
	}
	updateProduct(product, expectedAmount) {
		let validateResult = this.validate(false);
		this.btnProceedToCheckout.toggleClass('btn-success', validateResult).toggleClass('btn-grey', !validateResult);
		if (validateResult) {
			this.cartMethod('setToCart', product.data('id'), {
				amount: expectedAmount,
				priceNetto: product.data('priceNetto'),
				priceGross: product.data('priceGross')
			}).done((data) => {
				if (data['result']['error']) {
					app.showNotify({
						text: data['result']['error'],
						type: 'error'
					});
				} else {
					const amount = product.find('.js-amount');
					const notifyText =
						amount.val() > expectedAmount
							? app.translate('JS_REMOVED_ITEM_FROM_CART')
							: app.translate('JS_ADDED_ITEM_TO_CART');
					app.showNotify({
						text: notifyText,
						type: 'success'
					});
					amount.val(expectedAmount);
					this.shoppingCartBadge.text(data['result']['numberOfItems']);
					this.totalPriceNetto.text(data['result']['totalPriceNetto']);
					this.totalPriceGross.text(data['result']['totalPriceGross']);
					this.shippingPrice.text(data['result']['shippingPrice']);
				}
			});
		}
	}
	validate(formValidation = true) {
		const products = this.container.find('.js-cart-item');
		if (!products.length) {
			app.showNotify({
				text: app.translate('JS_YOU_HAVE_NO_ITEMS_IN_YOUR_SHOPPING_CART'),
				type: 'error'
			});
			return false;
		}
		if (formValidation && this.formElement.validationEngine('validate') !== true) {
			return false;
		}
		if (!this.checkStockLevels) {
			return true;
		}
		let validateResult = true;
		products.each((i, element) => {
			let product = $(element);
			let amount = parseFloat(product.find('.js-amount').val());
			let quantity = parseFloat(product.data('qtyinstock'));
			let isEnoughQuantity = quantity - amount >= 0;
			product.find('.js-no-such-quantity').toggleClass('d-none', isEnoughQuantity);
			if (!isEnoughQuantity) {
				validateResult = false;
			}
		});
		return validateResult;
	}
	registerButtonRemoveFromCart() {
		this.container.find('.js-remove-from-cart').on('click', (e) => {
			let product = this.getCartItem(e.currentTarget);
			this.cartMethod('removeFromCart', product.data('id')).done((data) => {
				product.remove();
				this.shoppingCartBadge.text(data['result']['numberOfItems']);
				this.totalPriceNetto.text(data['result']['totalPriceNetto']);
				this.totalPriceGross.text(data['result']['totalPriceGross']);
				this.shippingPrice.text(data['result']['shippingPrice']);
			});
		});
	}
	registerAmountChange() {
		this.container.find('.js-amount-inc').on('click', (e) => {
			let product = this.getCartItem(e.currentTarget);
			let amountInput = product.find('.js-amount');
			this.updateProduct(product, parseInt(amountInput.val()) + 1);
		});
		this.container.find('.js-amount-dec').on('click', (e) => {
			let product = this.getCartItem(e.currentTarget);
			let amountInput = product.find('.js-amount');
			let amountVal = parseInt(amountInput.val());
			if (amountVal > 1) {
				this.updateProduct(product, amountVal - 1);
			}
		});
		this.container.find('.js-amount').on('change', (e) => {
			let amountInput = $(e.currentTarget);
			let product = this.getCartItem(e.currentTarget);
			let amountVal = parseInt(amountInput.val());
			if (amountVal > 1) {
				this.updateProduct(product, amountVal);
			} else {
				app.showNotify({
					text: app.translate('JS_VALUE_SHOULD_BE_GREATER_THAN_ZERO'),
					type: 'error'
				});
			}
		});
	}
	registerChangeAddress() {
		this.container.find('.js-addresses-container input').on('change', (e) => {
			const name = $(e.currentTarget).attr('name');
			const val = $(e.currentTarget).val();
			const params = {};
			params[name] = val;
			AppConnector.request(
				$.extend(
					{
						module: app.getModuleName(),
						action: 'ShoppingCart',
						mode: 'changeAddress',
						mode: 'changeAddress'
					},
					params
				)
			);
		});
		if (this.addressSelect.length) {
			let addresses = JSON.parse(this.container.find('.js-addresses').val());
			let self = this;
			this.addressSelect.on('change', (e) => {
				const type = $(e.currentTarget).val();
				const data = addresses['data'][type];
				Object.keys(data).forEach(function (fieldname) {
					let value = data[fieldname];
					fieldname = fieldname.substring(0, fieldname.length - 1);
					self.container.find('[name="' + fieldname + '"]').val(value);
				});
				let form = this.container.find('.js-form-address');
				AppConnector.request({
					module: app.getModuleName(),
					action: 'ShoppingCart',
					mode: 'changeAddress',
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
			this.container.find('.js-select-address').trigger('change');
		}
	}
	registerChangePayments() {
		this.container.find('.js-method-payments').on('change', (e) => {
			this.btnProceedToCheckout.addClass('btn-success').removeClass('btn-grey');
			$('.mainPage ').animate({ scrollTop: $(document).height() }, 'slow');
			AppConnector.request({
				module: app.getModuleName(),
				action: 'ShoppingCart',
				mode: 'setMethodPayments',
				method: $(e.currentTarget).attr('id')
			});
		});
	}
	registerAttention() {
		this.container.find('.js-attention').on('change', (e) => {
			AppConnector.request({
				module: app.getModuleName(),
				action: 'ShoppingCart',
				mode: 'setAttention',
				attention: $(e.currentTarget).val()
			});
		});
	}
	registerProceedToCheckout() {
		this.btnProceedToCheckout.on('click', (e) => {
			let validateResult = this.validate();
			$(e.currentTarget).toggleClass('btn-success', validateResult).toggleClass('btn-grey', !validateResult);
			return validateResult;
		});
	}
	registerFormEvents() {
		this.registerChangePayments();
		this.registerAttention();
		this.registerChangeAddress();
		this.formElement.validationEngine(app.validationEngineOptions);
	}
	registerEventsAfterLoad() {
		super.registerEventsAfterLoad();
		this.registerButtonRemoveFromCart();
	}
	registerEvents() {
		super.registerEvents();
		this.registerButtonRemoveFromCart();
		this.registerProceedToCheckout();
		this.registerFormEvents();
	}
};
