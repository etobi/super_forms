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
		'Tx_SuperForms_Domain_Model_Field_Textfield'    => array('showitem' => $tempShowItems['general'] . ', name, value, size, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_Textarea'     => array('showitem' => $tempShowItems['general'] . ', name, configuration;' . $tempLLL . '.value, size;' . $tempLLL . '.size_cols, size2, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_Radio'        => array('showitem' => $tempShowItems['general'] . ', name, configuration;' . $tempLLL . '.options, size, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_Checkbox'     => array('showitem' => $tempShowItems['general'] . ', name, configuration;' . $tempLLL . '.options, size, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_Select'       => array('showitem' => $tempShowItems['general'] . ', name, configuration;' . $tempLLL . '.options, ' . $tempShowItems['validators']),
		'Tx_SuperForms_Domain_Model_Field_SubmitButton' => array('showitem' => $tempShowItems['general'] . ', value'),
		'Tx_SuperForms_Domain_Model_Field_Textblock'    => array('showitem' => $tempShowItems['general'] . ', configuration;' . $tempLLL . '.value'),
		'Tx_SuperForms_Domain_Model_Field_Hidden'       => array('showitem' => $tempShowItems['general'] . ', name, configuration;' . $tempLLL . '.value'),
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
					array('Hidden', 'Tx_SuperForms_Domain_Model_Field_Hidden'),
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
			'label' => '' . $tempLLL . '.configuration',
			'config' => array(
				'type' => 'text',
				'rows' => 5,
			)
		),
		'size' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => '' . $tempLLL . '.size',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
				'size' => 5,
				'default' => 30,
			)
		),
		'size2' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => '' . $tempLLL . '.size2',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
				'size' => 5,
				'default' => 7,
			)
		),
		'form' => array(
			'config' => array(
				'type' => 'passthrough',
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
				'foreign_table_where' => 'AND tx_superforms_domain_model_field.uid != ###REC_FIELD_uid### AND tx_superforms_domain_model_field.form = ###REC_FIELD_form###',
			)
		)
	),
);
?>