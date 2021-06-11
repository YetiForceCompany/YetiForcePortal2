/* {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} */

'use strict';
$(document).ready(() => {
	$('form')
		.find('[name="language"]')
		.find('option')
		.each(function () {
			let element = $(this);
			if (navigator.language.split('-', 1) === element.val().split('-', 1)) {
				element.attr('selected', true);
			}
		});

	let formChange = $('.js-change-password');
	formChange.on('submit', (event) => {
		event.preventDefault();
		let password = formChange.find('[name="password"]').val();
		let confirmPassword = formChange.find('[name="confirm_password"]').val();
		if (password !== confirmPassword) {
			$('.js-alert-confirm-password').removeClass('d-none');
		} else {
			$.post('index.php?module=Users&action=LoginPassReset&mode=token', {
				password: password,
				confirm_password: confirmPassword,
				token: formChange.find('[name="token"]').val()
			});
		}
	});
});
