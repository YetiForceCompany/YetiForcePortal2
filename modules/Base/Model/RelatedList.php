<?php
/**
 * Related list view model file.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

use App\Purifier;

/**
 * Related list view model class.
 */
class RelatedList extends AbstractListView
{
	/** @var \App\Request Request object. */
	protected $request;

	/** @var string Related module name. */
	protected $relatedModuleName;

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
				$recordModel->setData($value)->setId($id);
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
}
