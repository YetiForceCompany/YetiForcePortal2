{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-Field-Time -->
<input type="text" data-format="{\App\User::getUser()->getPreferences('hour_format')}" class="form-control clockPicker timefieldinput"
	   title="{$FIELD_MODEL->getFieldLabel()}"
	   name="filters[{$FIELD_MODEL->getName()}]" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}'
	   autocomplete="off" />
<!-- tpl-Base-List-Field-Time -->
{/strip}
