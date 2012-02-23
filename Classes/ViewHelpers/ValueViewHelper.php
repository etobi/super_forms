<?php
class Tx_SuperForms_ViewHelpers_ValueViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param Tx_SuperForms_Domain_Model_Field_Base $field
	 * @param Tx_SuperForms_Domain_Model_Response $formResponse
	 * @param Tx_SuperForms_Validation_Result $validationResult
	 * @param string $trueIfEquals
	 * @return string
	 */
	public function render(Tx_SuperForms_Domain_Model_Field_Base $field, Tx_SuperForms_Domain_Model_Response $formResponse, Tx_SuperForms_Validation_Result $validationResult = NULL, $trueIfEquals = NULL) {
		$formResponseValues = $formResponse->getValues();
		$fieldValue = $field->getValue();
		if (!empty($formResponseValues[$field->getName()])) {
			$returnValue = $formResponseValues[$field->getName()];
		} elseif (!empty($fieldValue) && !$validationResult) {
			$returnValue = $fieldValue;
		} else {
			$returnValue = '';
		}
		if ($trueIfEquals !== NULL) {
			$returnValue = ($trueIfEquals == $returnValue);
		}
		return $returnValue;
	}
}
?>