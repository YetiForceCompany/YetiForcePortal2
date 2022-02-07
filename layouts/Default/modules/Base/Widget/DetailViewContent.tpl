{*<!-- {[The file is published on the basis of YetiForce Public License 5.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
	<!-- tpl-Base-Widget-DetailViewContent -->
	<div class="">
		{assign var="RECORD" value=$WIDGET->getRecordModel()}
		{include file=\App\Resources::templatePath('Detail/DetailView.tpl', $WIDGET->getModuleName()) RECORD=$RECORD BLOCKS=$RECORD->getModuleModel()->getBlocks() FIELDS_FORM=$WIDGET->getStructure() SHOW_INVENTORY_RIGHT_COLUMN=false INVENTORY_FIELDS=false }
	</div>
	<!-- /tpl-Base-Widget-DetailViewContent -->
{/strip}
