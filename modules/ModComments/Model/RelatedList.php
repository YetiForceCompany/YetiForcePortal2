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
}
