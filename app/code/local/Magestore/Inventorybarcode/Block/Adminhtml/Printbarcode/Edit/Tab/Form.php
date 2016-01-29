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
 * @category     Magestore
 * @package     Magestore_Inventory
 * @copyright     Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventory Edit Form Block
 * 
 * @category    Magestore
 * @package     Magestore_Inventory
 * @author      Magestore Developer
 */
class Magestore_Inventorybarcode_Block_Adminhtml_Printbarcode_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareLayout() {
        if (count(Mage::helper('inventorypurchasing/purchaseorder')->getWarehouseOption()) > 0) {
            $this->setChild('continue_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label' => Mage::helper('inventorypurchasing')->__('Continue'),
                        'onclick' => "setSettings('" . $this->getContinueUrl() . "','continue_button')",
                        'class' => 'save'
                    ))
            );
        }
        return parent::_prepareLayout();
    }

    /**
     * prepare tab form's information
     *
     * @return Magestore_Inventory_Block_Adminhtml_Purchaseorder_Edit_Tab_Form
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('barcodeTemplate_edit', array('legend' => Mage::helper('inventorybarcode')->__('Template information')));

        $data='';
        if (Mage::getSingleton('adminhtml/session')->getBarcodeTemplateData()) {
            $data = Mage::getSingleton('adminhtml/session')->getBarcodeTemplateData();
            Mage::getSingleton('adminhtml/session')->setBarcodeTemplateData(null);
        } elseif (Mage::registry('barcodeTemplate_data')) {
            $data = Mage::registry('barcodeTemplate_data')->getData();
            $data['attribute_show']=array();
            if($data['productname_show']==1){
                array_push($data['attribute_show'],'Product Name');
            }
            if($data['sku_show']==1){
                array_push($data['attribute_show'],'Sku');
            }
            if($data['price_show']==1){
                array_push($data['attribute_show'],'Price');
            }
        }

        $fieldset->addField('barcode_template_name', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Template Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'barcode_template_name',
        ));

        $fieldset->addField('barcode_per_row', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Labels per row'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'barcode_per_row',
        ));

        $fieldset->addField('barcode_unit', 'select', array(
            'label' => Mage::helper('inventorybarcode')->__('Unit'),
            'class' => 'required-entry',
            'name' => 'barcode_unit',
            'values' => Mage::getSingleton('inventorybarcode/barcodeUnit')->getOptionHash(),
        ));
        
        $fieldset->addField('page_width', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Paper Width'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'page_width',
        ));
        
        $fieldset->addField('page_height', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Paper height'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'page_height',
        ));
        $fieldset->addField('top_margin', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Top margin'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'top_margin',
        ));
        $fieldset->addField('left_margin', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Left margin'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'left_margin',
        ));
        $fieldset->addField('right_margin', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Right margin'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'right_margin',
        ));
        $fieldset->addField('bottom_margin', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Bottom margin'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'bottom_margin',
        ));
        
        
        
        $fieldset->addField('horizontal_distance', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Space between rows'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'horizontal_distance',
        ));
        
        $fieldset->addField('veltical_distantce', 'text', array(
            'label' => Mage::helper('inventorybarcode')->__('Space between columns'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'veltical_distantce',
        ));

        $fieldset->addField('attribute_show', 'multiselect', array(
            'label' => Mage::helper('inventorybarcode')->__('Show attributes'),
            'name' => 'attribute_show',
            'values' => array(array('value' => 'Product Name', 'label' => 'Product Name'), array('value' => 'Sku', 'label' => 'Sku'),array('value' => 'Price', 'label' => 'Price'),array('value' => 'null', 'label' => '')),
        ));




        $fieldset->addField('continue_button', 'note', array(
            'text' => $this->getChildHtml('continue_button'),
            'after_element_html'=>'<script type="text/javascript">
                function setSettings(urlTemplate, setElement) {
                    var barcode_template_name=$("barcode_template_name").value;
                    var barcode_per_row=$("barcode_per_row").value;
                    var barcode_unit=$("barcode_unit").value;
                    var page_height=$("page_height").value;
                    var veltical_distantce=$("veltical_distantce").value;
                    var horizontal_distance=$("horizontal_distance").value;
                    var pageWidth=$("page_width").value;
                    
                    var top_margin=$("top_margin").value;
                    var left_margin=$("left_margin").value;
                    var right_margin=$("right_margin").value;
                    var bottom_margin=$("bottom_margin").value;
                    var select1 = document.getElementById("attribute_show");
                        var wSelected = "";
                        var j = 0;
                        for (var i = 0; i < select1.length; i++) {
                            if (select1.options[i].selected){
                                if(j!=0) wSelected += ",";
                                wSelected += select1.options[i].value;
                                j++;
                            }
                        }
                    var attribute_show = wSelected;

                    if(!barcode_template_name){
							alert("Please import template name to continue!");
                            return false;
                    }
                    if(!barcode_per_row){
							alert("Please import number per row to continue!");
                            return false;
                    }
                    if(!pageWidth){
							alert("Please import Page width to continue!");
                            return false;
                    }
                    if(!page_height){
							alert("Please import Heigth to continue!");
                            return false;
                    }
                    
                    if(!top_margin){
							alert("Please import top margin to continue!");
                            return false;
                    }
                    if(!left_margin){
							alert("Please import left margin to continue!");
                            return false;
                    }
                    if(!right_margin){
							alert("Please import right margin to continue!");
                            return false;
                    }
                    if(!bottom_margin){
							alert("Please import bottom margin to continue!");
                            return false;
                    }
                    if(!veltical_distantce){
							alert("Please import Veltical Distantce to continue!");
                            return false;
                    }
                    if(!horizontal_distance){
							alert("Please import Horizontal Distance to continue!");
                            return false;
                    }

                    setLocation(urlTemplate+"attribute_show/"+attribute_show+"/barcode_template_name/"+barcode_template_name+"/barcode_per_row/"+barcode_per_row+"/page_height/"+page_height+"/veltical_distantce/"+veltical_distantce+"/horizontal_distance/"+horizontal_distance+"/barcode_unit/"+barcode_unit+"/top_margin/"+top_margin+"/left_margin/"+left_margin+"/right_margin/"+right_margin+"/bottom_margin/"+bottom_margin+"/pageWidth/"+pageWidth);
                }
            </script>'
        ));
        $form->setValues($data);
        return parent::_prepareForm();
    }

    public function getContinueUrl() {
        return $this->getUrl('*/*/saveTemplate', array(
            '_current' => true,
        ));
    }
}
