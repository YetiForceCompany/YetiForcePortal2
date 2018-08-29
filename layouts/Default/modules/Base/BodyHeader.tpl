{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<header class="bodyHeader d-flex justify-content-end align-items-center">
		<div class="dropdown historyBtn">
			<a class="btn btn-light btn-sm showHistoryBtn mr-2" role="button" href="#" data-placement="left"
			   data-toggle="dropdown"
			   aria-expanded="false">
				<span class="fas fa-history"></span>
			</a>
		</div>
		{if $USER->getCompanies()}
		<a class="btn btn-info btn-sm mr-2" role="button" href="#" data-toggle="modal"
		   data-target="#modalSelectCompanies">
			<span class="fas fa-exchange-alt"></span>
		</a>
		{/if}
		<div class="dropdown quickAction historyBtn">
			<a class="loadPage btn btn-danger btn-sm mr-2" role="button" href="index.php?module=Users&action=Logout">
				<span class="fas fa-power-off" aria-hidden="true"></span>
			</a>
		</div>
	</header>
{/strip}
