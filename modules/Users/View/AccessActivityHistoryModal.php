<?php

/**
 * Access activity history modal view file.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\View;

/**
 * Access activity history modal view class.
 */
class AccessActivityHistoryModal extends \App\Controller\Modal
{
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
		$this->viewer->assign('ACTIVITY_HISTORY', \App\Api::getInstance()->call('Users/AccessActivityHistory'));
		$this->viewer->view('Modal/AccessActivityHistoryModal.tpl', $this->request->getModule());
	}
}
