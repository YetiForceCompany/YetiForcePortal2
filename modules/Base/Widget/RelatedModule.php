<?php
/**
 * The file contains: Abstract class ListView.
 *
 * @package 	Model
 *
 * @copyright	YetiForce Sp. z o.o.
 * @license		YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author		Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Widget;

use YF\Modules\Base\Model\Record;

/**
 * Abstract class ListView.
 */
class RelatedModule extends \App\BaseModel
{
	/** @var string Widget type. */
	protected $type = 'RelatedModule';

	/** @var string Module name. */
	protected $moduleName;

	/** @var int Source record ID. */
	protected $recordId;

	/** @var array Entries. */
	protected $entries;

	/** @var array Scripts. */
	public $scripts = [];

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
	 * @return self
	 */
	public function setRecordId(int $recordId): self
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
	 * Gets related module name.
	 *
	 * @return string
	 */
	public function getRelatedModuleName(): string
	{
		return $this->get('data')['relatedModuleName'];
	}

	/**
	 * Gets fields from related module.
	 *
	 * @return void
	 */
	public function getFields()
	{
		return $this->get('data')['relatedfields'] ?: [];
	}

	/**
	 * Gets relation ID.
	 *
	 * @return int|null
	 */
	public function getRelationId()
	{
		return $this->get('data')['relation_id'] ?? null;
	}

	/**
	 * Gets custom view ID.
	 *
	 * @return int|null
	 */
	public function getCvId()
	{
		return isset($this->get('data')['customView']) ? current($this->get('data')['customView']) : null;
	}

	/**
	 * Gets entries.
	 *
	 * @return array
	 */
	public function getEntries(): array
	{
		if (null === $this->entries) {
			$this->entries = [];

			$headers = ['x-fields' => \App\Json::encode($this->getFields())];
			$api = \App\Api::getInstance();
			$api->setCustomHeaders($headers);
			$body = [];
			if ($relationId = $this->getRelationId()) {
				$body['relationId'] = $relationId;
			}
			if ($cvId = $this->getCvId()) {
				$body['cvId'] = $cvId;
			}

			$response = $api->call("{$this->moduleName}/RecordRelatedList/{$this->recordId}/{$this->getRelatedModuleName()}", $body) ?: [];
			if (!empty($response['records'])) {
				foreach ($response['records'] as $id => $data) {
					$recordModel = Record::getInstance($this->getRelatedModuleName());
					$recordModel->setData($data);
					$recordModel->setId($id);
					$this->entries[$id] = $recordModel;
				}
			}
		}
		return $this->entries;
	}

	/**
	 * Gets template path for widget.
	 *
	 * @return string
	 */
	public function getTemplatePath(): string
	{
		return "Widget/{$this->type}.tpl";
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
