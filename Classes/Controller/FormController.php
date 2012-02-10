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
	public function indexAction() {
		$this->view->assign('forms', $this->formRepository->findAll());
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @return void
	 */
	public function showAction(Tx_SuperForms_Domain_Model_Form $form = NULL) {
		if (!empty($form)) {
			$formToDisplay = $form;
		} elseif (!empty($this->settings['form'])) {
			$formToDisplay = $this->objectManager
				->get('Tx_SuperForms_Domain_Repository_FormRepository')
					->findByUid((integer)$this->settings['form']);
		} else {
			throw new Exception(
				'No Form given to display.',
				1328865915
			);
		}

		$this->view->assign('form', $formToDisplay);
	}
}
?>
