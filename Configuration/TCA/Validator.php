<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_superforms_domain_model_validator'] = array(
	'ctrl' => $TCA['tx_superforms_domain_model_validator']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => '',
	),
	'types' => array(
		'NotEmpty' => array('showitem' => 'type'),
		'EmailAddress' => array('showitem' => 'type'),
		'Number' => array('showitem' => 'type'),
		'NumberRange' => array('showitem' => 'type, configuration, configuration2'),
		'StringLength' => array('showitem' => 'type, configuration, configuration2'),
		'RegularExpression' => array('showitem' => 'type, configuration'),
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
				'foreign_table' => 'tx_superforms_domain_model_validator',
				'foreign_table_where' => 'AND tx_superforms_domain_model_validator.pid=###CURRENT_PID### AND tx_superforms_domain_model_validator.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_validator.type',
			'config' => array(
				'type' => 'select',
				'size' => 1,
				'maxitems' => 1,
				'items' => array(
					array('Not empty', 'NotEmpty'),
					array('EmailAddress', 'EmailAddress'),
					array('Number', 'Number'),
					array('NumberRange', 'NumberRange'),
					array('StringLength', 'StringLength'),
					array('RegularExpression', 'RegularExpression'),
				),
				'default' => 'NotEmpty'
			)
		),
		'configuration' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_validator.configuration',
			'config' => array(
				'type' => 'input',
				'size' => '10'
			)
		),
		'configuration2' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_validator.configuration2',
			'config' => array(
				'type' => 'input',
				'size' => '10'
			)
		),
		'field' => array(
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_superforms_domain_model_field',
				'foreign_field' => 'validators'
			),
		),
	),
);
?>