/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */
jQuery.Class(
	"Install_Install_Js",
	{},
	{
		changeLanguage: function(e) {
			var target = $(e.currentTarget);
			jQuery('input[name="mode"]').val("step1");
			jQuery("form").submit();
		},
		registerEvents: function() {
			$('select[name="lang"]').change(this.changeLanguage);
		}
	}
);
