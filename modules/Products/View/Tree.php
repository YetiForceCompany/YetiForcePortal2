<?php

/**
 * Tree view class.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\View;

use YF\Modules\Base\Model\ListView as ListViewModel;
use YF\Modules\Base\View;
use YF\Modules\Products\Model\Tree as TreeModel;

/**
 * Class Tree.
 */
class Tree extends View\ListView
{
	const CUSTOM_FIELDS = [
		'productname',
		'product_no',
		'ean',
		'category_multipicklist',
		'productcode',
		'unit_price',
		'taxes',
		'imagename',
		'description'
	];

	/** {@inheritdoc} */
	public function process()
	{
		$this->getListViewModel()
			->setRawData(true)
			->setCustomFields(static::CUSTOM_FIELDS)
			->setLimit(\App\Config::get('itemsPrePage'))
			->setPage($this->request->getInteger('page', 1));
		$search = [];
		$searchText = '';
		if ($this->request->has('search') && !$this->request->isEmpty('search')) {
			$search = $this->request->get('search');
			foreach ($search as &$condition) {
				if ('productname' === $condition['fieldName']) {
					$condition['group'] = false;
					$search[] = [
						'fieldName' => 'ean',
						'value' => $condition['value'],
						'operator' => 'c',
						'group' => false
					];
				}
			}
			$this->getListViewModel()->setConditions($search);
		}
		$this->viewer->assign('SEARCH_TEXT', $searchText);
		$this->viewer->assign('SEARCH', $search);
		$this->viewer->assign('CHECK_STOCK_LEVELS', \App\User::getUser()->get('companyDetails')['check_stock_levels'] ?? false);
		parent::process();
	}

	/** {@inheritdoc} */
	public function preProcess($display = true)
	{
		$moduleName = $this->request->getModule();
		$fields = \App\Api::getInstance()->call('Products/Fields');
		$searchInfo = [];
		if ($this->request->has('search') && !$this->request->isEmpty('search')) {
			foreach ($this->request->get('search') as $condition) {
				$searchInfo[$condition['fieldName']] = $condition['value'];
			}
		}
		$this->viewer->assign('SEARCH_TEXT', $searchInfo['productname'] ?? '');
		$this->viewer->assign('LEFT_SIDE_TEMPLATE', 'Tree/Category.tpl');
		$this->viewer->assign(
			'TREE',
			TreeModel::getInstance()
				->setFields($fields)
				->setSelectedItems([$searchInfo['category_multipicklist'] ?? null])
				->getTree()
		);
		$filterFields = [];
		$filterFieldsName = \App\Config::get('filterInProducts', []);
		foreach ($fields['fields'] as $field) {
			if (\in_array($field['name'], $filterFieldsName)) {
				$fieldInstance = \YF\Modules\Base\Model\Field::getInstance($moduleName, $field);
				$fieldInstance->setRawValue($searchInfo[$field['name']] ?? '');
				$filterFields[] = $fieldInstance;
			}
		}
		$this->viewer->assign('FILTER_FIELDS', $filterFields);
		parent::preProcess($display);
	}

	/** {@inheritdoc} */
	protected function processTplName(): string
	{
		return $this->request->getAction() . '/Tree.tpl';
	}

	/** {@inheritdoc} */
	protected function preProcessTplName(): string
	{
		return $this->request->getAction() . '/TreePreProcess.tpl';
	}

	/** {@inheritdoc} */
	protected function postProcessTplName(): string
	{
		return $this->request->getAction() . '/TreePostProcess.tpl';
	}

	/** {@inheritdoc} */
	protected function getListViewModel()
	{
		if (empty($this->listViewModel)) {
			$this->listViewModel = ListViewModel::getInstance($this->moduleName, 'TreeView');
		}
		return $this->listViewModel;
	}
}
