<?php

class Magestore_Inventorybarcode_Block_Adminhtml_Printbarcode_Edit_Tabs extends
Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('printbarcode_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('inventorybarcode')->__('Barcode Template Information'));
    }

    protected function _beforeToHtml() {

                $this->addTab('form_section', array(
                    'label' => Mage::helper('inventorybarcode')->__('General Information'),
                    'title' => Mage::helper('inventorybarcode')->__('General Information'),
                    'content' => $this->getLayout()
                        ->createBlock('inventorybarcode/adminhtml_printbarcode_edit_tab_form')
                        ->toHtml(),
                ));

        return parent::_beforeToHtml();
    }
}
?>
