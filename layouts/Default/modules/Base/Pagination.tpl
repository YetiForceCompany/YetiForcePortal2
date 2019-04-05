{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	{assign var=PAGE value=$LIST_VIEW_MODEL->getPage()}
	{assign var=IS_MORE_PAGES value=$LIST_VIEW_MODEL->isMorePages()}
	<nav aria-label="Page navigation">
		<ul class="pagination js-pagination-list" data-page="{$PAGE}">
			<li class="page-item{if $LIST_VIEW_MODEL->getPage() < 2} disabled{/if}"><a class="page-link js-page-previous" href="#">Previous</a></li>
			<li class="page-item active"><a class="page-link js-page-item-current" href="#" data-page="{$PAGE}">{$PAGE}</a></li>
			<li class="page-item{if !$IS_MORE_PAGES} disabled{/if}"><a class="page-link js-page-item" href="#" data-page="{$PAGE + 1}">{$PAGE + 1}</a></li>
			<li class="page-item{if !$IS_MORE_PAGES} disabled{/if}"><a class="page-link js-page-item" href="#" data-page="{$PAGE + 2}">{$PAGE + 2}</a></li>
			<li class="page-item{if !$IS_MORE_PAGES} disabled{/if}"><a class="page-link js-page-next" href="#">Next</a></li>
		</ul>
	</nav>
{/strip}
