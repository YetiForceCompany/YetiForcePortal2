<?php
/**
 * Related list view model file.
 *
 * @package   Model
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

use App\Purifier;

/**
 * Related list view model class.
 */
class RelatedList extends AbstractListView
{
	/** @var array Relation details. */
	protected $relation;

	/** @var string Related module name. */
	protected $relatedModuleName;

	/** @var \App\Request Request object. */
	protected $request;

	/** {@inheritdoc} */
	protected $actionName = 'RecordRelatedList';

	/** {@inheritdoc} */
	protected function getFromApi(array $headers): array
	{
		$api = \App\Api::getInstance();
		$api->setCustomHeaders($headers);
		return $api->call("{$this->getModuleName()}/RecordRelatedList/{$this->request->getInteger('record')}/{$this->relatedModuleName}", [
			'relationId' => $this->request->getInteger('relationId'),
		]);
	}

	/** {@inheritdoc} */
	public function getDefaultCustomView(): ?int
	{
		return null;
	}

	/**
	 * Set request.
	 *
	 * @param \App\Request $request
	 *
	 * @return void
	 */
	public function setRequest(\App\Request $request): void
	{
		$this->request = $request;
		$this->relatedModuleName = $request->getByType('relatedModuleName', Purifier::ALNUM);
	}

	/**
	 * Set relation details.
	 *
	 * @param array $relation
	 *
	 * @return void
	 */
	public function setRelation(array $relation): void
	{
		$this->relation = $relation;
	}

	/**
	 * Get related module name.
	 *
	 * @return string
	 */
	public function getRelatedModuleName(): string
	{
		return $this->relatedModuleName;
	}

	/**
	 * Get relation detail by name.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function getRelation(string $name)
	{
		return $this->relation[$name] ?? null;
	}

	/**
	 * Get records list model.
	 *
	 * @return Record[]
	 */
	public function getRecordsListModel(): array
	{
		$recordsModel = [];
		if (!empty($this->recordsList['records'])) {
			foreach ($this->recordsList['records'] as $id => $value) {
				$recordModel = Record::getInstance($this->relatedModuleName);
				if (isset($value['recordLabel'])) {
					$recordModel->setName($value['recordLabel']);
					unset($value['recordLabel']);
				}
				$recordModel->setData($value)->setId($id)->setPrivileges($this->recordsList['permissions'][$id]);
				$recordsModel[$id] = $recordModel;
			}
		}
		if (!empty($this->recordsList['rawData'])) {
			foreach ($this->recordsList['rawData'] as $id => $value) {
				$recordsModel[$id]->setRawData($value);
			}
		}
		return $recordsModel;
	}

	/**
	 * Get actions.
	 *
	 * @return array
	 */
	public function getActions(): array
	{
		$record = $this->request->getInteger('record');
		$relationId = $this->request->getInteger('relationId');
		$moduleModel = Module::getInstance($this->relatedModuleName);
		$links = [];
		$actions = $this->getRelation('actions');
		if (\in_array('select', $actions)) {
			/* @todo To be completed
			$links[] = [
				'label' => 'BTN_SELECT_RECORD',
				'moduleName' => $this->relatedModuleName,
				'data' => ['url' => $this->relatedModuleName, 'source-record' => $record, 'source-module' => $this->getModuleName()],
				'icon' => 'fas fa-search',
				'class' => 'btn-sm btn-outline-secondary js-search-records',
				'showLabel' => 1,
			];
			*/
		}
		if (\in_array('add', $actions)) {
			if ($moduleModel->isPermitted('CreateView')) {
				$links[] = [
					'label' => 'BTN_ADD_RECORD',
					'moduleName' => $this->relatedModuleName,
					'data' => ['url' => "index.php?module={$this->relatedModuleName}&view=QuickCreateModal&sourceModule={$this->getModuleName()}&sourceRecord={$record}&relationOperation=true&relationId={$relationId}"],
					'icon' => 'fas fa-plus',
					'class' => 'btn-sm btn-success js-create-related-record',
					'showLabel' => 1,
				];
			}
		}
		return $links;
	}
}
