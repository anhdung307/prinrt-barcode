<?php

class Magestore_Inventorybarcode_Block_Adminhtml_Printbarcode_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'inventorybarcode';
        $this->_controller = 'adminhtml_printbarcode';

        $id = $this->getRequest()->getParam('id');
        if (!$id) {
            $this->removeButton('save');
            $this->removeButton('delete');

        } else {
            $this->removeButton('save');
            $this->removeButton('reset');
            $this->removeButton('saveandcontinue');
            $this->removeButton('cancel');
        }

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('inventory_content') == null)
                    tinyMCE.execCommand('mceAddControl', false, 'inventory_content');
                else
                    tinyMCE.execCommand('mceRemoveControl', false, 'inventory_content');
            }

        ";
    }

    /**
     * get text to show in header when edit an item
     *
     * @return string
     */
    public function getHeaderText() {
        if (Mage::registry('barcodeTemplate_data')
            && Mage::registry('barcodeTemplate_data')->getId()
        ) {
            return Mage::helper('inventorybarcode')->__("View Barcode Template '%s'", $this->htmlEscape(Mage::registry('barcodeTemplate_data')->getBarcodeTemplateName())
            );
        }
        return Mage::helper('inventorybarcode')->__('New Barcode Template');
    }

}

?>
