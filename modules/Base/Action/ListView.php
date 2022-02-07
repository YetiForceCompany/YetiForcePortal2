<?php
/**
 * List view action file.
 *
 * @package Action
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
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
		$listModel = \YF\Modules\Base\Model\ListView::getInstance($this->moduleName, $this->request->getAction());
		$rows = $columns = $fields = [];
		foreach ($this->request->getArray('columns') as $key => $value) {
			$columns[$key] = $value['name'];
			if ($value['name']) {
				$fields[] = $value['name'];
			}
		}
		$order = current($this->request->getArray('order', \App\Purifier::ALNUM));
		if ($order && isset($columns[$order['column']], $columns[$order['column']])) {
			$listModel->setOrder($columns[$order['column']], strtoupper($order['dir']));
		}
		if ($this->request->has('filters') && !$this->request->isEmpty('filters')) {
			$moduleModel = \YF\Modules\Base\Model\Module::getInstance($this->moduleName);
			$conditions = [];
			foreach ($this->request->getArray('filters') as $fieldName => $value) {
				if ('' !== $value) {
					$conditions[] = [
						'fieldName' => $fieldName,
						'value' => \is_array($value) ? implode('##', $value) : $value,
						'operator' => $moduleModel->getFieldModel($fieldName)->getOperator(),
					];
				}
			}
			$listModel->setConditions($conditions);
		}
		$listModel->setFields($fields);
		$listModel->setLimit($this->request->getInteger('length'));
		$listModel->setOffset($this->request->getInteger('start'));
		$listModel->loadRecordsList();
		foreach ($listModel->getRecordsListModel() as $id => $recordModel) {
			$row = [];
			foreach ($columns as $column) {
				if ($column) {
					$value = $recordModel->getListDisplayValue($column);
				} else {
					$value = $recordModel->getListViewActions();
				}
				$row[] = $value;
			}
			$rows[] = $row;
		}
		$response = [
			'draw' => $this->request->getInteger('draw'),
			'iTotalDisplayRecords' => $listModel->getCount(),
			'iTotalRecords' => $listModel->getCount(),
			'aaData' => $rows,
		];
		header('content-type: text/json; charset=UTF-8');
		echo \App\Json::encode($response);
	}
}
