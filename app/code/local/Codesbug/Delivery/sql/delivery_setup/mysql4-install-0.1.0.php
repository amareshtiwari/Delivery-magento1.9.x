<?php
/*
 * here we add the 4 column to sales_flat_order and sales_flat_quote tables  , codesbug_delivery_date
 * codesbug_delivery_comment , codesbug_delivery_timefirst and codesbug_delivery_timelast
 */
$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('sales/quote'), 'codesbug_delivery_date', array(
        'TYPE' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'NULLABLE' => true,
        'COMMENT' => 'Shipment  Delivery Date',
    ));
$installer->getConnection()
    ->addColumn($installer->getTable('sales/quote'), 'codesbug_delivery_comment', array(
        'TYPE' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'NULLABLE' => true,
        'COMMENT' => 'Shipment  Delivery Comment',
    ));

$installer->run("ALTER TABLE  sales_flat_quote ADD COLUMN codesbug_delivery_timefirst  DECIMAL( 10, 2 ) NOT NULL;");

$installer->run("ALTER TABLE  sales_flat_quote ADD COLUMN codesbug_delivery_timelast  DECIMAL( 10, 2 ) NOT NULL;");

$installer->getConnection()
    ->addColumn($installer->getTable('sales/order'), 'codesbug_delivery_date', array(
        'TYPE' => Varien_Db_Ddl_Table::TYPE_DATE,
        'NULLABLE' => true,
        'COMMENT' => 'Shipment  Delivery Date',
    ));
$installer->getConnection()
    ->addColumn($installer->getTable('sales/order'), 'codesbug_delivery_comment', array(
        'TYPE' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'NULLABLE' => true,
        'COMMENT' => 'Shipment Delivery Comment',
    ));
$installer->run("ALTER TABLE  sales_flat_order ADD COLUMN codesbug_delivery_timefirst  DECIMAL( 10, 2 ) NOT NULL;");

$installer->run("ALTER TABLE  sales_flat_order ADD COLUMN codesbug_delivery_timelast  DECIMAL( 10, 2 ) NOT NULL;");

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('codesbug_delivery_dates')};
CREATE TABLE {$this->getTable('codesbug_delivery_dates')} (
  `delivery_id` int(11) unsigned NOT NULL auto_increment,
  `label` varchar(255) NOT NULL default '',
  `dates_type` varchar(255) NOT NULL default '',
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `time_from` varchar(255) DEFAULT NULL,
  `time_to` varchar(255) DEFAULT NULL,
  `specific_day` date DEFAULT NULL,
  `datetime_from` varchar(255) DEFAULT NULL,
  `datetime_to` varchar(255) DEFAULT NULL,
  `datespecific_day` date DEFAULT NULL,
 `all_day` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`delivery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
$installer->endSetup();
