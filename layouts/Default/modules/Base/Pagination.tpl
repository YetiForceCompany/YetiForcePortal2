{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{assign var=PAGE value=$LIST_VIEW_MODEL->getPage()}
	{assign var=IS_MORE_PAGES value=$LIST_VIEW_MODEL->isMorePages()}
	{if !(PAGE==1 && !IS_MORE_PAGES) }
		<nav aria-label="Page navigation c-page">
			<ul class="pagination u-mb-0px js-pagination-list d-flex align-items-center" data-page="{$PAGE}">
				<li class="page-item c-page__item {if $LIST_VIEW_MODEL->getPage() < 2} disabled{/if}">
					<a class="page-link c-page__link js-page-previous" href="#">
						<i class="fas fa-chevron-left u-fs-22px"></i>
					</a>
				</li>
				{if $PAGE > 1}
					<li class="page-item c-page__item"><a class="page-link c-page__link js-page-item" href="#" data-page="{$PAGE - 1}">{$PAGE - 1}</a></li>
				{/if}
				<li class="page-item c-page__item active"><a class="page-link c-page__link js-page-item-current" href="#" data-page="{$PAGE}">{$PAGE}</a></li>
				{if $IS_MORE_PAGES}
					<li class="page-item c-page__item"><a class="page-link c-page__link js-page-item" href="#" data-page="{$PAGE + 1}">{$PAGE + 1}</a></li>
				{/if}
				<li class="page-item c-page__item {if !$IS_MORE_PAGES} disabled{/if}">
					<a class="page-link c-page__link js-page-next" href="#">
						<i class="fas fa-chevron-right u-fs-22px"></i>
					</a>
				</li>
			</ul>
		</nav>
	{/if}
{/strip}
