<?php
/**
 * Date UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Sławomir Kłos <s.klos@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

use App\Json;
use App\Purifier;

/**
 * Date UIType field class.
 */
class DateField extends BaseField
{
	/** {@inheritdoc} */
	public function getEditViewDisplayValue(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		$value = '';
		if ($recordModel && '' !== $recordModel->get($this->getName())) {
			$value = $recordModel->getDisplayValue($this->getName());
		} elseif (empty($recordModel->getId())) {
			$value = $this->get('defaultvalue') ?: '';
		}
		return \App\Purifier::encodeHtml($value);
	}

	/**
	 * Field info.
	 *
	 * @param bool $safe
	 *
	 * @return array|string
	 */
	public function getFieldInfo($safe = false)
	{
		$data = $this->getData();

		$userInstance = \App\User::getUser();
		$data['date-format-js'] = $userInstance->getPreferences('date_format_js');

		switch ($userInstance->getPreferences('date_format_js')) {
			case 'd-m-Y':
				$data['date-format-js2'] = 'DD-MM-YYYY';
				break;
			case 'm-d-Y':
				$data['date-format-js2'] = 'MM-DD-YYYY';
				break;
			case 'Y-m-d':
				$data['date-format-js2'] = 'YYYY-MM-DD';
				break;
			case 'd.m.Y':
				$data['date-format-js2'] = 'DD.MM.YYYY';
				break;
			case 'm.d.Y':
				$data['date-format-js2'] = 'MM.DD.YYYY';
				break;
			case 'Y.m.d':
				$data['date-format-js2'] = 'YYYY.MM.DD';
				break;
			case 'd/m/Y':
				$data['date-format-js2'] = 'DD/MM/YYYY';
				break;
			case 'm/d/Y':
				$data['date-format-js2'] = 'MM/DD/YYYY';
				break;
			case 'Y/m/d':
				$data['date-format-js2'] = 'YYYY/MM/DD';
				break;
		}
		$data['day-of-the-week'] = $userInstance->getPreferences('dayoftheweek');
		switch ($data['day-of-the-week']) {
			case 'Sunday':
				$data['day-of-the-week-int'] = 0;
				break;
			case 'Monday':
				$data['day-of-the-week-int'] = 1;
				break;
			case 'Tuesday':
				$data['day-of-the-week-int'] = 2;
				break;
			case 'Wednesday':
				$data['day-of-the-week-int'] = 3;
				break;
			case 'Thursday':
				$data['day-of-the-week-int'] = 4;
				break;
			case 'Friday':
				$data['day-of-the-week-int'] = 5;
				break;
			case 'Saturday':
				$data['day-of-the-week-int'] = 6;
				break;
		}
		if ($safe) {
			return Purifier::encodeHtml(Json::encode($data));
		}
		return $data;
	}
}
