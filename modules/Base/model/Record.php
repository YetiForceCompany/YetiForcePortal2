<?php
/**
 * Basic Record Model Class
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace YF\Modules\Base\Model;

use YF\Core;

class Record extends \YF\Core\BaseModel
{

	/**
	 * Module name
	 * @var string
	 */
	private $module;

	/**
	 * Raw data
	 * @var array
	 */
	private $rawData = [];

	/**
	 * Function to get the id of the record
	 * @return int
	 */
	public function getId()
	{
		return $this->get('id');
	}

	/**
	 * Function to set the id of the record
	 * @param \self
	 */
	public function setId($value)
	{
		return $this->set('id', $value);
	}

	/**
	 *
	 * @param array $value
	 * @return $this
	 */
	public function setRawData($value)
	{
		$this->rawData = $value;
		return $this;
	}

	/**
	 * Function to set the name of the module to which the record belongs
	 * @param string $value
	 * @return \self
	 */
	public function setModuleName($value)
	{
		$this->module = $value;
		return $this;
	}

	/**
	 * Function to get the name of the module to which the record belongs
	 * @return string - Record Module Name
	 */
	public function getModuleName()
	{
		return $this->module;
	}

	/**
	 * Record name
	 * @return string
	 */
	public function getName()
	{
		return $this->get('recordLabel');
	}

	/**
	 * Get raw value
	 * @param string $key
	 * @return mixed
	 */
	public function getRawValue($key)
	{
		return isset($this->rawData[$key]) ? $this->rawData[$key] : null;
	}

	/**
	 * Static Function to get the instance of a clean Record for the given module name
	 * @param type $module
	 * @return \self
	 */
	public static function getInstance($module)
	{
		$handlerModule = \YF\Core\Loader::getModuleClassName($module, 'Model', 'Record');
		$instance = new $handlerModule();
		return $instance->setModuleName($module);
	}

	/**
	 * Function to get the Detail View url for the record
	 * @return string - Record Detail View Url
	 */
	public function getDetailViewUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&view=DetailView&record=' . $this->getId();
	}

	/**
	 * Function to get the Edit View url for the record
	 * @return string - Record Edit View Url
	 */
	public function getEditViewUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&view=EditView&record=' . $this->getId();
	}

	/**
	 * Function to get the delete action url for the record
	 * @return string
	 */
	public function getDeleteUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&action=Delete&record=' . $this->getId();
	}

	/**
	 * Function to get the list view actions for the record
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
	 * Function checks if there are permissions to preview record
	 * @return boolean
	 */
	public function isViewable()
	{
		return true;
	}

	/**
	 * Function checks if there are permissions to edit record
	 * @return boolean
	 */
	public function isEditable()
	{
		return true;
	}

	/**
	 * Function checks if there are permissions to delete record
	 * @return boolean
	 */
	public function isDeletable()
	{
		return true;
	}

	/**
	 * Function to retieve display value for a field
	 * @param string $fieldName - field name for which values need to get
	 * @return string
	 */
	public function getEditViewDisplayValue($fieldName)
	{
		return $this->get($fieldName);
	}
}
