<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

$tempShowItems = array(
	'general' => 'type, label',
	'validators' => '--div--;LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_field.validators, validation_depends_on_field, validators'
);
$tempLLL = 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_field';

$TCA['tx_superforms_domain_model_field'] = array(
	'ctrl' => $TCA['tx_superforms_domain_model_field']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => '',
	),
	'types' => array(
		'Tx_SuperForms_Domain_Model_Field_Base'         => array('showitem' => 'type'),
		'Tx_SuperForms_Domain_Model_Field_Textfield'    => array('showitem' => $tempShowItems['general'] . ', name, value, configuration, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_Textarea'     => array('showitem' => $tempShowItems['general'] . ', name, configuration, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_Radio'        => array('showitem' => $tempShowItems['general'] . ', name, configuration, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_Checkbox'     => array('showitem' => $tempShowItems['general'] . ', name, configuration, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_Select'       => array('showitem' => $tempShowItems['general'] . ', name, configuration, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_SubmitButton' => array('showitem' => $tempShowItems['general'] . ', name, value'),
		'Tx_SuperForms_Domain_Model_Field_Textblock'    => array('showitem' => $tempShowItems['general'] . ', configuration'),
		'Tx_SuperForms_Domain_Model_Field_Separator'    => array('showitem' => 'type'),
		'Tx_SuperForms_Domain_Model_Field_Hidden'       => array('showitem' => 'type, name, value'),
		'Tx_SuperForms_Domain_Model_Field_Autofill'     => array('showitem' => 'type, name, configuration, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_WaitinglistCounter'  => array('showitem' => 'type'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_superforms_domain_model_field',
				'foreign_table_where' => 'AND tx_superforms_domain_model_field.pid=###CURRENT_PID### AND tx_superforms_domain_model_field.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'type' => array(
			'exclude' => 1,
			'l10n_mode' => 'exclude',
			'label' => '' . $tempLLL . '.type',
			'config' => array(
				'type' => 'select',
				'size' => 1,
				'maxitems' => 1,
				'items' => array(
					array('-',  'Tx_SuperForms_Domain_Model_Field_Base'),
					array('Textfield', 'Tx_SuperForms_Domain_Model_Field_Textfield'),
					array('Textarea', 'Tx_SuperForms_Domain_Model_Field_Textarea'),
					array('Radio', 'Tx_SuperForms_Domain_Model_Field_Radio'),
					array('Checkbox', 'Tx_SuperForms_Domain_Model_Field_Checkbox'),
					array('Select', 'Tx_SuperForms_Domain_Model_Field_Select'),
					array('Submit button', 'Tx_SuperForms_Domain_Model_Field_SubmitButton'),
					array('Text only', 'Tx_SuperForms_Domain_Model_Field_Textblock'),
					array('Separator', 'Tx_SuperForms_Domain_Model_Field_Separator'),
					array('Hidden', 'Tx_SuperForms_Domain_Model_Field_Hidden'),
					array('Autofill', 'Tx_SuperForms_Domain_Model_Field_Autofill'),
					array('Waitinglist counter', 'Tx_SuperForms_Domain_Model_Field_WaitinglistCounter'),
				),
				'default' => 'Tx_SuperForms_Domain_Model_Field_Base'
			)
		),
		'label' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => '' . $tempLLL . '.label',
			'config' => array(
				'type' => 'input',
			)
		),
		'name' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => '' . $tempLLL . '.name',
			'config' => array(
				'type' => 'input',
				'eval' => 'required,alphanum'
			)
		),
		'value' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => '' . $tempLLL . '.value',
			'config' => array(
				'type' => 'input',
			)
		),
		'configuration' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => $tempLLL . '.configuration',
			'config' => array(
				'type' => 'flex',
				'ds_pointerField' => 'type',
				'ds' => array(
					'Tx_SuperForms_Domain_Model_Field_Textfield' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Textfield.xml',
					'Tx_SuperForms_Domain_Model_Field_Textarea' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Textarea.xml',
					'Tx_SuperForms_Domain_Model_Field_Radio' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Radio.xml',
					'Tx_SuperForms_Domain_Model_Field_Checkbox' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Checkbox.xml',
					'Tx_SuperForms_Domain_Model_Field_Select' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Select.xml',
					'Tx_SuperForms_Domain_Model_Field_SubmitButton' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/SubmitButton.xml',
					'Tx_SuperForms_Domain_Model_Field_Textblock' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Textblock.xml',
					'Tx_SuperForms_Domain_Model_Field_Separator' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Separator.xml',
					'Tx_SuperForms_Domain_Model_Field_Hidden' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Hidden.xml',
					'Tx_SuperForms_Domain_Model_Field_Autofill' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/Autofill.xml',
					'Tx_SuperForms_Domain_Model_Field_WaitinglistCounter' => 'FILE:EXT:super_forms/Configuration/FlexForms/Field/WaitinglistCounter.xml',
				)
			)
		),

		'form' => array(
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_superforms_domain_model_form',
			),
		),
		'sorting' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'validators' => array(
			'exclude' => 0,
			'label' => '' . $tempLLL . '.validators',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_superforms_domain_model_validator',
				'foreign_field' => 'field',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			)
		),
		'validation_depends_on_field' => array(
			'exclude' => 0,
			'label' => '' . $tempLLL . '.validation_depends_on_field',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('(none)',  '0'),
				),
				'foreign_table' => 'tx_superforms_domain_model_field',
				'foreign_table_where' => 'AND tx_superforms_domain_model_field.uid != ###REC_FIELD_uid### ' .
						' AND tx_superforms_domain_model_field.form = ###REC_FIELD_form### ' .
						' AND tx_superforms_domain_model_field.type = \'Tx_SuperForms_Domain_Model_Field_Checkbox\'',
			)
		)
	),
);
?>