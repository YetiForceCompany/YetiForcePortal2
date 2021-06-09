{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Users-Modal-PasswordChangeModal -->
<form name="PasswordUsersForm" class="form-horizontal" autocomplete="off" >
	<input type="hidden" name="module" value="{$MODULE_NAME}" />
	<input type="hidden" name="action" value="PasswordChangeModal" />
	<div class="modal-body">
		<div class="form-group">
			<label class="col-form-label col-sm-4">{\App\Language::translate('LBL_OLD_PASSWORD', $MODULE_NAME)}</label>
			<div class="controls col-sm-6 input-group">
				<input type="password" name="oldPassword" class="form-control" data-validation-engine="validate[required]" autocomplete="off" />
				<span class="input-group-append">
					<button class="btn btn-light js-popover-tooltip" data-content="{\App\Language::translate('LBL_SHOW_PASSWORD', $MODULE_NAME)}" type="button" onmousedown="oldPassword.type = 'text';" onmouseup="oldPassword.type = 'password';" onmouseout="oldPassword.type = 'password';" data-js="popover">
						<span class="fas fa-eye"></span>
					</button>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 col-form-label">{\App\Language::translate('LBL_NEW_PASSWORD', $MODULE_NAME)}</label>
			<div class="col-sm-6 controls input-group">
				<input type="password" name="password" id="passwordUsersFormPassword" title="{\App\Language::translate('LBL_NEW_PASSWORD', $MODULE_NAME)}" class="form-control" data-validation-engine="validate[required]" autocomplete="off" />
				<span class="input-group-append">
					<button class="btn btn-light js-popover-tooltip" data-content="{\App\Language::translate('LBL_SHOW_PASSWORD',$MODULE_NAME)}" type="button" onmousedown="password.type = 'text';" onmouseup="password.type = 'password';" onmouseout="password.type = 'password';" data-js="popover">
						<span class="fas fa-eye"></span>
					</button>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 col-form-label">{\App\Language::translate('LBL_CONFIRM_PASSWORD', $MODULE_NAME)}</label>
			<div class="col-sm-6 controls input-group">
				<input type="password" name="confirm_password" id="confirmPasswordUsersFormPassword" title="{\App\Language::translate('LBL_CONFIRM_PASSWORD', $MODULE_NAME)}" class="form-control" data-validation-engine="validate[required,equals[passwordUsersFormPassword]]" autocomplete="off" />
				<span class="input-group-append">
					<button class="btn btn-light js-popover-tooltip" data-content="{\App\Language::translate('LBL_SHOW_PASSWORD',$MODULE_NAME)}" type="button" onmousedown="confirm_password.type = 'text';" onmouseup="confirm_password.type = 'password';" onmouseout="confirm_password.type = 'password';" data-js="popover">
						<span class="fas fa-eye"></span>
					</button>
				</span>
			</div>
		</div>
	</div>
<!-- /tpl-Users-Modal-PasswordChangeModal -->
{/strip}
