<?php
/**
 * ModComments record model file.
 *
 * @package Model
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\ModComments\Model;

/**
 * ModComments record model class.
 */
class Record extends \YF\Modules\Base\Model\Record
{
	/** @var Sub-comments */
	private $children = [];

	/**
	 * Get commentator name.
	 *
	 * @return string
	 */
	public function getCommentatorName(): string
	{
		$name = $this->get('assigned_user_id');
		if ($customer = $this->get('customer')) {
			$name = $customer['value'];
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
}
