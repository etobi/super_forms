<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_superforms_domain_model_form'] = array(
	'ctrl' => $TCA['tx_superforms_domain_model_form']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => '',
	),
	'types' => array(
		'1' => array('showitem' => 'title, name,' .
			'--div--;LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_form.fields, fields,' .
			'--div--;LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_form.processors, processors'
		),
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
				'foreign_table' => 'tx_superforms_domain_model_form',
				'foreign_table_where' => 'AND tx_superforms_domain_model_form.pid=###CURRENT_PID### AND tx_superforms_domain_model_form.sys_language_uid IN (-1,0)',
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
		'title' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_form.title',
			'config' => array(
				'type' => 'input',
			)
		),
		'name' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_form.name',
			'config' => array(
				'type' => 'input',
				'eval' => 'required,alphanum,unique'
			)
		),
		'fields' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_form.fields',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_superforms_domain_model_field',
				'foreign_field' => 'form',
				'foreign_sortby' => 'sorting',
				'maxitems'      => 9999,
				'appearance' => array(
					'useSortable' => 1,
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			)
		),
		'processors' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_form.processors',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_superforms_domain_model_processor',
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
	),
);
?>