/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

'use strict';
$(document).ready(() => {
	$('form')
		.find('[name="language"]')
		.find('option')
		.each(function () {
			let element = $(this);
			if (navigator.language === element.val()) {
				element.attr('selected', true);
			}
		});
});
