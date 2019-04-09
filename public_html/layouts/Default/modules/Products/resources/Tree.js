/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

window.Products_Tree_Js = class {
	constructor(container = $('.js-products-container')) {
		this.container = container;
		this.page = this.container.find('.js-pagination-list').data('page');
		this.treeInstance = $('.js-tree-container');
		this.searchValue = container.data('search');
		this.isTreeLoaded = false;
		window.Products_Tree_Js.instance = this;
	}
	/**
	 * Get instance of Tree.
	 * @returns {Tree}
	 */
	static getInstance(container = $('.js-products-container')) {
		if (typeof window.Products_Tree_Js.instance === 'undefined') {
			window.Products_Tree_Js.instance = new window.Products_Tree_Js(container);
		}
		return window.Products_Tree_Js.instance;
	}
	searchCategories(categories){
		this.page = 1;
		this.searchValue = [{
			fieldName: 'pscategory',
			value: categories,
			operator: 'e'
		}];
		this.loadPage();
	}
	init(container = $('.js-products-container')){
		this.container = container;
		this.registerEvents();
	}
	registerEvents() {
		this.registerAmountChange();
		this.registerButtonAddToCart();
		this.registerPagination();
		this.registerSearch();
		this.registerTreeEvents();
	}

	registerTreeEvents(){
		this.treeInstance.on('ready.jstree', (e, data)=>{
			this.onTreeReady(e, data);
		}).on('changed.jstree', (e, data)=>{
			this.onTreeChanged(e, data);
		});
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
			this.page = parseInt($(e.currentTarget).data('page'));
			this.loadPage();
		});
		this.container.find('.js-page-next').on('click', (e)=>{
			this.page = parseInt(this.container.find('.js-pagination-list').data('page')) + 1;
			this.loadPage();
		});
		this.container.find('.js-page-previous').on('click', (e)=>{
			this.page = parseInt(this.container.find('.js-pagination-list').data('page')) - 1;
			this.loadPage();
		});
	}

	onTreeReady(e, data){
		this.isTreeLoaded = true;
	}

	onTreeChanged(e, data){
		if( this.isTreeLoaded ){
			let selectedCategories = [];
			$.each(this.treeInstance.jstree("get_selected", true), (index, value)=>{
				selectedCategories.push(value['original']['tree']);
			});
			this.searchCategories(selectedCategories[0]);
		}
	}

	loadPage(){
		const progressInstance = $.progressIndicatorShow();
		AppConnector.requestPjax({
			data: {
				module: app.getModuleName(),
				view: 'Tree',
				page: this.page,
				//search: this.searchValue
			},
			type: 'GET'
		}).then((data) =>{
			progressInstance.progressIndicator({'mode': 'hide'});
			$('.js-main-container').html(data);
			this.init();
			this.registerEvents();
			window.App.Fields.Tree.instance = new window.App.Fields.Tree();
		}, (e, err) => {

		});
	}

	registerSearch(){
		this.container.find('.js-search-button').on('click', (e)=>{
			this.page = 1;
			this.searchValue = [{
				fieldName: 'productname',
				value: this.container.find('.js-search').val(),
				operator: 'c'
			}];
			this.loadPage();
		});
	}

	registerButtonAddToCart(){
		this.container.find('.js-add-to-cart').on('click', (e)=>{
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

		}, (e, err) => {

		});
	}
	getCartItem(element){
		return  $(element).closest('.js-cart-item');
	}
}
