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
abstract class Tx_SuperForms_Service_Processing_AbstractProcessor implements Tx_SuperForms_Service_Processing_ProcessorInterface {

	/**
	 * @var \Tx_SuperForms_Domain_Model_Form
	 */
	protected $form;

	/**
	 * @var Tx_Extbase_Service_FlexFormService
	 */
	protected $flexformService;

	/**
	 * @param \Tx_SuperForms_Domain_Model_Form $form
	 */
	public function setForm(Tx_SuperForms_Domain_Model_Form $form) {
		$this->form = $form;
	}

	/**
	 * @param string $configuration
	 * @return void
	 */
	public function setConfiguration($configuration) {
		if (!empty($configuration)) {
			$flexFormValues = $this->flexformService->convertFlexFormContentToArray($configuration);
			foreach($flexFormValues['settings'] as $key => $value) {
				if (property_exists($this, $key)) {
					$this->$key = $value;
				}
			}
		}
	}

	/**
	 * @return \Tx_SuperForms_Domain_Model_Form
	 */
	public function getForm() {
		return $this->form;
	}

	/**
	 * @return void
	 */
	public function getText() {
		return NULL;
	}

	/**
	 * @param Tx_Extbase_Service_FlexFormService $flexformService
	 * @return void
	 */
	public function injectFlexFormService(Tx_Extbase_Service_FlexFormService $flexformService) {
		$this->flexformService = $flexformService;
	}
}

?>