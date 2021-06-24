<?php
/**
 * The file contains: widget of Comments type.
 *
 * @package 	Widget
 *
 * @copyright	YetiForce Sp. z o.o.
 * @license		YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author		Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Widget;

/**
 * Comments type widget class.
 */
class Comments extends RelatedModule
{
	/** @var string Widget type. */
	protected $type = 'Comments';

	/** @var string Module name. */
	protected $moduleName;

	/** @var int Source record ID. */
	protected $recordId;

	/** @var int Page number. */
	protected $page = 1;

	/** @var bool More pages. */
	protected $isMorePages;

	/** @var array Scripts. */
	public $scripts = [];

	/** @var int Limit. */
	public $limit = 5;

	/**
	 * Constructor.
	 *
	 * @param string $moduleName
	 */
	public function __construct(string $moduleName)
	{
		$this->moduleName = $moduleName;
	}

	/**
	 * Gets widget ID.
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->get('id');
	}

	/**
	 * Gets widget type.
	 *
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * Gets module name.
	 *
	 * @return string
	 */
	public function getModuleName(): string
	{
		return $this->moduleName;
	}

	/**
	 * Gets widget name.
	 *
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->get('name');
	}

	/**
	 * Sets record ID.
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

	/**
	 * Get URL address.
	 *
	 * @return string
	 */
	public function getUrl(): string
	{
		return "index.php?module={$this->moduleName}&view=Widget&record={$this->recordId}&mode=getContent&widgetId={$this->getId()}";
	}

	/**
	 * Set page number.
	 *
	 * @param int $page
	 *
	 * @return $this
	 */
	public function setPage(int $page)
	{
		$this->page = $page;
		return $this;
	}

	/**
	 * Get page number.
	 *
	 * @return int
	 */
	public function getPage(): int
	{
		return $this->page;
	}

	/**
	 * Gets fields from related module.
	 *
	 * @return array
	 */
	public function getFields(): array
	{
		return ['parent_comments', 'createdtime', 'modifiedtime', 'related_to', 'id',
			'assigned_user_id', 'commentcontent', 'creator', 'customer', 'reasontoedit', 'userid', 'parents', 'children_count'];
	}

	/**
	 * Gets related module name.
	 *
	 * @return string
	 */
	public function getRelatedModuleName(): string
	{
		return 'ModComments';
	}

	/**
	 * Check if is more pages.
	 *
	 * @return bool
	 */
	public function isMorePages(): bool
	{
		return $this->isMorePages;
	}

	/**
	 * Load data.
	 *
	 * @return $this
	 */
	public function loadData()
	{
		$offset = 0;
		if ($this->limit && $this->page && $this->page > 1) {
			$offset = $this->limit * ($this->page - 1);
		}
		$relatedListModel = \YF\Modules\ModComments\Model\RelatedList::getInstance($this->getModuleName())
			->setRecordId($this->recordId)
			->setConditions([
				'fieldName' => 'parent_comments',
				'value' => '',
				'operator' => 'y'
			])
			->setFields($this->getFields())->setLimit($this->limit)->setOffset($offset);
		$relatedListModel->loadRecordsList();
		$this->entries = $relatedListModel->getRecordsListModel();
		$this->headers = array_intersect_key($relatedListModel->getHeaders(), array_flip($this->getFields()));
		$this->isMorePages = $relatedListModel->isMorePages();
		return $this;
	}

	/**
	 * Gets template path for widget.
	 *
	 * @return string
	 */
	public function getTemplatePath(): string
	{
		return 'Widget/RelatedModule.tpl';
	}

	/**
	 * Gets template path for widget content.
	 *
	 * @return string
	 */
	public function getTemplateContentPath(): string
	{
		return "Widget/{$this->type}Content.tpl";
	}

	/**
	 * Set scripts.
	 *
	 * @param array $scripts
	 */
	public function setScriptsObject($scripts)
	{
		return $this->scripts = $scripts;
	}

	/**
	 * Gets scripts.
	 *
	 * @return array
	 */
	public function getScripts(): array
	{
		return [
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/{$this->moduleName}/resources/Widget/{$this->type}.js", true],
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/Widget/{$this->type}.js", true]
		];
	}
}
