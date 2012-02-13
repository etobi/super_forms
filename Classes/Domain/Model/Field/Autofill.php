<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Tobias Liebig <work@etobi.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @package super_forms
 */
class Tx_SuperForms_Domain_Model_Field_Autofill extends Tx_SuperForms_Domain_Model_Field_Base {

	/**
	 * @param mixed $value
	 * @return int|string
	 */
	public function processValue($value) {
		switch ($this->getMode()) {
			case 'date_dmY':
				return date('d.m.Y');
				break;
			case 'date_HHMMii':
				return date('H:M:i');
				break;
			case 'fe_user':
				return intval($GLOBALS['TSFE']->fe_user->user['uid']);
				break;
			case 'page':
				return intval($GLOBALS['TSFE']->id);
				break;
			case 'remoteIp':
				return $_SERVER['REMOTE_ADDR'];
				break;
			case 'waiting':
				return $this->isOnWaitinglist() ? 1 : 0;
				break;
		}
		return '';
	}

	/**
	 * @var Tx_SuperForms_Service_Processing_Database_TableService
	 */
	protected $_tableService;

	/**
	 * @return bool
	 */
	protected function isOnWaitinglist() {
		$waitinglistProcessor = $this->getForm()->getProcessorByType(Tx_SuperForms_Domain_Model_Processor::TYPE_WAITINGLIST);
		return $waitinglistProcessor ? $waitinglistProcessor->getService()->isOnWaitinglist() : FALSE;
	}

	/**
	 * @return string
	 */
	public function getMode() {
		return $this->getSetting('mode');
	}

	/**
	 * @static
	 * @return array
	 */
	public static function getModeOptions() {
		return array(
			array('Date', 'date_dmY'),
			array('Time', 'date_HHMMii'),
			array('Current FEUser', 'fe_user'),
			array('Current Page UID', 'page'),
			array('IP Address', 'remoteIp'),
			array('Participant/Waiting list (needs WaitingList and Database Processor)', 'waiting'),
		);
	}

	/**
	 * @param Tx_SuperForms_Service_Processing_Database_TableService $tableService
	 * @return void
	 */
	public function injectTableService(Tx_SuperForms_Service_Processing_Database_TableService $tableService) {
		$this->_tableService = $tableService;
	}
}

?>