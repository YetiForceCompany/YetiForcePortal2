<?php
/**
 * Reference UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
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
		return 'Field/Reference.tpl';
	}

	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		if (\is_array($value)) {
			if ($value['isPermitted']) {
				$url = "index.php?module={$value['referenceModule']}&view=DetailView&record={$value['raw']}";
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

	/** {@inheritdoc} */
	public function getListDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		if (\is_array($value)) {
			if ($value['isPermitted']) {
				$url = "index.php?module={$value['referenceModule']}&view=DetailView&record={$value['raw']}";
				$label = $value['value'];
				$title = \App\Language::translateModule($value['referenceModule']) . ' - ' . $value['value'];
				if ('Active' !== $value['state']) {
					$label = '<s>' . $label . '</s>';
				}
				if (\mb_strlen($label) > \App\Config::$listViewItemMaxLength) {
					$value = "<a class=\"modCT_{$value['referenceModule']} js-popover-tooltip\" data-content=\"$title\" href=\"$url\" >" . \App\TextParser::textTruncate($label, \App\Config::$listViewItemMaxLength) . '</a>';
				} else {
					$value = "<a class=\"modCT_{$value['referenceModule']}\" href=\"$url\" title=\"$title\">$label</a>";
				}
				return $value;
			}
			$value = $value['value'];
		}
		if (\mb_strlen($value) > \App\Config::$listViewItemMaxLength) {
			$value = '<span class="js-popover-tooltip" data-content="' . \App\Purifier::encodeHtml($value) . '">' . \App\TextParser::textTruncate($value, \App\Config::$listViewItemMaxLength) . '</span>';
		}
		return $value;
	}

	/** {@inheritdoc} */
	public function getEditViewDisplayValue(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		$value = [];
		if ($recordModel && !empty($recordModel->get($this->getName()))) {
			$value = $recordModel->get($this->getName());
		} elseif (empty($recordModel->getId()) && ($defaultEditValue = $this->get('defaultEditValue'))) {
			$value = $defaultEditValue;
		}
		return $value;
	}
}
