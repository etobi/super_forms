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
class Tx_SuperForms_Domain_Model_Response {
	/**
	 * @var Tx_SuperForms_Domain_Model_Form
	 */
	protected $form;

	/**
	 * @var array
	 */
	protected $values;

	/**
	 * @param \Tx_SuperForms_Domain_Model_Form $form
	 */
	public function setForm($form) {
		$this->form = $form;
		return $this;
	}

	/**
	 * @return \Tx_SuperForms_Domain_Model_Form
	 */
	public function getForm() {
		return $this->form;
	}

	/**
	 * @param array $values
	 */
	public function setValues($values) {
		foreach($this->form->getFields() as $field) {
			$fieldName = $field->getName();
			if ($fieldName) {
				$this->values[$fieldName] = $field->processValue($values[$fieldName]);
			}
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getValues() {
		return $this->values;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return $this->getValues();
	}

	/**
	 * @return array
	 */
	public function getPropertyKeys() {
		return array_keys($this->values);
	}

	/**
	 * @param $propertyName
	 * @return mixed
	 */
	public function get($propertyName) {
		return $this->values[$propertyName];
	}

	/**
	 * @param string $propertyName
	 * @param mixed $value
	 * @return void
	 */
	public function set($propertyName, $value) {
		$this->values[$propertyName] = $value;
	}

	/**
	 * @param string $name
	 * @param array $arguments
	 * @return mixed|void
	 */
	public function __call($name, $arguments) {
		$propertyName = lcfirst(substr($name, 3));
		if (substr($name, 0, 3) === 'get') {
			return $this->get($propertyName);
		}
		if (substr($name, 0, 3) === 'set') {
			$this->set($propertyName, $arguments[0]);
		}
	}

}

?>