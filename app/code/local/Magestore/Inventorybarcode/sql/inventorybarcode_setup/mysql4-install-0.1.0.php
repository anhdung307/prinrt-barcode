<?php

/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category 	Magestore
 * @package 	Magestore_Inventorybarcode
 * @copyright 	Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license 	http://www.magestore.com/license-agreement.html
 */
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * create inventorybarcode table
 */
$installer->run("
    
DROP TABLE IF EXISTS {$this->getTable('erp_inventory_barcode_action_log')};
CREATE TABLE {$this->getTable('erp_inventory_barcode_action_log')} (
        `barcode_action_log_id` int(11) unsigned NOT NULL auto_increment,        
        `barcode_action` varchar(255) default '',
        `created_at` datetime default NULL,        
        `created_by` varchar(255) default '',  
        `barcode` varchar(255),
        PRIMARY KEY  (`barcode_action_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('erp_inventory_barcode_attribute_type')};
CREATE TABLE {$this->getTable('erp_inventory_barcode_attribute_type')} (
        `barcode_attribute_type_id` int(11) unsigned NOT NULL auto_increment,        
        `attribute_type` varchar(255) default '',
        `model` varchar(255) default '',       
        PRIMARY KEY  (`barcode_attribute_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO {$this->getTable('erp_inventory_barcode_attribute_type')} (attribute_type, model) VALUES ('product', 'catalog/product');
INSERT INTO {$this->getTable('erp_inventory_barcode_attribute_type')} (attribute_type, model) VALUES ('warehouse', 'inventoryplus/warehouse');
INSERT INTO {$this->getTable('erp_inventory_barcode_attribute_type')} (attribute_type, model) VALUES ('custom', '');


DROP TABLE IF EXISTS {$this->getTable('erp_inventory_barcode_attribute')};
CREATE TABLE {$this->getTable('erp_inventory_barcode_attribute')} (
        `barcode_attribute_id` int(11) unsigned NOT NULL auto_increment,        
        `attribute_name` varchar(255) default '',
        `attribute_code` varchar(255) default '',
        `attribute_type` varchar(255) default '',
        `attribute_display` tinyint(3) NOT NULL default '0',
        `attribute_unique` tinyint(3) NOT NULL default '0',
        `attribute_require` tinyint(3) NOT NULL default '0',
        `attribute_status` tinyint(3) NOT NULL default '1',
        PRIMARY KEY  (`barcode_attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Product Id', 'product_entity_id', 'product', 0);
INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Product Name', 'product_name', 'product', 1);
INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Product Sku', 'product_sku', 'product', 1);
INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Product Price', 'product_price', 'product', 0);
INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Warehouse Id', 'warehouse_warehouse_id', 'warehouse', 0);
INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Warehouse Name', 'warehouse_warehouse_name', 'warehouse', 1);

       
DROP TABLE IF EXISTS {$this->getTable('erp_inventory_barcode')}; 
CREATE TABLE {$this->getTable('erp_inventory_barcode')} (
    `barcode_id` int(11) unsigned NOT NULL auto_increment,        
    `barcode` varchar(255) default '',    
    `barcode_status` tinyint(3) NOT NULL default '1',
    `product_entity_id` int(11),
    `warehouse_warehouse_id` varchar(255),
    `purchaseorder_purchase_order_id` int(11),
    `supplier_supplier_id` int(11),
    `product_name` varchar(255) default '',
    `product_sku` varchar(255) default '',
    `warehouse_warehouse_name` varchar(255) default '', 
    `qty` int(11) not null default 0,
    `created_date` datetime,
    `qty_original` int(11) default 0,
    PRIMARY KEY  (`barcode_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS {$this->getTable('erp_inventory_barcode_template')};
    CREATE TABLE {$this->getTable('erp_inventory_barcode_template')} (
        `barcode_template_id` int(11) unsigned NOT NULL auto_increment,  
        `barcode_template_name` varchar(255) default '',
        `html` text default '',
        `template` varchar(255) default '',
        `status` tinyint(3) NOT NULL default '1',        
        PRIMARY KEY  (`barcode_template_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;     
    
DROP TABLE IF EXISTS {$this->getTable('erp_inventory_barcode_shipment')};
CREATE TABLE {$this->getTable('erp_inventory_barcode_shipment')} (
	`barcode_shipment_id` int(11) unsigned NOT NULL auto_increment,
	`barcode_id` int(11) unsigned  NOT NULL,	
	`order_id` int(11) unsigned  NOT NULL,
	`item_id` int(11) unsigned  NOT NULL,
	`product_id` int(11) unsigned  NOT NULL,
	`warehouse_id` int(11) unsigned  NOT NULL,	
	`qty_shipped` int(11) NOT NULL default '0',
	`qty_refunded` int(11) NOT NULL default '0',
	PRIMARY KEY  (barcode_shipment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if (Mage::helper('core')->isModuleEnabled('Magestore_Inventorypurchasing')) {
            
	$barcodeAttributeType = Mage::getModel('inventorybarcode/barcodeattribute_type')->getCollection()
																					->addFieldToFilter('attribute_type','purchaseorder');
	if($barcodeAttributeType->getSize()==0){
		$installer->run("
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute_type')} (attribute_type, model) VALUES ('supplier', 'inventorypurchasing/supplier');       
		");
	}
	$barcodeAttributeType = Mage::getModel('inventorybarcode/barcodeattribute_type')->getCollection()
													   ->addFieldToFilter('attribute_type','purchaseorder');
	if($barcodeAttributeType->getSize()==0){
		$installer->run("
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute_type')} (attribute_type, model) VALUES ('purchaseorder', 'inventorypurchasing/purchaseorder');       
		");
	}

	$barcodeAttribute = Mage::getModel('inventorybarcode/barcodeattribute')->getCollection()
														->addFieldToFilter('attribute_code','purchaseorder_purchase_order_id');
	if($barcodeAttribute->getSize()==0){
		$installer->run("
			
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Purchase Order Id', 'purchaseorder_purchase_order_id', 'purchaseorder', 0);       
		");
	}
	$barcodeAttribute = Mage::getModel('inventorybarcode/barcodeattribute')->getCollection()
														->addFieldToFilter('attribute_code','supplier_supplier_id');
	if($barcodeAttribute->getSize()==0){
		$installer->run("
			
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Supplier Id', 'supplier_supplier_id', 'supplier', 0);
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Supplier Name', 'supplier_supplier_name', 'supplier', 0);
		");
	}
	$barcodeAttribute = Mage::getModel('inventorybarcode/barcodeattribute')->getCollection()
														->addFieldToFilter('attribute_code','supplier_supplier_name');
	if($barcodeAttribute->getSize()==0){
		$installer->run("     
			INSERT INTO {$this->getTable('erp_inventory_barcode_attribute')} (attribute_name, attribute_code, attribute_type, attribute_display) VALUES ('Supplier Name', 'supplier_supplier_name', 'supplier', 0);
		");
	}
}

$data = array();
$data[] = array('barcode_template_name' => 'Barcode',
    'html' => '<div style="width: 220px; text-align: center;"><img style="width: 200px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/><span style="float: left; text-align: center; width: 100%; font-size: 17px;">010091930191421</span></div>',
    'template' => 'image_barcode.phtml',
    'status' => 1);
$data[] = array('barcode_template_name' => 'Product Name & Barcode',
    'html' => '<div style="width: 220px; text-align: center;"><span style="float: left; width: 100%; font-size: 17px; text-align: left; margin-left: 14px;">Product Name</span><img style="width: 200px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/><span style="float: left; text-align: center; width: 100%; font-size: 17px;">010091930191421</span></div>',
    'template' => 'name_barcode.phtml',
    'status' => 1);

$data[] = array('barcode_template_name' => 'Product Name, Size, Price & Barcode',
    'html' => '<div style="width: 220px; text-align: center;"><img style="width: 200px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/><span style="font-size: 10px; float: left; text-align: center; width: 100%;">010091930191421</span><div style="width: 50%; float: left; text-align: left;\"><ul style="float: left; list-style: outside none none; margin: 0px 0px 0px -26px;"><li>Product Name</li><li>Size</li><li>Color</li></ul></div><div style="width: 50%; float: left; text-align: left;"><span style="text-align: right; float: right; font-size: 30px; margin-right: 13px; margin-top: 11px;">Price</span></div></div>',
    'template' => 'name_size_color_price.phtml',
    'status' => 1);

$data[] = array('barcode_template_name' => 'Product Name, Price & Barcode',
    'html' => '<div style="width: 220px; text-align: center;"><span style="float: left; font-size: 17px; text-align: left; width: 47%; margin-left: 13px;">Product Name</span><span style="font-size: 17px; float: left; text-align: left; margin-left: 55px; width: 20%;">Price</span><img style="width: 200px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/><span style="float: left; text-align: center; width: 100%; font-size: 17px;">010091930191421</span></div>',
    'template' => 'name_price_barcode.phtml',
    'status' => 1);
foreach ($data as $template) {
    Mage::getModel('inventorybarcode/barcodetemplate')->addData($template)->save();
}


$installer->endSetup();

