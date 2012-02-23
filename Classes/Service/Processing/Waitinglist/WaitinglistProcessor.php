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
class Tx_SuperForms_Service_Processing_Waitinglist_WaitinglistProcessor extends Tx_SuperForms_Service_Processing_AbstractProcessor {

	/**
	 * @var int
	 */
	protected $maxNumberOfParticipants = 5;

	/**
	 * @var string
	 */
	protected $textParticipant;

	/**
	 * @var string
	 */
	protected $textWaitinglist;

	/**
	 * @var int
	 */
	protected $participantCount;

	/**
	 * @param Tx_SuperForms_Domain_Model_Response $formResponse
	 * @return void
	 */
	public function process(Tx_SuperForms_Domain_Model_Response $formResponse) {
		// noop
	}

	/**
	 * @return bool
	 */
	public function isOnWaitinglist() {
		return !$this->getHasFreePlaces();
	}

	/**
	 * @return string
	 */
	public function getText() {
		return $this->isOnWaitinglist() ? $this->textWaitinglist : $this->textParticipant;
	}

	/**
	 * @return void
	 */
	public function getParticipantCount() {
		if ($this->participantCount === NULL) {
			$databaseProcessor = $this->getForm()->getProcessorByType(Tx_SuperForms_Domain_Model_Processor::TYPE_DATABASE);
			$this->participantCount = $databaseProcessor->getService()->getRecordCount();
		}
		return $this->participantCount;
	}

	/**
	 * @return int
	 */
	public function getFreePlacesCount() {
		return $this->maxNumberOfParticipants - $this->getParticipantCount();
	}

	/**
	 * @return bool
	 */
	public function getHasFreePlaces() {
		return $this->getFreePlacesCount() > 0;
	}

	/**
	 * @return int
	 */
	public function getMaxNumberOfParticipants() {
		return $this->maxNumberOfParticipants;
	}

}

?>