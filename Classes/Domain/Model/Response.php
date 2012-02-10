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
	protected $responseArray;

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
	 * @param array $responseArray
	 */
	public function setResponseArray($responseArray) {
		$this->responseArray = $responseArray;
		unset($this->responseArray['__referrer']);
		unset($this->responseArray['__hmac']);
		foreach($this->form->getFields() as $field) {
			$fieldName = $field->getName();
			$value = $this->responseArray[$fieldName];
			$value = $field->processValue($value);
			$this->responseArray[$fieldName] = $value;
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getResponseArray() {
		return $this->responseArray;
	}

	public function toArray() {
		return $this->getResponseArray();
	}
	
	// TODO magic __call getFoobar
	// TODO magic __call setFoobar
	// TODO getProperties
}

?>