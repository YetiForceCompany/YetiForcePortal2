<?php
/**
 * User Action Login Class
 * @package YetiForce.Actions
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Modules\Install\Action;

use Install\Model,
	YF\Modules\Base\Action,
	YF\Core;

class Install extends Action\Base
{

	public function loginRequired()
	{
		return false;
	}

	public function process(\YF\Core\Request $request)
	{
		$install = Model\Install::getInstance($request->getModule());
		$install->save($request);
	}
}
