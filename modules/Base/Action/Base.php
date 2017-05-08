<?php
/**
 * Abstract Action Controller Class
 * @package YetiForce.Actions
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Modules\Base\Action;

use YF\Core;

abstract class Base extends \YF\Core\Controller
{

	public function getViewer(\YF\Core\Request $request)
	{
		throw new \YF\Core\AppException('Action - implement getViewer - JSONViewer');
	}

	public function validateRequest(\YF\Core\Request $request)
	{
		return $request->validateReadAccess();
	}

	public function preProcess(\YF\Core\Request $request)
	{
		return true;
	}

	public function postProcess(\YF\Core\Request $request)
	{
		return true;
	}

	public function checkPermission()
	{
		return true;
	}
}
