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
class Tx_SuperForms_Service_Processing_Email_EmailProcessor extends Tx_SuperForms_Service_Processing_AbstractProcessor {

	/**
	 * @var Tx_BumMtBase_Service_MailService
	 */
	protected $mailService;

	/**
	 * @var string
	 */
	protected $recipient;

	/**
	 * @param Tx_SuperForms_Domain_Model_Response $formResponse
	 * @return void
	 */
	public function process(Tx_SuperForms_Domain_Model_Response $formResponse) {
		$this->mailService->sendTo($this->recipient,
			'EmailProcessor',
			array('form' => $this->form, 'response' => $formResponse)
		);
	}

	/**
	 * @FIXME to no depend on BumMtBase
	 *
	 * @param Tx_BumMtBase_Service_MailService $mailService
	 * @return void
	 */
	public function injectMailService(Tx_BumMtBase_Service_MailService $mailService) {
		$this->mailService = $mailService;
	}
}

?>