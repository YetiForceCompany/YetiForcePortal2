<?php
/**
 * Related list view action file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

/**
 * Related list view action class.
 */
class RelatedListView extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function process(): void
	{
		$relatedListModel = \YF\Modules\Base\Model\RelatedList::getInstance($this->moduleName, 'RelatedList');
		$relatedListModel->setRequest($this->request);
		$rows = $columns = $fields = [];
		foreach ($this->request->getArray('columns') as $key => $value) {
			$columns[$key] = $value['name'];
			if ($value['name']) {
				$fields[] = $value['name'];
			}
		}
		$order = current($this->request->getArray('order', \App\Purifier::ALNUM));
		if ($order && isset($columns[$order['column']], $columns[$order['column']])) {
			$relatedListModel->setOrder($columns[$order['column']], strtoupper($order['dir']));
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
			$relatedListModel->setConditions($conditions);
		}
		$relatedListModel->setFields($fields);
		$relatedListModel->setLimit($this->request->getInteger('length'));
		$relatedListModel->setOffset($this->request->getInteger('start'));
		$relatedListModel->loadRecordsList();
		foreach ($relatedListModel->getRecordsListModel() as $id => $recordModel) {
			$row = [];
			foreach ($columns as $column) {
				if ($column) {
					$value = $recordModel->getListDisplayValue($column);
				} else {
					$value = $recordModel->getRelatedListActions();
				}
				$row[] = $value;
			}
			$rows[] = $row;
		}
		$response = [
			'draw' => $this->request->getInteger('draw'),
			'iTotalDisplayRecords' => $relatedListModel->getCount(),
			'iTotalRecords' => $relatedListModel->getCount(),
			'aaData' => $rows,
		];
		header('content-type: text/json; charset=UTF-8');
		echo \App\Json::encode($response);
	}
}
