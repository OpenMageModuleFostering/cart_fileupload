<?php

/**
 * Dynamic Dreamz
 * @category   DD
 * @package    DD_Upload
 * @copyright  Copyright (c) 2014-2015 Dynamic Dreamz. (http://www.dynamicdreamz.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */

$installer = $this;
$installer->startSetup();
$installer->run(
"DROP TABLE IF EXISTS {$this->getTable('quote_file')};
CREATE TABLE {$this->getTable('quote_file')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `quote_id` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `type`  varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('order_file')};
CREATE TABLE {$this->getTable('order_file')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `order_id` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `type`  varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->endSetup();
