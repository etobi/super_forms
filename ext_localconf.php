<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Dev',
	array(
		'Form' => 'index, show, process, confirm',
	),
	// non-cacheable actions
	array(
		'Form' => 'index, show, process, confirm',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Display',
	array(
		'Form' => 'show, process, confirm',
	)
);

	// Hook on inserting, updating, deleting records
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] =
	'EXT:' . $_EXTKEY . '/Classes/Hook/TceMainHook.php:tx_SuperForms_Hook_TceMainHook';

?>