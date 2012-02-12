<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Render',
	array(
		'Form' => 'render, show, process, confirm',
	),
	// non-cacheable actions
	array(
		'Form' => 'render, process',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Display',
	array(
			// @todo remove dev action!
		'Form' => 'dev, display',
	)
);

	// Hook on inserting, updating, deleting records
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] =
	'EXT:' . $_EXTKEY . '/Classes/Hook/TceMainHook.php:tx_SuperForms_Hook_TceMainHook';

?>
