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
class Tx_SuperForms_Domain_Model_Form extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SuperForms_Domain_Model_Field_Base>
	 */
	protected $fields;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SuperForms_Domain_Model_Processor>
	 */
	protected $processors;

	/**
	 * 
	 */
	public function __construct() {}

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SuperForms_Domain_Model_Field_Base> $fields
	 */
	public function setFields($fields) {
		$this->fields = $fields;
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SuperForms_Domain_Model_Field_Base>
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param \Tx_Extbase_Persistence_ObjectStorage $processors
	 */
	public function setProcessors($processors) {
		$this->processors = $processors;
	}

	/**
	 * @return \Tx_Extbase_Persistence_ObjectStorage
	 */
	public function getProcessors() {
		return $this->processors;
	}

	/**
	 * @param array $formResponse
	 * @return void
	 */
	public function process($formResponse) {
		foreach($this->getProcessors() as $processor) {
			$processorService = $processor->getService();
			if ($processorService instanceof Tx_SuperForms_Service_Processing_ProcessorInterface) {
				$processorService->process($formResponse);
			}
		}
	}
}
?>