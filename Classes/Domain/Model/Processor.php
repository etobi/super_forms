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
class Tx_SuperForms_Domain_Model_Processor extends Tx_Extbase_DomainObject_AbstractEntity {

	const TYPE_EMAIL = 'Tx_SuperForms_Domain_Model_Processor_Email';
	const TYPE_DATABASE = 'Tx_SuperForms_Domain_Model_Processor_Database';
	const TYPE_WAITINGLIST = 'Tx_SuperForms_Domain_Model_Processor_Waitinglist';

	protected $_serviceMap = array(
		self::TYPE_EMAIL => 'Tx_SuperForms_Service_Processing_Email_EmailProcessor',
		self::TYPE_DATABASE => 'Tx_SuperForms_Service_Processing_Database_DatabaseProcessor',
		self::TYPE_WAITINGLIST => 'Tx_SuperForms_Service_Processing_Waitinglist_WaitinglistProcessor',
	);

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $configuration;

	/**
	 * @var Tx_SuperForms_Domain_Model_Form
	 */
	protected $form;

	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $_objectManager;

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
	 * @return Tx_SuperForms_Service_Processing_ProcessorInterface
	 */
	public function getService() {
		if ($this->_serviceMap[$this->getType()]) {
			$service = $this->_objectManager->create($this->_serviceMap[$this->getType()]);
			$service->setForm($this->getForm());
			$service->setConfiguration($this->getConfiguration());
			return $service;
		} else {
			return NULL;
		}
	}

	/**
	 * @param \Tx_SuperForms_Domain_Model_Form $form
	 */
	public function setForm(Tx_SuperForms_Domain_Model_Form $form) {
		$this->form = $form;
	}

	/**
	 * @return \Tx_SuperForms_Domain_Model_Form
	 */
	public function getForm() {
		return $this->form;
	}

	/**
	 * @param $formResponse
	 * @return void
	 */
	public function process($formResponse) {
		$processorService = $this->getService();
		if ($processorService instanceof Tx_SuperForms_Service_Processing_ProcessorInterface) {
			$processorService->process($formResponse);
		}
	}

	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 * @return void
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->_objectManager = $objectManager;
	}

}
?>