<?php
/**
 * ModComments record model file.
 *
 * @package Model
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\ModComments\Model;

/**
 * ModComments record model class.
 */
class Record extends \YF\Modules\Base\Model\Record
{
	/** @var array Sub-comments */
	private $children = [];

	/**
	 * Get commentator name.
	 *
	 * @return string
	 */
	public function getCommentatorName(): string
	{
		$name = $this->get('assigned_user_id');
		if ($this->get('customer')) {
			$name = $this->getDisplayValue('customer');
		}
		return $name ?: '';
	}

	/**
	 * Gets sub-comments.
	 *
	 * @return array
	 */
	public function getChildren(): array
	{
		return $this->children;
	}

	/**
	 * Sets sub-comment.
	 *
	 * @param \YF\Modules\Base\Model\Record $recordModel
	 *
	 * @return $this
	 */
	public function setChild(\YF\Modules\Base\Model\Record $recordModel)
	{
		$this->children[$recordModel->getId()] = $recordModel;
		return $this;
	}

	/**
	 * Get URL address.
	 *
	 * @return string
	 */
	public function getChildrenUrl(): string
	{
		$url = '';
		if ($parent = $this->get('related_to')) {
			$url = "index.php?module={$this->moduleName}&view=Comment&record={$this->getId()}&mode=getChildren&sourceId={$parent['raw']}&sourceModule={$parent['referenceModule']}";
		}
		return $url;
	}
}
