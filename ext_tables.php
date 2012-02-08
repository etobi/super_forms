<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'SuperForms');

t3lib_extMgm::allowTableOnStandardPages('tx_superforms_domain_model_form');
$TCA['tx_superforms_domain_model_form'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_form',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'delete' => 'deleted',
		'enablecolumns' => array(),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Form.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/model.gif'
	),
);

$TCA['tx_superforms_domain_model_field'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_field',
		'label' => 'label',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'delete' => 'deleted',
		'type' => 'type',
		'sortby' => 'sorting',
		'enablecolumns' => array(),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Field.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/model.gif'
	),
);

$TCA['tx_superforms_domain_model_validator'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:super_forms/Resources/Private/Language/locallang.xml:tx_superforms_domain_model_validator',
		'label' => 'type',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'delete' => 'deleted',
		'type' => 'type',
		'enablecolumns' => array(),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Validator.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/model.gif'
	),
);

?>