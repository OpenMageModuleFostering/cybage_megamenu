<?php
/**
* Cybage Megamenu Plugin
*
* @category   Megamenu Plugin
* @package    Cybage_Megamenu
* @copyright  Copyright (c) 2015 Cybage Software Pvt. Ltd., India
*             http://www.cybage.com/coe/e-commerce
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @author     Cybage Software Pvt. Ltd. 
 */
$installer = $this;

$installer->startSetup();

$installer->run("   
     insert into {$this->getTable('megamenu_type')}
(`type`,`is_active`) values ('Category Listing',1),('Product Listing',1),
('Group Menu Items',0),('Contact Us',1),('Anchor Text',1),('Content Text',1);

     insert into {$this->getTable('megamenu_template')}
(`type_id`,`name`,`is_active`) values (1,'Category Listing',1),(2,'Product Listing',1),(3,'Group Menu Items',1),(4,'Contact Us',1),(5,'Anchor Text',1),(6,'Content Text',1);

insert into {$this->getTable('megamenu_content_blocks')}
(`block_name`) values ('General'),('Main Content'),('Feature Content');

     insert into {$this->getTable('megamenu_attribute')} ( `atribute_code`,`atribute_label`,`content_block_id`,`is_active`,`atribute_type`,`is_visible`) values('menu_type','Menu Type',1,1,'select',1),
           ('template','Template',1,1,'select',1),
           ('column_count','Number Of Columns',1,1,'text',1),
           ('content_size','Content Size',1,1,'text',1),
           ('column_size','Size Of Columns',1,1,'text',1),
           ('feature_type','Featured Type',2,1,'select',1),
           ('feature_product_box_title','Featured Product Box Title',2,1,'text',1),
           ('feature_category_box_title','Featured Category Box Title',2,1,'text',1),           
           ('feature_product_ids','Featured Products',2,1,'button',1),
           ('feature_category_ids','Featured Categories',2,1,'button',1),
           ('category_box_title','Categories Box Title',3,1,'text',1),
           ('prodct_box_title','Prodcts Box Title',3,1,'text',1),
           ('main_content_category_ids','Categories',3,1,'button',1),
           ('main_content_product_ids','Products',3,1,'button',1),
           ('target_url','Target Url',1,1,'button',1),
           ('content_container','Content Container',1,1,'container',1);
           
           
    insert into {$this->getTable('megamenu_template_attributes')} (`template_id`, `attribute_id`, `is_active`) values('1','1','1'),
          ('1','2','1'),
          ('1','3','1'),
          ('1','4','1'),
          ('1','5','1'),
          ('1','6','1'),
          ('1','7','1'),
          ('1','8','1'),
          ('1','9','1'),
          ('1','10','1'),
          ('1','13','1'),
          ('2','1','1'),
          ('2','2','1'),
          ('2','3','1'),
          ('2','4','1'),
          ('2','5','1'),
          ('2','14','1'),
          ('3','1','1'),
          ('3','2','1'),
          ('3','3','1'),
          ('3','4','1'),
          ('3','5','1'),
          ('3','6','1'),
          ('3','8','1'),
          ('3','10','1'),
          ('3','13','1'),
          ('4','1','1'),
          ('4','2','1'),
          ('4','4','1'),
          ('5','1','1'),
          ('5','2','1'),
          ('5','3','1'),
          ('5','15','1'),
          ('6','1','1'),
          ('6','2','1'),
          ('6','4','1'),
          ('6','16','1');    
    
    
    ");

$installer->endSetup();
