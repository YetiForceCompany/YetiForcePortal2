<?php
/**
 * Documents file upload UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Documents file upload UIType field class.
 */
class DocumentsFileUploadField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		if (\is_array($value)) {
			if (isset($value['url'])) {
				$url = $value['url'];
				if (\mb_strlen($url) > 50) {
					$url = \App\TextParser::textTruncate($url, 50);
				}
				$value = '<a href="' . \App\Purifier::encodeHtml($value['url']) . '" title="' . \App\Purifier::encodeHtml($value['url']) . '" target="_blank" rel="noreferrer noopener">' . $url . '</a>';
			} else {
				$url = 'file.php?' . http_build_query($value['postData']);
				$value = '<a href="' . $url . '" title="' . \App\Purifier::encodeHtml($value['name']) . '">' . \App\Purifier::encodeHtml($value['name']) . '</a>';
			}
		}
		return $value;
	}
}
