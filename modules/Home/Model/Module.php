<?php
/**
 * Home module model class.
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Home\Model;

class Module extends \YF\Modules\Base\Model\Module
{
	/** {@inheritdoc} */
	protected $defaultView = 'Dashboard';
}
