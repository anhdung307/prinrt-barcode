<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();



$installer->run("
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `productname_show` tinyint(3) NOT NULL;
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `sku_show` tinyint(3) NOT NULL;
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `price_show` tinyint(3) NOT NULL;
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `barcode_per_row` varchar(255) NOT NULL;
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `page_height` varchar(255) NOT NULL;
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `barcode_unit`  tinyint(3) NOT NULL;
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `page_width`  varchar(255) NOT NULL;
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `veltical_distantce` varchar(255) NOT NULL;
     ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `horizontal_distance` varchar(255) NOT NULL;
    ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `top_margin` varchar(255) NOT NULL;
    ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `left_margin` varchar(255) NOT NULL;
    ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `right_margin` varchar(255) NOT NULL;
    ALTER TABLE {$this->getTable('erp_inventory_barcode_template')}
         ADD `bottom_margin` varchar(255) NOT NULL;



");

$installer->endSetup();