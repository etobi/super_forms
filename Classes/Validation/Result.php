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
class Tx_SuperForms_Validation_Result {

	/**
	 * @var array
	 */
	protected $errors;

	/**
	 * @param string $property
	 * @param string $message
	 * @param int $code
	 * @return void
	 */
	public function addError($fieldname, $message, $code) {
		$this->errors[] = array(
			'field' => $fieldname,
			'message' => $message,
			'code' => $code
		);
	}

	/**
	 * @param string $fieldname
	 * @param array $errors
	 * @return void
	 */
	public function addErrors($fieldname, $errors) {
		foreach ($errors as $error) {
			$this->addError($fieldname, $error['message'], $error['code']);
		}
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * @param string $fieldname
	 * @return array
	 */
	public function getErrorsForField($fieldname) {
		$errors = array();
		foreach($this->errors as $error) {
			if ($error['field'] == $fieldname) {
				$errors[] = $error;
			}
		}
		return $errors;
	}

	/**
	 * @return bool
	 */
	public function hasErrors() {
		return $this->errors !== NULL;
	}

	/**
	 * @param string $name
	 * @param array $arguments
	 * @return mixed|void
	 */
	public function __call($name, $arguments) {
		$fieldname = lcfirst(substr($name, 3));
		if (substr($name, 0, 3) === 'get') {
			return $this->getErrorsForField($fieldname);
		}
	}
}

?>