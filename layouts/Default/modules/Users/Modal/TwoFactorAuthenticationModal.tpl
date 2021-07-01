{*<!-- {[The file is published on the basis of YetiForce Public License 4.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Users-Modal-TwoFactorAuthenticationModal -->
<input type="hidden" id="methods" value="{$AUTH_METHODS}"/>
<input type="hidden" id="secret" value="{$SECRET_KEY}"/>
<form class="modal-body">
	{if empty($SECRET_KEY)}
		<div class="alert alert-info">
			{\App\Language::translate('LBL_2FA_SECRET_ALREADY_SET', $MODULE_NAME)}
		</div>
		<div class="col-sm-12 my-2">
			<label class="mr-3" for="turn-off-2fa">{\App\Language::translate('LBL_2FA_OFF', $MODULE_NAME)}</label>
			<input type="checkbox" name="turn_off_2fa" id="turn-off-2fa" data-validation-engine="validate[required]" />
		</div>
	{else}
		<div class="js-qr-code" data-js="container|css:display">
			<div class="col-sm-12 p-0 pb-3 border-bottom">
				{\App\Language::translate('LBL_2FA_SECRET', $MODULE_NAME)}: <strong>{$SECRET_KEY}</strong>
			</div>
			<div class="col-sm-12 p-0 my-2 d-flex justify-content-center">
				{$QR_CODE_HTML}
			</div>
		</div>
		<div class="col-sm-12 pt-3 border-top form-inline js-user-code" data-js="container|css:display">
			<label for="user_code">
				{\App\Language::translate('LBL_AUTHENTICATION_CODE', $MODULE_NAME)}:
			</label>
			<input class="form-control ml-2" id="user_code" type="text" value=""/>
		</div>
		<div class="alert alert-info show mt-3 mb-0" role="alert">
			<a href="https://doc.yetiforce.com/apps/#2FA" target="_blank" class="btn btn-outline-info float-right js-popover-tooltip" data-content="{App\Language::translate('BTM_GOTO_YETIFORCE_DOCUMENTATION')}" rel="noreferrer noopener" data-js="popover">
				<span class="mdi mdi-book-open-page-variant u-fs-lg"></span>
			</a>
			<span class="mdi mdi-information-outline u-fs-38px mr-2 float-left"></span>
			{\App\Language::translate('LBL_2FA_TOTP_DESC', $MODULE_NAME)}<br />
		</div>
	{/if}
</form>
<!-- /tpl-Users-Modal-TwoFactorAuthenticationModal -->
{/strip}
