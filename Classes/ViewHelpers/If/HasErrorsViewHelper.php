<?php
class Tx_SuperForms_ViewHelpers_If_HasErrorsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param Tx_SuperForms_Domain_Model_Field_Base $field
	 * @param Tx_SuperForms_Validation_Result $validationResult
	 * @return string
	 */
	public function render(Tx_SuperForms_Domain_Model_Field_Base $field, Tx_SuperForms_Validation_Result $validationResult = NULL) {
		if ($validationResult && $validationResult->hasErrors()) {
			$errors = $validationResult->getErrorsForField($field->getName());

			if (!empty($errors)) {
				return $this->renderChildren();
			}
		}
	}
}
?>