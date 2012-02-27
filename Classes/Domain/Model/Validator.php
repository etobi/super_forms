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
class Tx_SuperForms_Domain_Model_Validator extends Tx_Extbase_DomainObject_AbstractEntity {

	const TYPE_NOTEMPTY = 'NotEmpty';
	const TYPE_EMAILADDRESS = 'EmailAddress';
	const TYPE_NUMBER = 'Number';
	const TYPE_NUMBERRANGE = 'NumberRange';
	const TYPE_STRINGLENGTH = 'StringLength';
	const TYPE_REGULAREXPRESSION = 'RegularExpression';
	const TYPE_UNIQUE = 'Unique';

	/**
	 * @var Tx_SuperForms_Service_Processing_Database_TableService
	 */
	protected $tableService;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var array
	 */
	protected $codeMap = array(
		self::TYPE_NOTEMPTY => 1329154912,
		self::TYPE_EMAILADDRESS => 1329154913,
		self::TYPE_NUMBER => 1329154914,
		self::TYPE_NUMBERRANGE => 1329154915,
		self::TYPE_STRINGLENGTH => 1329154916,
		self::TYPE_REGULAREXPRESSION => 1329154917,
		self::TYPE_UNIQUE => 1330347053,
	);

	/**
	 * @var string
	 */
	protected $configuration;

	/**
	 * @var string
	 */
	protected $configuration2;

	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var Tx_SuperForms_Domain_Model_Form
	 */
	protected $form;

	/**
	 * @var Tx_SuperForms_Domain_Model_Field_Base
	 */
	protected $field;

	/**
	 * @return void
	 */
	public function initializeObject() {
		$this->db = $GLOBALS['TYPO3_DB'];
	}

	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $configuration
	 */
	public function setConfiguration($configuration) {
		$this->configuration = $configuration;
	}

	/**
	 * @return string
	 */
	public function getConfiguration() {
		return $this->configuration;
	}

	/**
	 * @param string $configuration2
	 */
	public function setConfiguration2($configuration2) {
		$this->configuration2 = $configuration2;
	}

	/**
	 * @return string
	 */
	public function getConfiguration2() {
		return $this->configuration2;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	public function isValid($value) {
		switch ($this->getType()) {
			case self::TYPE_NOTEMPTY:
				return !empty($value);
			break;

			case self::TYPE_EMAILADDRESS:
				return t3lib_div::validEmail($value);
			break;

			case self::TYPE_NUMBER:
				return is_numeric($value);
			break;

			case self::TYPE_NUMBERRANGE:
				return is_numeric($value) &&
					intval($value) >= intval($this->configuration) &&
					intval($value) <= intval($this->configuration2);
			break;

			case self::TYPE_STRINGLENGTH:
				return strlen($value) >= intval($this->configuration) &&
					strlen($value) <= intval($this->configuration2);
			break;

			case self::TYPE_REGULAREXPRESSION:
				return preg_match($this->configuration, $value) > 0;
			break;

			case self::TYPE_UNIQUE:
				return ($this->db->sql_num_rows(
					$this->db->exec_SELECTquery(
						$this->tableService->getColumnNameForField($this->field),
						$this->tableService->getTableNameForForm($this->form),
						$this->tableService->getColumnNameForField($this->field)
							. ' = '
							. $this->db->fullQuoteStr(
								$value,
								$this->tableService->getTableNameForForm($this->form)
							)
					)
				) === 0);
			break;
		}
		return FALSE;
	}

	/**
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return int
	 */
	public function getCode() {
		return $this->codeMap[$this->getType()];
	}

	/**
	 * @param Tx_SuperForms_Service_Processing_Database_TableService $tableService
	 * @return void
	 */
	public function injectTableService(Tx_SuperForms_Service_Processing_Database_TableService $tableService) {
		$this->tableService = $tableService;
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @return Tx_SuperForms_Domain_Model_Validator
	 */
	public function setForm(Tx_SuperForms_Domain_Model_Form $form) {
		$this->form = $form;
		return $this;
	}

	/**
	 * @var Tx_SuperForms_Domain_Model_Field_Base $field
	 * @return Tx_SuperForms_Domain_Model_Validator
	 */
	public function setField($field) {
		$this->field = $field;
		return $this;
	}
}
?>