<?php
/**
 * Menu class
 * @package YetiForce.Config
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Core;
class Menu
{
	static private $icons = [
		'Potentials' => 'userIcon-opportunities',
		'Contacts' => 'userIcon-contacts',
		'Accounts' => 'userIcon-accounts',
		'Leads' => 'userIcon-leads',
		'Documents' => 'userIcon-documents',
		'Calendar' => 'userIcon-calendar',
		'Emails' => 'userIcon-my-mailbox',
		'HelpDesk' => 'userIcon-tickets',
		'Products' => 'userIcon-products',
		'Faq' => 'userIcon-faq',
		'Vendors' => 'userIcon-vendors',
		'PriceBooks' => 'userIcon-price-books',
		'Quotes' => 'userIcon-quotes',
		'PurchaseOrder' => 'userIcon-purchase-order',
		'SalesOrder' => 'userIcon-sales-order',
		'Invoice' => 'userIcon-invoices',
		'Campaigns' => 'userIcon-campaigns',
		'PBXManager' => '',
		'ServiceContracts' => 'userIcon-service-contracts',
		'Services' => 'userIcon-services',
		'Assets' => 'userIcon-assets',
		'ModComments' => '',
		'ProjectMilestone' => 'userIcon-project_milestones',
		'ProjectTask' => 'userIcon-project-task',
		'Project' => 'userIcon-projects2',
		'SMSNotifier' => 'userIcon-text-messages',
		'OSSPdf' => 'userIcon-pdf',
		'OSSMailTemplates' => 'userIcon-mail-templates',
		'OSSTimeControl' => 'userIcon-time-control',
		'OSSMailView' => 'userIcon-corporate-emails',
		'OSSOutsourcedServices' => 'userIcon-outsourced-services',
		'OSSSoldServices' => 'userIcon-sold-services',
		'OutsourcedProducts' => 'userIcon-outsourced-products',
		'OSSPasswords' => 'userIcon-user-access-control',
		'OSSEmployees' => 'userIcon-employees',
		'Calculations' => 'userIcon-calculations',
		'OSSCosts' => 'userIcon-costs',
		'CallHistory' => 'userIcon-call-history',
		'Ideas' => 'userIcon-ideas',
		'RequirementCards' => 'userIcon-requirement-cards',
		'QuotesEnquires' => 'userIcon-quotes-enquires',
		'HolidaysEntitlement' => 'userIcon-annual-holiday-entitlement',
		'PaymentsIn' => 'userIcon-payments-in',
		'PaymentsOut' => 'userIcon-payments-out',
		'LettersIn' => 'userIcon-letters-incoming',
		'LettersOut' => 'userIcon-letters-outgoing',
		'NewOrders' => 'userIcon-new-orders',
		'Reservations' => 'userIcon-reservations'
	];
	static public function getBreadcrumbs()
	{
		$breadcrumbs = false;
		$request = new Request($_REQUEST);
		$moduleName = $request->get('module');
		$view = $request->get('view');
		$breadcrumbs[] = [ 'name' => Language::translate($moduleName)];
		if ($view == 'EditView' && $request->get('record') == '') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_VIEW_CREATE', $moduleName)];
		} elseif ($view != '' && $view != 'index' && $view != 'Index') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_VIEW_' . strtoupper($view), $moduleName)];
		} elseif ($view == '') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_HOME', $moduleName)];
		}
		if ($request->get('record') != '') {
			$recordLabel = $request->get('record');
			if ($recordLabel != '') {
				$breadcrumbs[] = [ 'name' => $recordLabel];
			}
		}
		return $breadcrumbs;
	}
	static public function getIcon($moduleName)
	{ 
		return self::$icons[$moduleName];
	}
}
