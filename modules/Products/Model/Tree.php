<?php

/**
 * Tree model class.
 *
 * @package   Model
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

/**
 * Tree model class.
 */
class Tree extends \YF\Modules\Base\Model\AbstractListView
{
	/**
	 * Selected items.
	 *
	 * @var array
	 */
	private $selectedItems = [];

	/**
	 * Set selected items.
	 *
	 * @param array $selectedItems
	 *
	 * @return $this
	 */
	public function setSelectedItems(array $selectedItems)
	{
		$this->selectedItems = $selectedItems;
		return $this;
	}

	/**
	 * Get tree from api.
	 *
	 * @return array
	 */
	public function getTreeFromApi(): array
	{
		if (!$this->fields) {
			$this->fields = \App\Api::getInstance()->call('Products/Fields');
		}
		$tree = [];
		foreach ($this->fields['fields'] as $val) {
			if ('category_multipicklist' === $val['name']) {
				$tree = $val['treeValues'];
				break;
			}
		}
		return $tree;
	}

	/**
	 * Prepare tree data for jstree.
	 *
	 * @return array
	 */
	public function getTree(): array
	{
		$tree = $this->getTreeFromApi();
		foreach ($tree as &$item) {
			$item['state'] = [
				'opened' => true,
				'selected' => \in_array($item['tree'], $this->selectedItems)
			];
		}
		return $tree;
	}
}
