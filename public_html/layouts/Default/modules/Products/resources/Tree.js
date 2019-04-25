/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
"use strict";
window.Products_Tree_Js = class {
	constructor(container = $(".js-products-container")) {
		this.container = container;
		this.page = this.container.find(".js-pagination-list").data("page");
		this.treeInstance = $(".js-tree-container");
		this.shoppingCartBadge = $(".js-body-header .js-shopping-cart .js-badge");
		this.isTreeLoaded = false;
		window.Products_Tree_Js.instance = this;
	}
	/**
	 * Get instance of Tree.
	 * @returns {Tree}
	 */
	static getInstance(container = $(".js-products-container")) {
		if (typeof window.Products_Tree_Js.instance === "undefined") {
			window.Products_Tree_Js.instance = new window.Products_Tree_Js(container);
		}
		return window.Products_Tree_Js.instance;
	}
	init(container = $(".js-products-container")) {
		this.container = container;
		this.treeInstance = $(".js-tree-container");
		this.registerEvents();
	}
	registerEvents() {
		this.registerAmountChange();
		this.registerButtonAddToCart();
		this.registerPagination();
		this.registerSearch();
		this.registerTreeEvents();
	}
	registerTreeEvents() {
		this.treeInstance
			.on("changed.jstree", (e, data) => {
				this.loadPage();
			});
	}
	registerAmountChange() {
		this.container.find(".js-amount-inc").on("click", e => {
			let amount = this.getCartItem(e.currentTarget).find(".js-amount");
			let amountVal = amount.val();
			amountVal++;
			amount.val(amountVal);
		});
		this.container.find(".js-amount-dec").on("click", e => {
			let amount = this.getCartItem(e.currentTarget).find(".js-amount");
			let amountVal = amount.val();
			amountVal--;
			if (amountVal >= 0) {
				amount.val(amountVal);
			}
		});
	}
	registerPagination() {
		this.container.find(".js-page-item").on("click", e => {
			this.page = parseInt($(e.currentTarget).data("page"));
			this.loadPage();
		});
		this.container.find(".js-page-next").on("click", e => {
			this.page =
				parseInt(this.container.find(".js-pagination-list").data("page")) + 1;
			this.loadPage();
		});
		this.container.find(".js-page-previous").on("click", e => {
			this.page =
				parseInt(this.container.find(".js-pagination-list").data("page")) - 1;
			this.loadPage();
		});
	}

	getSearchParams() {
		let search = [];
		let searchValue = $('.js-search').val();
		if (searchValue) {
			search.push({
				fieldName: "productname",
				value: searchValue,
				operator: "c"
			});
		}
		let selectedCategories = [];
		$.each(this.treeInstance.jstree("get_selected", true), (index, value) => {
			selectedCategories.push(value["original"]["tree"]);
		});
		if (selectedCategories[0]) {
			search.push({
				fieldName: "pscategory",
				value: selectedCategories[0],
				operator: "e"
			});
		}

		return search;
	}
	loadPage() {
		const progressInstance = $.progressIndicatorShow();
		AppConnector.requestPjax({
			data: {
				module: app.getModuleName(),
				view: "Tree",
				search: this.getSearchParams(),
				page: this.page
			},
			type: "GET"
		}).done(data => {
			progressInstance.progressIndicator({ mode: "hide" });
			let container = $(".js-main-container");
			container.html(data);
			this.container = container;
			this.registerAmountChange();
			this.registerButtonAddToCart();
			this.registerPagination();
		});
	}
	registerSearch() {
		$('.js-search-button').on('click', e => {
			this.page = 1;
			this.loadPage();
		});
		$('.js-search').on('keypress', e => {
			if (e.keyCode == 13) {
				this.page = 1;
				this.loadPage();
			}
		});
		$('.js-search-cancel').on('click', e => {
			$('.js-search').val('');
		});
	}
	registerButtonAddToCart() {
		this.container.find(".js-add-to-cart").on("click", e => {
			let product = this.getCartItem(e.currentTarget);
			this.cartMethod("addToCart", product.data("id"), {
				amount: product.find(".js-amount").val(),
				priceNetto: product.data("priceNetto")
			}).done(data => {
				this.shoppingCartBadge.text(data["result"]["numberOfItems"]);
			});
		});
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
	getCartItem(element) {
		return $(element).closest(".js-cart-item");
	}
};
