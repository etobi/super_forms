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
class Tx_SuperForms_Domain_Model_Field_Base extends Tx_Extbase_DomainObject_AbstractEntity implements Tx_SuperForms_Domain_Model_Field_FieldInterface {

	const TYPE_BASE = 'Tx_SuperForms_Domain_Model_Field_Base';
	const TYPE_TEXTFIELD = 'Tx_SuperForms_Domain_Model_Field_Textfield';
	const TYPE_TEXTAREA = 'Tx_SuperForms_Domain_Model_Field_Textarea';
	const TYPE_RADIO = 'Tx_SuperForms_Domain_Model_Field_Radio';
	const TYPE_CHECKBOX = 'Tx_SuperForms_Domain_Model_Field_Checkbox';
	const TYPE_SELECT = 'Tx_SuperForms_Domain_Model_Field_Select';
	const TYPE_SUBMITBUTTON = 'Tx_SuperForms_Domain_Model_Field_SubmitButton';
	const TYPE_TEXTBLOCK = 'Tx_SuperForms_Domain_Model_Field_Textblock';
	const TYPE_HIDDEN = 'Tx_SuperForms_Domain_Model_Field_Hidden';

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $options;

	/**
	 * @var string
	 */
	protected $value;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SuperForms_Domain_Model_Validator>
	 */
	protected $validators;

	/**
	 * @var Tx_SuperForms_Domain_Model_Field_Base
	 */
	protected $validationDependsOnField;

	/**
	 *
	 */
	public function __construct() {}

	/**
	 * @param string $fieldName
	 */
	public function setName($fieldName) {
		$this->name = $fieldName;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $fieldType
	 */
	public function setType($fieldType) {
		$this->type = $fieldType;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param string $options
	 */
	public function setOptions($options) {
		$this->options = $options;
	}

	/**
	 * @return string
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param \Tx_Extbase_Persistence_ObjectStorage<Tx_SuperForms_Domain_Model_Validator> $validators
	 */
	public function setValidators($validators) {
		$this->validators = $validators;
	}

	/**
	 * @return \Tx_Extbase_Persistence_ObjectStorage<Tx_SuperForms_Domain_Model_Validator>
	 */
	public function getValidators() {
		return $this->validators;
	}

	/**
	 * @param \Tx_SuperForms_Domain_Model_Field_Base $validationDependsOnField
	 */
	public function setValidationDependsOnField($validationDependsOnField) {
		$this->validationDependsOnField = $validationDependsOnField;
	}

	/**
	 * @return \Tx_SuperForms_Domain_Model_Field_Base
	 */
	public function getValidationDependsOnField() {
		return $this->validationDependsOnField;
	}

	/**
	 * @return string
	 */
	public function getShortType() {
		return array_pop(explode('_', $this->getType()));
	}

	/**
	 * @return boolean
	 */
	public function getHasMultipleOptions() {
		return (count(explode(PHP_EOL, $this->options)) > 1);
	}

	/**
	 * returns the options parsed and prepared as an object
	 *
	 * @return array
	 */
	public function getSplittedOptions() {
		if (empty($this->options)) {
			return array();
		}

		$options = array();
		foreach (explode(PHP_EOL, $this->options) as $option) {
			$options[] = $this->getSplittedOption($option);
		}

		return $options;
	}

	/**
	 * splits an option string into parameters for select, radio and checkbox
	 *
	 * @param string $optionString if nothing specified, $this->options is used
	 * @return array
	 */
	public function getSplittedOption($optionString = '') {
		if (empty($optionString)) {
			$optionString = $this->options;
		}

		$selected = FALSE;

		if (substr($optionString, 0, 1) === '*') {
			$selected = TRUE;
			$optionString = substr($optionString, 1);
		}

		list($value, $label) = explode(':', $optionString);
		return array('value' => $value, 'label' => $label, 'selected' => $selected);
	}
}
?>
