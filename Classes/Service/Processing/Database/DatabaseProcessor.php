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
class Tx_SuperForms_Service_Processing_Database_DatabaseProcessor extends Tx_SuperForms_Service_Processing_AbstractProcessor {

	/**
	 * @var t3lib_DB
	 */
	protected $db;

	/**
	 * @var Tx_SuperForms_Service_Processing_Database_TableService
	 */
	protected $tableService;

	/**
	 * @return void
	 */
	public function initializeObject() {
		$this->db = $GLOBALS['TYPO3_DB'];
	}

	/**
	 * @param $configuration
	 * @return void
	 */
	public function setConfiguration($configuration) {
		// noop
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Response $formResponse
	 * @return void
	 */
	public function process(Tx_SuperForms_Domain_Model_Response $formResponse) {
		if (!$this->tableService->tableExists($this->form)) return;

		$tableName = $this->tableService->getTableNameForForm($this->form);
		$row = $this->buildRow($tableName, $formResponse);
		$this->db->exec_INSERTquery($tableName, $row);
	}

	/**
	 * @param array $formResponse
	 * @return array
	 */
	public function buildRow($tableName, Tx_SuperForms_Domain_Model_Response $formResponse) {
		$row = array();

		foreach($formResponse->toArray() as $field => $value) {
			if ($this->tableService->columnExists($tableName, $field)) {
				$columnName = $this->tableService->getColumnNameForField($field);
				$row[$columnName] = $value;
			}
		}
		$row = t3lib_div::array_merge_recursive_overrule(
			$row,
			array(
				'tstamp' => time(),
				'crdate' => time(),
			)
		);

		return $row;
	}

	public function getRecordCount() {
		$tableName = $this->tableService->getTableNameForForm($this->form);
		$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('count(*) as count', $tableName, 'deleted = 0');
		return intval($row[0]['count']);
	}

	/**
	 * @param Tx_SuperForms_Service_Processing_Database_TableService $tableService
	 * @return void
	 */
	public function injectTableService(Tx_SuperForms_Service_Processing_Database_TableService $tableService) {
		$this->tableService = $tableService;
	}
}

?>
