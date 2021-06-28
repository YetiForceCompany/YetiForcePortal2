{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
<!-- tpl-Base-List-Field-Time -->
<input type="text" name="filters[{$FIELD_MODEL->getName()}]" class="form-control clockPicker timefieldinput" title="{$FIELD_MODEL->getFieldLabel()}"
	data-format="{\App\User::getUser()->getPreferences('hour_format')}" data-fieldinfo='{\App\Purifier::encodeHtml(\App\Json::encode($FIELD_MODEL->getFieldInfo()))}' autocomplete="off" />
<!-- tpl-Base-List-Field-Time -->
{/strip}
