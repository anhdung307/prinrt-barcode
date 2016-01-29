<?php

class Magestore_Inventorybarcode_Block_Adminhtml_Printbarcode_Renderer_ShowAttribtule extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        $option= array();
        $attribute_show='';
        $templateId=$row->getId();
        $collection = Mage::getModel('inventorybarcode/barcodetemplate')->load($templateId);
        if($collection->getData('productname_show')==1){
            array_push($option, 'Product name');
        }
        if($collection->getData('sku_show')==1){
            array_push($option, 'Sku');
        }
        if($collection->getData('price_show')==1){
            array_push($option, 'Price');
        }
        $attribute_show= implode(', ', $option);
        return $attribute_show;
    }
}
?>
