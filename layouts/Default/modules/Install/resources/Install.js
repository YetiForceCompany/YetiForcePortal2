jQuery.Class("Install_Install_Js", {
}, {
	changeLanguage: function(e) {
		var target = $(e.currentTarget);
		jQuery('input[name="mode"]').val('Step1');
		jQuery('form').submit();
	},
	registerEvents: function () {
		$('select[name="lang"]').change(this.changeLanguage);
	}
});
