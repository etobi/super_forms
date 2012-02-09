# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.61)
# Datenbank: magicticket
# Erstellungsdauer: 2012-02-09 09:50:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle tx_superforms_domain_model_field
# ------------------------------------------------------------

LOCK TABLES `tx_superforms_domain_model_field` WRITE;
/*!40000 ALTER TABLE `tx_superforms_domain_model_field` DISABLE KEYS */;

INSERT INTO `tx_superforms_domain_model_field` (`uid`, `pid`, `form`, `label`, `name`, `type`, `options`, `value`, `zzz_deleted_validations`, `validation_depends_on_field`, `tstamp`, `crdate`, `cruser_id`, `deleted`, `zzz_deleted_hidden`, `zzz_deleted_starttime`, `zzz_deleted_endtime`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3ver_move_id`, `t3_origuid`, `sys_language_uid`, `l10n_parent`, `l10n_diffsource`, `sorting`, `validators`)
VALUES
	(1,1,1,'Textfield','textfield','Tx_SuperForms_Domain_Model_Field_Textfield','','',0,0,1328778234,1328714507,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL,1,0),
	(2,1,1,'Textarea','textarea','Tx_SuperForms_Domain_Model_Field_Textarea','','',0,0,1328778259,1328778234,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL,2,0),
	(3,1,1,'Radio','radio','Tx_SuperForms_Domain_Model_Field_Radio','Foo\r\nBar\r\nBaz','',0,0,1328778297,1328778259,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL,3,0),
	(4,1,1,'Checkbox','checkbox','Tx_SuperForms_Domain_Model_Field_Checkbox','Schmoo\r\nSchmar\r\nSchmaz','',0,0,1328778329,1328778297,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL,4,0),
	(5,1,1,'Select','select','Tx_SuperForms_Domain_Model_Field_Select','Coo\r\nCar\r\nCaz','',0,0,1328778356,1328778329,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL,5,0),
	(6,1,1,'Submit','submit','Tx_SuperForms_Domain_Model_Field_SubmitButton','','Goo',0,0,1328778385,1328778356,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL,6,0),
	(7,1,1,'Text','text','Tx_SuperForms_Domain_Model_Field_Textblock','Hier steht dann wohl mein Text ... ','',0,0,1328778604,1328778385,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL,7,0),
	(8,1,1,'Hidden','hidden','Tx_SuperForms_Domain_Model_Field_Hidden','','Hidden',0,0,1328778619,1328778604,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL,8,0);

/*!40000 ALTER TABLE `tx_superforms_domain_model_field` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle tx_superforms_domain_model_form
# ------------------------------------------------------------

LOCK TABLES `tx_superforms_domain_model_form` WRITE;
/*!40000 ALTER TABLE `tx_superforms_domain_model_form` DISABLE KEYS */;

INSERT INTO `tx_superforms_domain_model_form` (`uid`, `pid`, `title`, `fields`, `tstamp`, `crdate`, `cruser_id`, `deleted`, `zzz_deleted_hidden`, `zzz_deleted_starttime`, `zzz_deleted_endtime`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3ver_move_id`, `t3_origuid`, `sys_language_uid`, `l10n_parent`, `l10n_diffsource`)
VALUES
	(1,1,'First Form','8',1328714507,1328714507,16,0,0,0,0,0,0,0,'',0,0,0,0,0,0,0,0,NULL);

/*!40000 ALTER TABLE `tx_superforms_domain_model_form` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
