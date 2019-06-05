/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
"use strict";
window.Products_ProceedToCheckout_Js = class extends Products_Tree_Js {
	constructor(container = $(".js-products-container")) {
		super(container);
		this.container = container;
	}
	registerEvents() {
		super.registerEvents();
		this.registerButtonBuy();
	}
	registerButtonBuy() {
		let self = this;
		this.container.find(".js-buy").on("click", e => {
			Vtiger_Helper_Js.showConfirmationBox({
				message: app.translate("LBL_VERIFY_ADDRESS")
			}).done(function(data) {
				self.order({
					reference_id: self.container.data("referenceId"),
					reference_module: self.container.data("referenceModule")
				});
			});
		});
	}
	order(params = {}) {
		const progressInstance = $.progressIndicatorShow();
		AppConnector.request(
			$.extend(
				{
					module: app.getModuleName(),
					action: "Buy"
				},
				params
			)
		).done(data => {
			progressInstance.progressIndicator({ mode: "hide" });
			let result = data["result"];
			if (typeof result["errors"] === "undefined") {
				if (typeof result["paymentUrl"] === "undefined") {
					app.openUrl(
						"index.php?module=SSingleOrders&view=DetailView&record=" +
							result["id"]
					);
				} else if (typeof result["paymentPostData"] === "undefined") {
					app.openUrl(result["paymentUrl"]);
				} else {
					app.openUrlMethodPost(
						result["paymentUrl"],
						result["paymentPostData"]
					);
				}
			} else {
				this.container
					.find(".js-cart-item .js-no-such-quantity")
					.toggleClass("d-none", true);
				$.each(result["errors"]["inventory"], (index, value) => {
					let quantity = value["params"]["quantity"];
					let product = this.container.find(
						'.js-cart-item[data-id="' + index + '"]'
					);
					product.find(".js-no-such-quantity").removeClass("d-none");
					product.find(".js-maximum-quantity").text(quantity);
				});
				if (result["errors"]["limit"]) {
					Vtiger_Helper_Js.showPnotify({
						text: result["errors"]["limit"],
						type: "error"
					});
				}
			}
		});
	}
};
