{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<div class="bodyHeader form-row p-0">
		<div class="col-sm-3">
		</div>
		<div class="col-sm-9 d-flex justify-content-end align-items-center">
			<div class="dropdown quickAction historyBtn">
				<a href="index.php?module=Users&action=Logout" role="button" class="loadPage btn btn-danger btn-sm">
					<span class="fas fa-power-off" aria-hidden="true"></span>
				</a>
			</div>
			{*{if $USER->getCompanies()}*}
			<a type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalSelectCompanies"
			   href="#">
				<span class="fas fa-exchange-alt" aria-hidden="true"></span>
			</a>
			{*{/if}*}
			<div class="dropdown historyBtn">
				<a data-placement="left" role="button" data-toggle="dropdown"
				   class="btn btn-light btn-sm showHistoryBtn"
				   aria-expanded="false" href="#">
					<span class="fas fa-history"></span>
				</a>
			</div>
		</div>
	</div>
{/strip}
