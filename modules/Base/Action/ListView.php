<?php
/**
 * List view action file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

/**
 * List view action class.
 */
class ListView extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function process(): void
	{
		$listViewModel = \YF\Modules\Base\Model\ListView::getInstance($this->moduleName, $this->request->getAction());
		$rows = $columns = $fields = [];
		foreach ($this->request->getArray('columns') as $key => $value) {
			$columns[$key] = $value['name'];
			if ($value['name']) {
				$fields[] = $value['name'];
			}
		}
		$order = current($this->request->getArray('order', \App\Purifier::ALNUM));
		if ($order && isset($columns[$order['column']], $columns[$order['column']])) {
			$listViewModel->setOrder($columns[$order['column']], strtoupper($order['dir']));
		}
		if ($this->request->has('filters') && !$this->request->isEmpty('filters')) {
			$conditions = [];
			foreach ($this->request->getArray('filters') as $fieldName => $value) {
				if ('' !== $value) {
					$conditions[] = [
						'fieldName' => $fieldName,
						'value' => $value,
						'operator' => 'a',
					];
				}
			}
			$listViewModel->setConditions($conditions);
		}
		$listViewModel->setFields($fields);
		$listViewModel->setLimit($this->request->getInteger('length'));
		$listViewModel->setOffset($this->request->getInteger('start'));
		$listViewModel->loadRecordsList();
		foreach ($listViewModel->getRecordsListModel() as $id => $recordModel) {
			$row = [];
			foreach ($columns as $column) {
				if ($column) {
					$value = $recordModel->getListDisplayValue($column);
				} else {
					$value = $recordModel->getRecordListViewActions();
				}
				$row[] = $value;
			}
			$rows[] = $row;
		}
		$response = [
			'draw' => $this->request->getInteger('draw'),
			'iTotalDisplayRecords' => $listViewModel->getCount(),
			'aaData' => $rows
		];
		header('content-type: text/json; charset=UTF-8');
		echo \App\Json::encode($response);
	}
}
