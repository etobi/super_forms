<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_superforms_domain_model_processor'] = array(
	'ctrl' => $TCA['tx_superforms_domain_model_processor']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => '',
	),
	'types' => array(
		'0' => array('showitem' => 'type, title'),
		'Tx_SuperForms_Domain_Model_Processor_Email' => array('showitem' => 'type, title, configuration'),
		'Tx_SuperForms_Domain_Model_Processor_Database' => array('showitem' => 'type, title'),
		'Tx_SuperForms_Domain_Model_Processor_File' => array('showitem' => 'type, title, configuration'),
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
				'foreign_table' => 'tx_superforms_domain_model_processor',
				'foreign_table_where' => 'AND tx_superforms_domain_model_processor.pid=###CURRENT_PID### AND tx_superforms_domain_model_processor.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_processor.type',
			'config' => array(
				'type' => 'select',
				'size' => 1,
				'maxitems' => 1,
				'items' => array(
					array('-',  '0'),
					array('Email', 'Tx_SuperForms_Domain_Model_Processor_Email'),
					array('Database', 'Tx_SuperForms_Domain_Model_Processor_Database'),
					array('File', 'Tx_SuperForms_Domain_Model_Processor_File'),
				),
				'default' => '0'
			)
		),
		'title' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_processor.title',
			'config' => array(
				'type' => 'input',
			)
		),
		'configuration' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_processor.configuration',
			'config' => array(
				'type' => 'text',
				'rows' => 5,
			)
		),
		'form' => array(
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_superforms_domain_model_form',
				'foreign_field' => 'processors'
			),
		),
	),
);
?>