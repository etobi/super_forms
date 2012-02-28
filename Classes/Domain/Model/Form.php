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
	 * @var string
	 */
	protected $textConfirm;

	/**
	 * @var DateTime
	 */
	protected $startTime;

	/**
	 * @var DateTime
	 */
	protected $endTime;

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
		foreach($this->processors as $processor) {
			// TODO FIXME der Processor bekommt das form property nicht gemappt. Keine Ahnung wieso :-/
			$processor->setForm($this);
		}
		return $this->processors;
	}

	/**
	 * @param string $type
	 * @return Tx_SuperForms_Domain_Model_Processor
	 */
	public function getProcessorByType($type) {
		foreach ($this->getProcessors() as $processor) {
			if ($processor->getType() === $type) {
				return $processor;
			}
		}
		return NULL;
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Response $formResponse
	 * @return void
	 */
	public function process(Tx_SuperForms_Domain_Model_Response $formResponse) {
		foreach($this->getProcessors() as $processor) {
			$processor->process($formResponse);
		}
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Response $formResponse
	 * @return Tx_SuperForms_Validation_Result
	 */
	public function validate(Tx_SuperForms_Domain_Model_Response $formResponse) {
		$validationResult = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->create('Tx_SuperForms_Validation_Result');
		/** @var $validationResult Tx_SuperForms_Validation_Result */

		/** @var $processor Tx_SuperForms_Domain_Model_Processor */
		foreach($this->getProcessors() as $processor) {
			/** @var $processorValidationResults Tx_SuperForms_Domain_Model_Field_Base */
			$processorValidationResults = $processor->validate($formResponse);
			if ($processorValidationResults->hasErrors()) {
				$validationResult->addErrors(
					'_processor' . $processor->getShortType(),
					$processorValidationResults->getErrors()
				);
			}
		}

		/** @var $field Tx_SuperForms_Domain_Model_Field_Base */
		foreach($this->getFields() as $field) {
			/** @var $fieldValidationResults Tx_SuperForms_Domain_Model_Field_Base */
			$fieldValidationResults = $field->validate($formResponse);
			if ($fieldValidationResults->hasErrors()) {
				$validationResult->addErrors(
					$field->getName(),
					$fieldValidationResults->getErrors()
				);
			}
		}
		return $validationResult;
	}

	/**
	 * processes the form on the fly
	 * is meant to be used inside other extensions
	 *
	 * @return string
	 * @FIXME hand over form object!
	 */
	public function getToHtml() { //__toString() {
		$_GET['tx_superforms_render']['form'] = $this->getUid();
		return t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')
			->create('Tx_Extbase_Core_Bootstrap')
				->run('', array(
					'extensionName' => 'SuperForms',
					'pluginName' => 'Render'
				));
	}

	/**
	 * @param string $textConfirm
	 */
	public function setTextConfirm($textConfirm) {
		$this->textConfirm = $textConfirm;
	}

	/**
	 * @return string
	 */
	public function getTextConfirm() {
		return $this->textConfirm;
	}

	/**
	 * @return null|Tx_SuperForms_Service_Processing_Waitinglist_WaitinglistProcessor
	 */
	public function getWaitinglist() {
		$processor = $this->getProcessorByType(Tx_SuperForms_Domain_Model_Processor::TYPE_WAITINGLIST);
		return $processor ? $processor->getService() : NULL;
	}

	/**
	 * @return null|Tx_SuperForms_Domain_Model_Field_Autofill
	 */
	public function getWaitinglistFlagField() {
		$waitinglistFlagField = NULL;
		$waitinglist = $this->getWaitinglist();
		foreach ($this->getFields() as $field) {
			/** @var $field Tx_SuperForms_Domain_Model_Field_Base */
			if ($field->getType() === Tx_SuperForms_Domain_Model_Field_Base::TYPE_AUTOFILL
					&& $field->getMode() === 'waiting') {
				$waitinglistFlagField = $field;
			}
		}
		return $waitinglistFlagField;
	}

	/**
	 * @param DateTime $startTime
	 * @return Tx_SuperForms_Domain_Model_Form this
	 */
	public function setStartTime($startTime) {
		$this->startTime = $startTime;
		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getStartTime() {
		return $this->startTime;
	}

	/**
	 * @param DateTime $endTime
	 * @return Tx_SuperForms_Domain_Model_Form this
	 */
	public function setEndTime($endTime) {
		$this->endTime = $endTime;
		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getEndTime() {
		return $this->endTime;
	}

	/**
	 * @return boolean
	 */
	public function getIsActive() {
		return (!$this->getIsNotStarted() && !$this->getIsEnded());
	}

	/**
	 * @return boolean
	 */
	public function getIsNotStarted() {
		return ($this->getStartTime() && $this->getStartTime() > new DateTime());
	}

	/**
	 * @return boolean
	 */
	public function getIsEnded() {
		return (!$this->getEndTime() || ($this->getEndTime() < new DateTime()));
	}

	/**
	 * @return bool
	 */
	public function getCanSubscribe() {
		$waitinglist = $this->getWaitinglist();
		if ($waitinglist) {
			return $waitinglist->getCanSubscribe();
		} else {
			return TRUE;
		}
	}
}
?>
