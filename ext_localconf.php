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

?>