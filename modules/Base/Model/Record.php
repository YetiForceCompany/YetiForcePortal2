<?php
/**
 * Basic record model class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

class Record extends \YF\Core\BaseModel
{
	/**
	 * Module name.
	 *
	 * @var string
	 */
	private $module;

	/**
	 * Static Function to get the instance of a clean Record for the given module name.
	 *
	 * @param type $module
	 *
	 * @return \self
	 */
	public static function getInstance($module)
	{
		$handlerModule = \YF\Core\Loader::getModuleClassName($module, 'Model', 'Record');
		$instance = new $handlerModule();
		return $instance->setModuleName($module);
	}

	/**
	 * Function to set the id of the record.
	 *
	 * @param \self
	 */
	public function setId($value)
	{
		return $this->set('id', $value);
	}

	/**
	 * Function to get the raw value for a given key.
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public function getDisplayValue($key)
	{
		return isset($this->valueMap['data'][$key]) ? $this->valueMap['data'][$key] : '';
	}

	/**
	 * Function to get the raw value.
	 *
	 * @return array
	 */
	public function getRawData()
	{
		return isset($this->valueMap['rawValue']) ? $this->valueMap['rawValue'] : [];
	}

	/**
	 * Function to get the raw value for a given key.
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public function getRawValue($key)
	{
		return isset($this->valueMap['rawData'][$key]) ? $this->valueMap['rawData'][$key] : '';
	}

	/**
	 * Function to set the name of the module to which the record belongs.
	 *
	 * @param string $value
	 *
	 * @return \self
	 */
	public function setModuleName($value)
	{
		$this->module = $value;
		return $this;
	}

	/**
	 * Record name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->get('recordLabel');
	}

	/**
	 * Function to get the list view actions for the record.
	 *
	 * @return array
	 */
	public function getRecordListViewActions()
	{
		$recordLinks = [];
		if ($this->isViewable()) {
			$recordLinks[] = [
				'linktype' => 'LIST_VIEW_ACTIONS_RECORD_LEFT_SIDE',
				'linklabel' => 'LBL_SHOW_COMPLETE_DETAILS',
				'linkurl' => $this->getDetailViewUrl(),
				'linkicon' => 'glyphicon glyphicon-th-list',
				'linkclass' => 'btn-sm btn-default detailLink'
			];
		}
		if ($this->isEditable()) {
			$recordLinks[] = [
				'linktype' => 'LIST_VIEW_ACTIONS_RECORD_LEFT_SIDE',
				'linklabel' => 'BTN_EDIT',
				'linkurl' => $this->getEditViewUrl(),
				'linkicon' => 'glyphicon glyphicon-pencil',
				'linkclass' => 'btn-sm btn-default'
			];
		}
		if ($this->isDeletable()) {
			$recordLinks[] = [
				'linktype' => 'LIST_VIEW_ACTIONS_RECORD_LEFT_SIDE',
				'linklabel' => 'LBL_DELETE',
				'linkdata' => ['url' => $this->getDeleteUrl()],
				'linkicon' => 'glyphicon glyphicon-trash',
				'linkclass' => 'btn-sm btn-default deleteRecordButton'
			];
		}
		return $recordLinks;
	}

	/**
	 * Function checks if there are permissions to preview record.
	 *
	 * @return bool
	 */
	public function isViewable()
	{
		return true;
	}

	/**
	 * Function to get the Detail View url for the record.
	 *
	 * @return string - Record Detail View Url
	 */
	public function getDetailViewUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&view=DetailView&record=' . $this->getId();
	}

	/**
	 * Function to get the name of the module to which the record belongs.
	 *
	 * @return string - Record Module Name
	 */
	public function getModuleName()
	{
		return $this->module;
	}

	/**
	 * Function to get the id of the record.
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->get('id');
	}

	/**
	 * Function checks if there are permissions to edit record.
	 *
	 * @return bool
	 */
	public function isEditable()
	{
		return true;
	}

	/**
	 * Function to get the Edit View url for the record.
	 *
	 * @return string - Record Edit View Url
	 */
	public function getEditViewUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&view=EditView&record=' . $this->getId();
	}

	/**
	 * Function checks if there are permissions to delete record.
	 *
	 * @return bool
	 */
	public function isDeletable()
	{
		return true;
	}

	/**
	 * Function to get the delete action url for the record.
	 *
	 * @return string
	 */
	public function getDeleteUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&action=Delete&record=' . $this->getId();
	}
}
