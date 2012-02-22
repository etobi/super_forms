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
	 * @param Tx_SuperForms_Domain_Model_Response $formResponse
	 * @return string
	 */
	public function renderAction(Tx_SuperForms_Domain_Model_Form $form, Tx_SuperForms_Domain_Model_Response $formResponse = NULL) {
		if (!$formResponse) {
			$this->forward('show');
		} else {
			$this->forward('process');
		}
	}

	/**
	 * @throws Exception
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @param Tx_SuperForms_Domain_Model_Response $formResponse
	 * @param Tx_SuperForms_Validation_Result $validationResult
	 * @return void
	 */
	public function showAction(Tx_SuperForms_Domain_Model_Form $form = NULL, Tx_SuperForms_Domain_Model_Response $formResponse = NULL, $validationResult = NULL) {
		if (empty($form)) {
			throw new Exception(
				'No Form given to display.',
				1328865915
			);
		}

		$this->view->assign('form', $form);
		$this->view->assign('formResponse', ($formResponse ?: $this->objectManager->create('Tx_SuperForms_Domain_Model_Response')));
		$this->view->assign('validationResult', $validationResult);
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @param array $formResponseArray
	 * @return void
	 */
	public function processAction(Tx_SuperForms_Domain_Model_Form $form, Tx_SuperForms_Domain_Model_Response $formResponse) {
		$validationResult = $form->validate($formResponse);

		if (!$validationResult->hasErrors()) {
			$form->process($formResponse);
				// @todo fix this to be redirect! (have to redirect to actual url!)
			$this->forward('confirm', NULL, NULL, array('form' => $form, 'formResponse' => $formResponse));
		} else {
				// TODO
			$this->forward('show', NULL, NULL, array('form' => $form, 'formResponse' => $formResponse, 'validationResult' => $validationResult));
		}
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @param null|Tx_SuperForms_Domain_Model_Response $formResponse
	 * @return void
	 */
	public function confirmAction(Tx_SuperForms_Domain_Model_Form $form, Tx_SuperForms_Domain_Model_Response $formResponse = NULL) {
		$this->view->assign('form', $form);
		$this->view->assign('formResponse', $formResponse);
	}
}
?>
