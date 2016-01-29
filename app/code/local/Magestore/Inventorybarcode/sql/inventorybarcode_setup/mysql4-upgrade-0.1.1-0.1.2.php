<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$connection = $installer->getConnection();
$installer->startSetup();

$model=Mage::getModel('inventorybarcode/barcodetemplate')->load('5');
try{
    $installer->run("
        UPDATE  {$this->getTable('erp_inventory_barcode_template')} SET `productname_show`= '0',`sku_show`= '0',`price_show`= '0',`barcode_per_row`= '3',`page_height`= '30',`barcode_unit`= '0',`veltical_distantce`= '0',`horizontal_distance`= '0',`page_width`= '120',`top_margin`= '0',`left_margin`= '0',`right_margin`= '0',`bottom_margin`= '0' WHERE `barcode_template_id` = 1;
        UPDATE  {$this->getTable('erp_inventory_barcode_template')} SET `productname_show`= '1',`sku_show`= '0',`price_show`= '0',`barcode_per_row`= '3',`page_height`= '30',`barcode_unit`= '0',`veltical_distantce`= '0',`horizontal_distance`= '0',`page_width`= '120',`top_margin`= '0',`left_margin`= '0',`right_margin`= '0',`bottom_margin`= '0' WHERE `barcode_template_id` = 2;
        UPDATE  {$this->getTable('erp_inventory_barcode_template')} SET `productname_show`= '1',`sku_show`= '0',`price_show`= '1',`barcode_per_row`= '3',`page_height`= '30',`barcode_unit`= '0',`veltical_distantce`= '0',`horizontal_distance`= '0',`page_width`= '120',`top_margin`= '0',`left_margin`= '0',`right_margin`= '0',`bottom_margin`= '0' WHERE `barcode_template_id` = 3;
        UPDATE  {$this->getTable('erp_inventory_barcode_template')} SET `productname_show`= '1',`sku_show`= '1',`price_show`= '0',`barcode_per_row`= '3',`page_height`= '30',`barcode_unit`= '0',`veltical_distantce`= '0',`horizontal_distance`= '0',`page_width`= '120',`top_margin`= '0',`left_margin`= '0',`right_margin`= '0',`bottom_margin`= '0' WHERE `barcode_template_id` = 4;
    ");
        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');
        if($model->getData()){            
            $data = array("productname_show" => "1", "sku_show" => "1", "price_show" => "1", "barcode_per_row" => "1", "page_height" => "17", "barcode_unit" => "0", "veltical_distantce" => "0", "horizontal_distance" => "0", "page_width" => "76", "top_margin" => "0", "left_margin" => "0", "right_margin" => "0", "bottom_margin" => "0"); 
            $where = "barcode_template_id = 5"; 
            $write->update($this->getTable('erp_inventory_barcode_template'), $data, $where); 
            
        }  else {
            $write->insert($this->getTable('erp_inventory_barcode_template'), array('barcode_template_id' => 5, 'barcode_template_name' => 'Barcode for jewelry', 'html' => '', 'template' => '', 'status' => 1, 'productname_show' => 1, 'sku_show' => 1, 'price_show' => 1, 'barcode_per_row' => '1', 'page_height' => '17', 'barcode_unit' => 0, 'veltical_distantce' => '0', 'horizontal_distance' => '0', 'page_width' => '76', 'top_margin' => '0', 'left_margin' => '0', 'right_margin' => '0', 'bottom_margin' => '0'));   
        }
        

} catch(Exception $e) {
    
}

$installer->endSetup();