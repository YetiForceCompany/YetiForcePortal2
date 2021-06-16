<?php
/**
 * Reference UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Reference UIType field class.
 */
class ReferenceField extends BaseField
{
	/** {@inheritdoc} */
	public function getTemplateName(): string
	{
		return 'Field/Edit/Reference.tpl';
	}

	/** {@inheritdoc} */
	public function getDisplayValue(): string
	{
		if (empty($this->value)) {
			return '';
		}
		$value = $this->value;
		if (\is_array($value)) {
			if ($value['isPermitted']) {
				$url = "index.php?module={$value['referenceModule']}&view=DetailView&record={$value['record']}";
				$label = $value['value'];
				$title = \App\Language::translateModule($value['referenceModule']) . ' - ' . $value['value'];
				if ('Active' !== $value['state']) {
					$label = '<s>' . $label . '</s>';
				}
				$value = "<a class=\"modCT_{$value['referenceModule']}\" href=\"$url\" title=\"$title\">$label</a>";
			} else {
				$value = $value['value'];
			}
		}
		return $value;
	}

	/**
	 * Function to get the view value.
	 *
	 * @return string
	 */
	public function getListDisplayValue(): string
	{
		if (empty($this->value)) {
			return '';
		}
		$value = $this->value;
		if (\is_array($value)) {
			if ($value['isPermitted']) {
				$url = "index.php?module={$value['referenceModule']}&view=DetailView&record={$value['record']}";
				$label = $value['value'];
				$title = \App\Language::translateModule($value['referenceModule']) . ' - ' . $value['value'];
				if ('Active' !== $value['state']) {
					$label = '<s>' . $label . '</s>';
				}
				if (\strlen($label) > \App\Config::$listViewItemMaxLength) {
					$label = \App\TextParser::textTruncate($label, \App\Config::$listViewItemMaxLength);
				}
				$value = "<a class=\"modCT_{$value['referenceModule']} js-popover-tooltip\" data-content=\"$title\" href=\"$url\" >" . $label . '</a>';
			} else {
				$value = $value['value'];
			}
		}
		return $value;
	}
}
