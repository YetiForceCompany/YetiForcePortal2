<?php

/**
 * Access activity history modal view file.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\View;

/**
 * Access activity history modal view class.
 */
class AccessActivityHistoryModal extends \App\Controller\Modal
{
	/** {@inheritdoc} */
	public $successBtn = '';
	/** @var array Columns to show on the list access activity history. */
	public static $columnsToShow = [
		'time' => 'FL_LOGIN_TIME',
		'status' => 'FL_STATUS',
		'agent' => 'LBL_USER_AGENT',
		'ip' => 'LBL_IP_ADDRESS',
	];

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
	}

	/**  {@inheritdoc}  */
	public function getTitle(): string
	{
		return \App\Language::translate('BTN_YOUR_ACCOUNT_ACCESS_HISTORY', $this->moduleName);
	}

	/** {@inheritdoc} */
	public function getModalIcon(): string
	{
		return 'yfi yfi-login-history';
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$this->viewer->assign('TABLE_COLUMNS', static::$columnsToShow);
		$this->viewer->assign('ACTIVITY_HISTORY', $this->getFormatLoginHistory(\App\Api::getInstance()->call('Users/AccessActivityHistory')));
		$this->viewer->view('Modal/AccessActivityHistoryModal.tpl', $this->request->getModule());
	}

	/**
	 * Get format data access activity history.
	 *
	 * @param array $row
	 *
	 * @return array
	 */
	public function getFormatLoginHistory(array $row): array
	{
		foreach ($row as $keyRow => $values) {
			foreach ($values as $key => $value) {
				switch ($key) {
					case 'agent':
						$values[$key] = \App\Viewer::truncateText($value, 20, true);
						break;
					default:
						break;
				}
				if ('agent' !== $key) {
					$values[$key] = \App\Purifier::encodeHtml($value);
				}
			}
			$row[$keyRow] = $values;
		}
		return $row;
	}
}
