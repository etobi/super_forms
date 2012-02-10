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
class Tx_SuperForms_Service_Processing_Database_TableService implements t3lib_Singleton {

	/**
	 * @var Tx_SuperForms_Domain_Repository_FormRepository
	 */
	protected $formRepository;

	/**
	 * @var t3lib_DB
	 */
	protected $db;

	/**
	 * @var string
	 */
	protected $tablePrefix = 'tx_superforms_domain_model_dynamic_response_';

	/**
	 * @var string
	 */
	protected $fieldPrefix = 'field_';

	/**
	 * @var array
	 */
	protected $columnDefinitionMap = array(
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_BASE => FALSE,
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_SUBMITBUTTON => FALSE,
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_TEXTBLOCK => FALSE,
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_TEXTAREA => array('text', 'DEFAULT \'\' NOT NULL'),
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_TEXTFIELD => array('varchar(255)', 'DEFAULT \'\' NOT NULL'),
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_RADIO => array('varchar(255)', 'DEFAULT \'\' NOT NULL'),
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_CHECKBOX => array('varchar(255)', 'DEFAULT \'\' NOT NULL'),
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_SELECT => array('varchar(255)', 'DEFAULT \'\' NOT NULL'),
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_HIDDEN => array('varchar(255)', 'DEFAULT \'\' NOT NULL'),
		Tx_SuperForms_Domain_Model_Field_Base::TYPE_AUTOFILL => array('varchar(255)', 'DEFAULT \'\' NOT NULL'),
	);

	/**
	 * @var array
	 */
	protected $fieldLists;

	/**
	 * @var array
	 */
	protected $queries = array(
		'createTable' => 'CREATE TABLE `%s` (
			uid int(11) NOT NULL auto_increment,
			pid int(11) DEFAULT \'0\' NOT NULL,

			tstamp int(11) unsigned DEFAULT \'0\' NOT NULL,
			crdate int(11) unsigned DEFAULT \'0\' NOT NULL,
			cruser_id int(11) unsigned DEFAULT \'0\' NOT NULL,
			deleted tinyint(4) unsigned DEFAULT \'0\' NOT NULL,

			PRIMARY KEY (uid),
			KEY parent (pid)
		);',
		'addColumn' => 'ALTER TABLE `%s` ADD `%s` %s;',
		'renameColumn' => 'ALTER TABLE `%s` CHANGE `%s` `zzz_%s_%s` %s;'
	);

	/**
	 * Construct the hook
	 */
	public function __construct() {
		$this->db = $GLOBALS['TYPO3_DB'];
	}

	public function injectFormRepository(Tx_SuperForms_Domain_Repository_FormRepository $formRepository) {
		$this->formRepository = $formRepository;
	}

	/**
	 * @param int $formUid
	 * @return void
	 */
	public function compileTable($formUid) {
		/** @var $form Tx_SuperForms_Domain_Model_Form */
		$form = $this->formRepository->findByUid($formUid);
		if ($form
				&& $form->getFields()->count() > 0
				&& $form->getProcessors()->count() > 0) {
			foreach($form->getProcessors() as $processor) {
				/** @var $processor Tx_SuperForms_Domain_Model_Processor */
				if ($processor->getType() === Tx_SuperForms_Domain_Model_Processor::TYPE_DATABASE) {
					$this->createOrUpdateTableDefinition($form);
					break;
				}
			}
		}
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @return void
	 */
	protected function createOrUpdateTableDefinition(Tx_SuperForms_Domain_Model_Form $form) {
		if (!$form->getName()) return;

		if (!$this->tableExists($form)) {
			$this->createBaseTable($form);
		}
		$this->updateTableFields($form);
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @return bool
	 */
	public function tableExists(Tx_SuperForms_Domain_Model_Form $form) {
		$tableName = $this->getTableNameForForm($form);
		$tables = $this->db->admin_get_tables();
		return isset($tables[$tableName]);
	}

	/**
	 * @param string $tableName
	 * @return void
	 */
	protected function createBaseTable(Tx_SuperForms_Domain_Model_Form $form) {
		$tableName = $this->getTableNameForForm($form);
		$this->db->sql_query(sprintf($this->queries['createTable'], $tableName));
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Form $form
	 * @param string $tableName
	 * @return void
	 */
	protected function updateTableFields(Tx_SuperForms_Domain_Model_Form $form) {
		$tableName = $this->getTableNameForForm($form);
		foreach($form->getFields() as $field) {
			$this->addOrUpdateColumn($tableName, $field);
		}
	}

	/**
	 * @param string $tableName
	 * @param array $currentFieldList
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface $field
	 * @return void
	 */
	protected function addOrUpdateColumn($tableName, $field) {
		if (!$field->getName()) return;

		if ($this->columnNeedsUpdate($tableName, $field)) {
			$this->updateColumn($tableName, $field);

		} else if (!$this->columnExists($tableName, $field)) {
			$this->addColumn($tableName, $field);
		}
	}

	/**
	 * @param string $tableName
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface $field
	 * @return void
	 */
	protected function updateColumn($tableName, $field) {
		$this->renameColumn($tableName, $field);
		$this->addColumn($tableName, $field);
	}

	/**
	 * @param string $tableName
	 * @param array $currentFieldList
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface $field
	 * @return void
	 */
	protected function renameColumn($tableName, $field) {
		$this->db->sql_query(sprintf(
			$this->queries['renameColumn'],
			$tableName,
			$this->getColumnNameForField($field),
			$this->getColumnNameForField($field),
			time(),
			$this->getColumnDefinitionForColumn(
				$tableName,
				$this->getColumnNameForField($field)
			)
		));
	}

	/**
	 * @param string $tableName
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface $field
	 * @return void
	 */
	protected function addColumn($tableName, $field) {
		if ($this->canAddColumnForField($field)) {
			$this->db->sql_query(sprintf(
				$this->queries['addColumn'],
				$tableName,
				$this->getColumnNameForField($field),
				$this->getColumnDefinitionForField($field)
			));
		}
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface $field
	 * @return bool
	 */
	protected function canAddColumnForField(Tx_SuperForms_Domain_Model_Field_FieldInterface $field) {
		return $field->getName() && isset($this->columnDefinitionMap[$field->getType()]);
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface|string $field
	 * @return string
	 */
	public function getColumnNameForField($field) {
		$fieldName = $field instanceof Tx_SuperForms_Domain_Model_Field_FieldInterface ? $field->getName() : $field;
		return $this->fieldPrefix . $fieldName;
	}

	/**
	 * @param string $tableName
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface $field
	 * @return bool
	 */
	protected function columnNeedsUpdate($tableName, Tx_SuperForms_Domain_Model_Field_FieldInterface $field) {
		return $this->columnExists($tableName, $field)
				&& ($this->getColumnDefinitionForField($field) !== $this->getColumnDefinitionForColumn($tableName, $this->getColumnNameForField($field)));
	}

	/**
	 * @param string $tableName
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface $field
	 * @return bool
	 */
	protected function columnExists($tableName, Tx_SuperForms_Domain_Model_Field_FieldInterface $field) {
		return $this->getColumnDefinitionForColumn($tableName, $this->getColumnNameForField($field)) !== NULL;
	}

	/**
	 * @param Tx_SuperForms_Domain_Model_Field_FieldInterface $field
	 * @return bool|string
	 */
	protected function getColumnDefinitionForField(Tx_SuperForms_Domain_Model_Field_FieldInterface $field) {
		$columnDefinition = $this->columnDefinitionMap[$field->getType()];
		if (!$columnDefinition) return FALSE;
		return is_array($columnDefinition) ? implode(' ', $columnDefinition) : $columnDefinition;
	}

	/**
	 * @param string $tableName
	 * @param string $columnName
	 * @return string
	 */
	protected function getColumnDefinitionForColumn($tableName, $columnName) {
		$columns = $this->getCurrentColumns($tableName);
		$definitionArray = $columns[$columnName];
		return !is_array($definitionArray) ? NULL :
			trim(
				$definitionArray['Type'] .
				' ' .
				'DEFAULT \'' . $definitionArray['Default'] . '\'' .
				' ' .
				($definitionArray['Null'] === 'NO' ? 'NOT NULL' : '')
			);
	}

	/**
	 * @param string $tableName
	 * @return array
	 */
	protected function getCurrentColumns($tableName) {
		if ($this->fieldLists[$tableName] === NULL) {
			$this->fieldLists[$tableName] = $this->db->admin_get_fields($tableName);
		}
		return $this->fieldLists[$tableName];
	}

	/**
	 * @param $form
	 * @return string
	 */
	public function getTableNameForForm(Tx_SuperForms_Domain_Model_Form $form) {
		return $this->tablePrefix . $form->getName();
	}
}

?>