<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Tobias Liebig <work@etobi.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * @package super_forms
 */
class Tx_SuperForms_Domain_Model_Processor extends Tx_Extbase_DomainObject_AbstractEntity {

	const TYPE_EMAIL = 'Tx_SuperForms_Domain_Model_Processor_Email';
	const TYPE_DATABASE = 'Tx_SuperForms_Domain_Model_Processor_Database';
	const TYPE_FILE = 'Tx_SuperForms_Domain_Model_Processor_File';

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $options;

	/**
	 * @param string $options
	 */
	public function setOptions($options) {
		$this->options = $options;
	}

	/**
	 * @return string
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}
}
?>