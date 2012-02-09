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
class Tx_SuperForms_Hook_TceMainHook {

	/**
	 * @var t3lib_DB
	 */
	protected $db;

	/**
	 * @var t3lib_pageSelect
	 */
	protected $pageSelect;

	/**
	 * Construct the hook
	 */
	public function __construct() {
		$this->db = $GLOBALS['TYPO3_DB'];
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$this->pageSelect = $this->objectManager->get('t3lib_pageSelect');
	}

	/**
	 * @param string $status Status of the current operation, 'new' or 'update
	 * @param string $table The table currently processing data for
	 * @param string $id The record uid currently processing data for, [integer] or [string] (like 'NEW...')
	 * @param array $fieldArray The field array of a record
	 * @param t3lib_TCEmain $tce
	 * @return void
	 */
	public function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, $tce) {
		if ($table === 'tx_superforms_domain_model_form'
				&& ($status === 'new' || $status === 'update')) {
			if ($status == 'new') {
				$id = $tce->substNEWwithIDs[$id];
			}
			$tableService = $this->objectManager->get('Tx_SuperForms_Service_Processing_Database_TableService');
			$tableService->process($id);
		}
	}
}

?>