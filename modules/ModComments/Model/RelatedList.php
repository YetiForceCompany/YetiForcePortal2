<?php
/**
 * Related list view model file.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author	  Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\ModComments\Model;

/**
 * Related list view model class.
 */
class RelatedList extends \YF\Modules\Base\Model\RelatedList
{
	/** {@inheritdoc} */
	protected $order = 'DESC';

	/** {@inheritdoc} */
	protected $orderField = 'createdtime';

	/** {@inheritdoc} */
	protected $rawData = true;

	/** {@inheritdoc} */
	protected $relatedModuleName = 'ModComments';

	/** {@inheritdoc} */
	protected $actionName = 'RecordRelatedList';

	/** {@inheritdoc} */
	protected $fields = ['parent_comments', 'createdtime', 'modifiedtime', 'related_to', 'id',
		'assigned_user_id', 'commentcontent', 'creator', 'customer', 'reasontoedit', 'userid', 'parents'];

	/** @var int Record ID */
	protected $recordId;

	/** @var array Records Models */
	protected $recordsModel = [];

	/** {@inheritdoc} */
	public static function getInstance(string $moduleName, string $viewName = 'ListView')
	{
		$self = new self();
		$self->moduleName = $moduleName;
		$self->limit = 100;
		return $self;
	}

	/**
	 * Set record ID.
	 *
	 * @param int $recordId
	 *
	 * @return $this
	 */
	public function setRecordId(int $recordId)
	{
		$this->recordId = $recordId;
		return $this;
	}

	/** {@inheritdoc} */
	protected function getFromApi(array $headers): array
	{
		$api = \App\Api::getInstance();
		$api->setCustomHeaders($headers);
		return $api->call("{$this->getModuleName()}/RecordRelatedList/{$this->recordId}/{$this->relatedModuleName}");
	}

	/**
	 * Gets records tree.
	 *
	 * @return array
	 */
	public function getRecordsTree(): array
	{
		$recordsModel = [];
		if (!empty($this->recordsList['records'])) {
			foreach ($this->recordsList['records'] as $id => $value) {
				$recordModel = $this->getRecordById($id);

				if (!($parentId = $recordModel->getRawValue('parent_comments'))) {
					$recordsModel[$id] = $recordModel;
				} elseif ($parentRecord = $this->getRecordById($parentId)) {
					$parentRecord->setChild($recordModel);
				}
			}
		}
		return $recordsModel;
	}

	/**
	 * Gets record model.
	 *
	 * @param int $recordId
	 *
	 * @return \YF\Modules\Base\Model\Record|null
	 */
	public function getRecordById(int $recordId)
	{
		if (!isset($this->recordModels[$recordId]) && ($value = $this->recordsList['records'][$recordId] ?? null)) {
			$recordModel = Record::getInstance($this->relatedModuleName);
			if (isset($value['recordLabel'])) {
				$recordModel->setName($value['recordLabel']);
				unset($value['recordLabel']);
			}
			if (isset($this->recordsList['rawData'][$recordId])) {
				$recordModel->setRawData($this->recordsList['rawData'][$recordId]);
			}
			$recordModel->setData($value)->setId($recordId)->setPrivileges($this->recordsList['permissions'][$recordId]);
			$this->recordModels[$recordId] = $recordModel;
		}
		return $this->recordModels[$recordId] ?? null;
	}
}
