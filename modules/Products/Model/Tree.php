<?php

/**
 * Tree model class.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

/**
 * Tree model class.
 */
class Tree extends \App\BaseModel
{
	/**
	 * Selected items.
	 *
	 * @var array
	 */
	private $selectedItems = [];

	/**
	 * Get instance.
	 *
	 * @return self
	 */
	public static function getInstance(): self
	{
		return new static();
	}

	/**
	 * Set selected items.
	 *
	 * @param array $selectedItems
	 * @return void
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
		$api = \App\Api::getInstance();
		$fields = $api->call('Products/Fields');
		$tree = [];
		foreach ($fields['fields'] as $val) {
			if ('pscategory' === $val['name']) {
				$tree = $val['treeValues'];
				break;
			}
		}
		return $tree;
	}

	/**
	 * Prepare tree data for jstree.
	 *
	 * @param mixed $cat
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
