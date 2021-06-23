<?php
/**
 * Comment view file.
 *
 * @package View
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\ModComments\View;

/**
 * Comment view class.
 */
class Comment extends \App\Controller\View
{
	use \App\Controller\ExposeMethodTrait;

	/** @var int Record ID */
	protected $recordId;

	/** @var int Source ID */
	protected $sourceId;

	/** @var string Module name */
	protected $moduleName;

	/** @var string Source module name */
	protected $sourceModule;

	/** {@inheritdoc} */
	public function __construct(\App\Request $request)
	{
		parent::__construct($request);
		$this->exposeMethod('getChildren');
	}

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		$this->recordId = $this->request->getInteger('record');
		$this->sourceId = $this->request->getInteger('sourceId');
		$this->sourceModule = $this->request->getByType('sourceModule', \App\Purifier::ALNUM);
		$this->moduleName = $this->request->getModule();
		if (!\App\User::getUser()->isPermitted($this->sourceModule)) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
		if (!$this->recordId || !$this->sourceId) {
			throw new \App\Exceptions\AppException('ERR_PERMISSION_DENIED');
		}
	}

	/**
	 * Gets comment children.
	 *
	 * @return void
	 */
	public function getChildren()
	{
		$relatedListModel = \YF\Modules\ModComments\Model\RelatedList::getInstance($this->sourceModule)->setRecordId($this->sourceId)->setConditions([
			'fieldName' => 'parent_comments',
			'value' => $this->recordId,
			'operator' => 'eid'
		]);
		$relatedListModel->loadRecordsList();
		$this->viewer->assign('ENTRIES', $relatedListModel->getRecordsListModel());
		$this->viewer->assign('SUB_COMMENT', true);
		$this->viewer->view('Detail/Comments.tpl', 'ModComments');
	}
}
