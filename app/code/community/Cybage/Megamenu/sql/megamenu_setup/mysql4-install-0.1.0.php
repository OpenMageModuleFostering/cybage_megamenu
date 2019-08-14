<?php

/**
 * megamenu setup
 * @category megamenu community plugin
 * @module Cybage_Megamenu
 * @created Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @created_at  17-April-2015 04:28 PM [IST]
 * @modified_at 17-April-2015 04:40 PM [IST]   
 */
$installer = $this;

$installer->startSetup();

$installer->run("
    
DROP TABLE IF EXISTS {$this->getTable('megamenu_type')};
CREATE TABLE {$this->getTable('megamenu_type')} (
  `entity_id` int(11)  NOT NULL auto_increment, 
  `type` varchar(255) NOT NULL default '',
  `is_active` boolean NOT NULL,  
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS {$this->getTable('megamenu_template')};
CREATE TABLE {$this->getTable('megamenu_template')} (
  `entity_id` int(11)  NOT NULL auto_increment, 
  `type_id` int(11)  NOT NULL ,   
  `name` varchar(255) NOT NULL default '',
  `is_active` boolean NOT NULL,
  PRIMARY KEY (`entity_id`),
   CONSTRAINT `FK_megamenu_template_typeid`FOREIGN KEY (`type_id`) REFERENCES megamenu_type (`entity_id`)  ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


DROP TABLE IF EXISTS {$this->getTable('megamenu_main')};
CREATE TABLE {$this->getTable('megamenu_main')} (
  `entity_id` int(11)  NOT NULL auto_increment,
  `type_id` int(11)  NOT NULL,
  `template_id` int(11)  NOT NULL,  
  `name` varchar(255) NOT NULL default '',    
  `header` text  NULL ,
  `footer` text  NULL ,  
  `is_active` boolean NOT NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`entity_id`)  
)ENGINE=InnoDB;

DROP TABLE IF EXISTS {$this->getTable('megamenu_attribute')};
CREATE TABLE {$this->getTable('megamenu_attribute')} (
  `entity_id` int(11)  NOT NULL auto_increment,
  `atribute_code` varchar(255) NOT NULL default '',
  `atribute_label` varchar(255) NOT NULL default '',
  `content_block_id` int(11)  NOT NULL ,
  `is_active` boolean NOT NULL,
  `atribute_type` varchar(255) NOT NULL default '',
  `is_visible` boolean NOT NULL,
  PRIMARY KEY (`entity_id`),       
 CONSTRAINT `FK_megamenu_attribute_contentblockid` FOREIGN KEY (`content_block_id`) REFERENCES megamenu_content_blocks (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB;

DROP TABLE IF EXISTS {$this->getTable('megamenu_template_attributes')};
CREATE TABLE {$this->getTable('megamenu_template_attributes')} (
  `entity_id` int(11)  NOT NULL auto_increment,  
  `template_id` int(11)  NOT NULL,  
  `attribute_id` int(11)  NOT NULL, 
  `is_active` boolean NOT NULL, 
  PRIMARY KEY (`entity_id`),
CONSTRAINT `FK_megamenu_template_attributes_templateid` FOREIGN KEY (`template_id`) REFERENCES megamenu_template (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,  
 CONSTRAINT `FK_megamenu_template_attributes_attributeid` FOREIGN KEY (`attribute_id`) REFERENCES megamenu_attribute (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE)ENGINE=InnoDB; 

DROP TABLE IF EXISTS {$this->getTable('megamenu_template_attributes_values')};
CREATE TABLE {$this->getTable('megamenu_template_attributes_values')} (
  `entity_id` int(11)  NOT NULL auto_increment,
  `template_attribute_id` int(11)  NOT NULL,
  `menu_id` int(11)  NOT NULL,  
  `value` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,  
  PRIMARY KEY (`entity_id`),
  CONSTRAINT `FK_megamenu_template_attributes_values_mapping` FOREIGN KEY (`template_attribute_id`) REFERENCES megamenu_template_attributes (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,     
 CONSTRAINT `FK_megamenu_template_attributes_values_menuid` FOREIGN KEY (`menu_id`) REFERENCES megamenu_main (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

DROP TABLE IF EXISTS {$this->getTable('megamenu_stores')};
CREATE TABLE {$this->getTable('megamenu_stores')} (  
  `menu_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  CONSTRAINT `FK_megamenu_stores_menuid` FOREIGN KEY (`menu_id`) REFERENCES megamenu_main (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS {$this->getTable('megamenu_content_blocks')};
CREATE TABLE {$this->getTable('megamenu_content_blocks')} (  
  `entity_id` int(11) NOT NULL auto_increment,
  `block_name` varchar(255) NOT NULL default '',
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB;

    ");

$installer->endSetup();
