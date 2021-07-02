<?php
/**
 * Widget mini list.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Base\Dashboard;

use YF\Modules\Base\Model\Record;

/**
 * Widget Mini List in dashboard.
 */
class MiniList extends Base
{
	/**
	 * Name template to render before content widget.
	 *
	 * @return string
	 */
	public function getPreProcessTemplate(): string
	{
		return 'Dashboard/Widget/PreMiniList.tpl';
	}

	/**
	 * Name template to render content widget.
	 *
	 * @return string
	 */
	public function getProcessTemplate(): string
	{
		return 'Dashboard/Widget/MiniList.tpl';
	}

	/**
	 * Returns array with records to display.
	 *
	 * @return array
	 */
	public function getRecords(): array
	{
		$records = [];
		foreach ($this->get('records') as $id => $data) {
			$recordModel = Record::getInstance($this->get('modulename'));
			$recordModel->setData($data);
			$recordModel->setId($id);
			$records[$id] = $recordModel;
		}
		return $records;
	}
}
