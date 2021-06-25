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
		$this->exposeMethod('getParents');
	}

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		$this->sourceId = $this->request->getInteger('sourceId');
		$this->sourceModule = $this->request->getByType('sourceModule', \App\Purifier::ALNUM);
		$this->moduleName = $this->request->getModule();
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->sourceModule, 'DetailView') || !\YF\Modules\Base\Model\Module::isPermittedByModule($this->moduleName, 'DetailView')) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
		if (!$this->sourceId) {
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
			'value' => $this->request->getInteger('record', '-1'),
			'operator' => 'eid'
		])->setOrder('createdtime', 'ASC');
		$relatedListModel->loadRecordsList();
		$this->viewer->assign('ENTRIES', $relatedListModel->getRecordsListModel());
		$this->viewer->assign('SUB_COMMENT', true);
		$this->viewer->view('Detail/Comments.tpl', 'ModComments');
	}

	/**
	 * Gets parent comments.
	 *
	 * @return void
	 */
	public function getParents()
	{
		$page = $this->request->getInteger('page', 1);
		$limit = $this->request->getInteger('limit', 10);
		$offset = 0;
		if ($limit && $page && $page > 1) {
			$offset = $limit * ($page - 1);
		}
		$relatedListModel = \YF\Modules\ModComments\Model\RelatedList::getInstance($this->sourceModule)->setRecordId($this->sourceId)->setConditions([
			'fieldName' => 'parent_comments',
			'value' => '',
			'operator' => 'y'
		])->setLimit($limit)->setOffset($offset);
		$relatedListModel->loadRecordsList();
		$this->viewer->assign('ENTRIES', $relatedListModel->getRecordsListModel());
		$this->viewer->assign('SUB_COMMENT', false);
		$this->viewer->assign('IS_MORE_PAGES', $relatedListModel->isMorePages());
		$this->viewer->assign('PAGE', $page);
		$this->viewer->view('Detail/CommentsContent.tpl', 'ModComments');
	}
}
