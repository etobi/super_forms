<?php
class Tx_SuperForms_ViewHelpers_ErrorsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param Tx_SuperForms_Domain_Model_Field_Base $field
	 * @param Tx_SuperForms_Validation_Result $validationResult
	 * @param string $as
	 * @return string
	 */
	public function render(Tx_SuperForms_Domain_Model_Field_Base $field, Tx_SuperForms_Validation_Result $validationResult = NULL, $as = 'error') {
		if ($validationResult->hasErrors()) {
			$errors = $validationResult->getErrorsForField($field->getName());

			if (!empty($errors)) {
				foreach ($errors as $error) {
					$output .= self::renderStatic($error['message'], $as, $this->buildRenderChildrenClosure(), $this->renderingContext);
				}

				return $output;
			}
		}
	}

	/**
	 * @param string $error
	 * @param Closure $renderChildrenClosure
	 * @param Tx_Fluid_Core_Rendering_RenderingContextInterface $renderingContext
	 * @return string
	 */
	static public function renderStatic($error, $as = 'error', Closure $renderChildrenClosure, Tx_Fluid_Core_Rendering_RenderingContextInterface $renderingContext) {
		$templateVariableContainer = $renderingContext->getTemplateVariableContainer();

		$templateVariableContainer->add($as, $error);
		$output = $renderChildrenClosure();
		$templateVariableContainer->remove($as);

		return $output;
	}
}
?>