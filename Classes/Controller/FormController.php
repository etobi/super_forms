<?php
/*                                                                        *
 * This script belongs to the SuperForms extension.                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @access public
 * @package SuperForms
 * @subpackage Controller
 * @author Felix Oertel, <f@oer.tel>
 */
class Tx_SuperForms_Controller_FormController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_SuperForms_Domain_Repository_FormRepository
	 */
	protected $formRepository;

	/**
	 * @param Tx_SuperForms_Domain_Repository_FormRepository $formRepository
	 */
	public function injectFormRepository(Tx_SuperForms_Domain_Repository_FormRepository $formRepository) {
		$this->formRepository = $formRepository;
	}

	/**
	 * @return void
	 */
	public function devAction() {
		$this->view->assign('form', $this->formRepository->findByUid($this->settings['form']));
	}

	/**
	 * @return void
	 */
	public function displayAction() {
		$this->view->assign('form', $this->formRepository->findByUid($this->settings['form']));
	}

	/**
	 * handles standalone rendering and dispatches processing
	 *
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @param array $formResponseArray
	 * @return string
	 */
	public function renderAction(Tx_SuperForms_Domain_Model_Form $form, $formResponseArray = NULL) {
		if (!$formResponseArray) {
			$this->forward('show');
		} else {
			$this->forward('process');
		}
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @return void
	 */
	public function showAction(Tx_SuperForms_Domain_Model_Form $form = NULL) {
		if (empty($form)) {
			throw new Exception(
				'No Form given to display.',
				1328865915
			);
		}

		$this->view->assign('form', $form);
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @param array $formResponseArray
	 * @return void
	 */
	public function processAction(Tx_SuperForms_Domain_Model_Form $form, $formResponseArray) {
		$formResponse = $this->objectManager
				->create('Tx_SuperForms_Domain_Model_Response')
				->setForm($form)
				->setValues($formResponseArray);
		$form->process($formResponse);
			// @todo fix this to be redirect! (have to redirect to actual url!)
		$this->forward('confirm');
	}

	/**
	 * @return string
	 */
	public function confirmAction() {
	}
}
?>
