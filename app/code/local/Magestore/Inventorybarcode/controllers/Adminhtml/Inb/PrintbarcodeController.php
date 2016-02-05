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
 * @category    Magestore
 * @package     Magestore_Inventorybarcode
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventorybarcode Adminhtml Controller
 * 
 * @category    Magestore
 * @package     Magestore_Inventorybarcode
 * @author      Magestore Developer
 */
class Magestore_Inventorybarcode_Adminhtml_Inb_PrintbarcodeController extends Magestore_Inventoryplus_Controller_Action {

    /**
     * select template to print barcode
     *
     * @return Magestore_Inventory_Adminhtml_InventoryController
     */
    
    /* Edit by alan - print barcode*/
    
    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('inventoryplus/settings/barcode/manage_printbarcode');
        return $this;
    }

    /**
     * index action
     */
    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    public function newAction() {

        $this->_forward('edit');
    }

    public function editAction() {
        $templateId = $this->getRequest()->getParam('id');
        $model = Mage::getModel('inventorybarcode/barcodetemplate')->load($templateId);
        if ($templateId) {
            $this->_title($this->__('Inventory'))
                    ->_title($this->__('Add New Barcode Template'));
        }
        if ($model->getId() || $templateId == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('barcodeTemplate_data', $model);
            $this->loadLayout()->_setActiveMenu('inventoryplus/settings/barcode/manage_printbarcode');

            $this->getLayout()->getBlock('head')
                    ->addCss('css/magestore/inventorybarcode/hiddenleftslide.css');

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true)
                    ->removeItem('js', 'mage/adminhtml/grid.js')
                    ->addItem('js', 'magestore/adminhtml/inventory/grid.js');

            $this->_addContent($this->getLayout()->createBlock('inventorybarcode/adminhtml_printbarcode_edit'))
                    ->_addLeft($this->getLayout()->createBlock('inventorybarcode/adminhtml_printbarcode_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('inventorybarcode')->__('Item does not exist')
            );
            $this->_redirect('*/*/');
        }
    }

    public function saveTemplateAction() {
        $id = $this->getRequest()->getParam('id');
        $template_name = $this->getRequest()->getParam('barcode_template_name');
        $barcode_per_row = $this->getRequest()->getParam('barcode_per_row');
        $barcode_unit = $this->getRequest()->getParam('barcode_unit');
        $page_height = $this->getRequest()->getParam('page_height');
        $veltical_distantce = $this->getRequest()->getParam('veltical_distantce');
        $horizontal_distance = $this->getRequest()->getParam('horizontal_distance');
        $attribute_show = $this->getRequest()->getParam('attribute_show');
        $pageWidth = $this->getRequest()->getParam('pageWidth');
        $top_margin = $this->getRequest()->getParam('top_margin');
        $left_margin = $this->getRequest()->getParam('left_margin');
        $right_margin = $this->getRequest()->getParam('right_margin');
        $bottom_margin = $this->getRequest()->getParam('bottom_margin');
        $barcode_type = $this->getRequest()->getParam('barcode_type');
        $barcode_width = $this->getRequest()->getParam('barcode_width');
        $barcode_height = $this->getRequest()->getParam('barcode_height');
        $font_size = $this->getRequest()->getParam('font_size');
        
        $model = Mage::getModel('inventorybarcode/barcodetemplate');
        $attributeShow = explode(',', $attribute_show);
        $barcodePerRow = (int) $barcode_per_row;
        $productname_show = 0;
        $sku_show = 0;
        $price_show = 0;
        foreach ($attributeShow as $value) {
            if ($value == 'Product Name') {
                $productname_show = 1;
            }
            if ($value == 'Sku') {
                $sku_show = 1;
            }
            if ($value == 'Price') {
                $price_show = 1;
            }
        }

        $template = '<table style="width:' . ((int) $barcodePerRow * 25) . 'mm; height:22mm;text-align: center;">';
        $template .='<tr>';

        for ($i = 0; $i < $barcodePerRow; $i++) {
            $template .='<td style="width:25mm;">';
            foreach ($attributeShow as $value) {
                if ($value != 'null') {
                    $template .= '<span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">' . $value . '</span>';
                }
            }
            $template .= '<img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>
                      <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>';
            $template .= '</td>';
        }
        $template .= '</tr>
                        </table>';
        
        $template5 = '<div style="width: 80mm; text-align: center; ">                                                     
                                <table id ="kai" style=" width : 80; height:20; line-height:0.3; ">                                                    
                                        <tr width = 80mm>                                                    
                                                <td id="kai" width = 40mm>                                                    
                                                        <span style="float: left; width: 20mm; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span></br>                                                    
                                                        <span style="float: left; width: 20mm; font-size: 10px; text-align: left; margin-left: 14px;">Product Sku</span> </br>                            
                                                        <span style="float: left; width: 20mm; font-size: 12px; text-align: left; margin-left: 14px;">Price</span>                          
                                                </td>                                                    
                                                <td id="kai"  style="line-height: 0.5; " >                                                    
                                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/></br></br>                                                    
                                                        <span style="float: left; text-align: left; margin-left: 5px;  font-size: 10px;">010091930191421</span>                                                   
                                                </td>                                                    
                                        </tr>                                                    
                                </table>                                                
                        </div>';
        

        
        if($id){
            if($barcode_type==0){
                $model->setBarcodeTemplateName($template_name)->setHtml($template)->setProductnameShow($productname_show)->setSkuShow($sku_show)->setPriceShow($price_show)
                    ->setBarcodePerRow($barcode_per_row)->setPageHeight($page_height)->setBarcodeUnit($barcode_unit)->setVelticalDistantce($veltical_distantce)->setHorizontalDistance($horizontal_distance)
                    ->setPageWidth($pageWidth)->setTopMargin($top_margin)->setLeftMargin($left_margin)->setRightMargin($right_margin)->setBottomMargin($bottom_margin)->setBarcodeType($barcode_type)
                    ->setBarcodeWidth($barcode_width)->setBarcodeHeight($barcode_height)->setFontSize($font_size)->setBarcodeTemplateId($id)->save();
            }  else {
                $model->setBarcodeTemplateName($template_name)->setHtml($template5)->setProductnameShow($productname_show)->setSkuShow($sku_show)->setPriceShow($price_show)
                    ->setBarcodePerRow($barcode_per_row)->setPageHeight($page_height)->setBarcodeUnit($barcode_unit)->setVelticalDistantce($veltical_distantce)->setHorizontalDistance($horizontal_distance)
                    ->setPageWidth($pageWidth)->setTopMargin($top_margin)->setLeftMargin($left_margin)->setRightMargin($right_margin)->setBottomMargin($bottom_margin)->setBarcodeType($barcode_type)
                    ->setBarcodeWidth($barcode_width)->setBarcodeHeight($barcode_height)->setFontSize($font_size)->setBarcodeTemplateId($id)->save();
            }  
        }  elseif (!$id){
            if($barcode_type==0){
                $model->setBarcodeTemplateName($template_name)->setHtml($template)->setProductnameShow($productname_show)->setSkuShow($sku_show)->setPriceShow($price_show)
                    ->setBarcodePerRow($barcode_per_row)->setPageHeight($page_height)->setBarcodeUnit($barcode_unit)->setVelticalDistantce($veltical_distantce)->setHorizontalDistance($horizontal_distance)
                    ->setPageWidth($pageWidth)->setTopMargin($top_margin)->setLeftMargin($left_margin)->setRightMargin($right_margin)->setBottomMargin($bottom_margin)
                    ->setBarcodeType($barcode_type)->setBarcodeWidth($barcode_width)->setBarcodeHeight($barcode_height)->setFontSize($font_size)->save();
            }  else {
                $model->setBarcodeTemplateName($template_name)->setHtml($template5)->setProductnameShow($productname_show)->setSkuShow($sku_show)->setPriceShow($price_show)
                    ->setBarcodePerRow($barcode_per_row)->setPageHeight($page_height)->setBarcodeUnit($barcode_unit)->setVelticalDistantce($veltical_distantce)->setHorizontalDistance($horizontal_distance)
                    ->setPageWidth($pageWidth)->setTopMargin($top_margin)->setLeftMargin($left_margin)->setRightMargin($right_margin)->setBottomMargin($bottom_margin)
                    ->setBarcodeType($barcode_type)->setBarcodeWidth($barcode_width)->setBarcodeHeight($barcode_height)->setFontSize($font_size)->save();
            }
        }
        
        Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('inventorybarcode')->__('barcode template was successfully saved'));

        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $id = $this->getRequest()->getParam('id');
                $model = Mage::getModel('inventorybarcode/barcodetemplate')->load($id);
                $model->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__('Barcode template was successfully deleted')
                );
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    /* end Edit by alan - print barcode*/
    
    public function selecttemplateAction() {

        /*  add by Kai - print barcode */
        $checkdata = Mage::getStoreConfig('Inventorybarcode/printbarcode/editdata');

        if (!$checkdata) {
            Mage::getConfig()->saveConfig('Inventorybarcode/printbarcode/editdata', now());

            $model = Mage::getModel('inventorybarcode/barcodetemplate');

            $template1 = '<table style="width:75mm; height:22mm;text-align: center;">
                                <tr>
                                <td style="width:25mm;">
                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>
                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                </td>
                                <td style="width:25mm;">
                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>
                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                </td>
                                <td style="width:25mm;">
                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>
                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                </td>
                                </tr>
                        </table>';

            $template2 = '<table style="width:75mm; height:22mm;text-align: center;">	
                                <tr>		
                                <td style="width:25mm;">				
                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 							
                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                </td>                             		
                                <td style="width:25mm;">  				
                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 			   			
                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                </td>                             		
                                <td style="width:25mm;">				
                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 							
                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                </td>                             	
                                </tr>                             
                        </table>';

            $template3 = '<table style="width:75mm; height:22mm;text-align: center;">	
                                <tr>		
                                        <td style="width:25mm;">				
                                                <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 				
                                                <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Price</span>				
                                                <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                                <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                        </td>                             		
                                        <td style="width:25mm;">  				
                                                <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 				
                                                <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Price</span> 				
                                                <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                                <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                        </td>                             		
                                        <td style="width:25mm;">				
                                                <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 				
                                                <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Price</span>				
                                                <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                                <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                        </td>                             	
                                </tr>                             
                        </table>';

            $template4 = '<table style="width:75mm; height:22mm;text-align: center;">	
                                        <tr>		
                                                <td style="width:25mm;">				
                                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 				
                                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Sku</span>				
                                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                                </td>                             		
                                                <td style="width:25mm;">  				
                                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 				
                                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Sku</span> 				
                                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                                </td>                             		
                                                <td style="width:25mm;">				
                                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span> 				
                                                        <span style="float: left; width: 100%; font-size: 10px; text-align: left; margin-left: 14px;">Product Sku</span>				
                                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/>                               				
                                                        <span style="float: left; text-align: center; width: 100%; font-size: 10px;">010091930191421</span>
                                                </td>                             	
                                        </tr>                             
                        </table>';

            $template5 = '<div style="width: 80mm; text-align: center; ">                                                     
                                <table id ="kai" style=" width : 80; height:20; line-height:0.3; ">                                                    
                                        <tr width = 80mm>                                                    
                                                <td id="kai" width = 40mm>                                                    
                                                        <span style="float: left; width: 20mm; font-size: 10px; text-align: left; margin-left: 14px;">Product Name</span></br>                                                    
                                                        <span style="float: left; width: 20mm; font-size: 10px; text-align: left; margin-left: 14px;">Product Sku</span> </br>                            
                                                        <span style="float: left; width: 20mm; font-size: 12px; text-align: left; margin-left: 14px;">Price</span>                          
                                                </td>                                                    
                                                <td id="kai"  style="line-height: 0.5; " >                                                    
                                                        <img style="width: 100px;" src="{{media url="/inventorybarcode/source/barcode.jpg"}}"/></br></br>                                                    
                                                        <span style="float: left; text-align: left; margin-left: 5px;  font-size: 10px;">010091930191421</span>                                                   
                                                </td>                                                    
                                        </tr>                                                    
                                </table>                                                
                        </div>';

            $model->setId(1)->setBarcodeTemplateName("Barcode (3 items per row)")->setHtml($template1)->save();
            $model->setId(2)->setBarcodeTemplateName("Name, Barcode (3 items per row)")->setHtml($template2)->save();
            $model->setId(3)->setBarcodeTemplateName("Name, Price, Barcode (3 items per row)")->setHtml($template3)->save();
            $model->setId(4)->setBarcodeTemplateName("Name, Sku, Barcode (3s item per row)")->setHtml($template4)->save();
            $model->setId(5)->setBarcodeTemplateName("Barcode for jewelry ")->setHtml($template5)->save();
        }
        /* end add by Kai - print barcode */
        $function = Mage::getModel('inventorybarcode/printbarcode_function');
        echo $this->getLayout()->createBlock('inventorybarcode/adminhtml_printbarcode')->setTemplate('inventorybarcode/printbarcode/selecttemplate.phtml')->toHtml();
    }

    public function getimageAction() {

        $params = $this->getRequest()->getParams();
        $type = $params['type'];
        $code = $params['text'];

        if (isset($params['customize']) && $params['customize']) {
            $heigth = $params['heigth_barcode'];
            $barcodeOptions = array('text' => $code,
                'barHeight' => $heigth,
                'fontSize' => $params['font_size'],
                'withQuietZones' => true
            );
        } else {
            $barcodeOptions = array('text' => $code,
                'fontSize' => $params['font_size'],
                'withQuietZones' => true
            );
        }


        // No required options
        $rendererOptions = array();

        // Draw the barcode in a new image,
        // send the headers and the image
        $imageResource = Zend_Barcode::factory(
                        $type, 'image', $barcodeOptions, $rendererOptions
        );
        imagepng($imageResource->draw(), Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'inventorybarcode' . DS . 'images' . DS . 'barcode' . DS . 'barcode.png');
        $imageResource->render();
    }

    public function printBarcodeAction() {

        $params = $this->getRequest()->getParams();

        /* Added by Magnus 08/04/2015 (File pdf hien thi cac ki tu dc biet-ko hieu dc) */
        $this->loadLayout();
        $this->renderLayout();
        return;
        /* End Magnus 08/04/2015 */

        $contents = $this->getLayout()->createBlock('adminhtml/template')
                ->setTemplate('inventorybarcode/printbarcode/printbarcode.phtml')
                ->assign('barcodeId', $params['barcodeId'])
                ->assign('qty', $params['number_of_barcode'])
                ->assign('barcodeTemplate', $params['barcode_template'])
                ->assign('fontSize', $params['font_size'])
                ->assign('imageWidth', $params['image_width']);
        if (isset($params['border'])) {
            $contents->assign('border', $params['border']);
        } else {
            $contents->assign('border', 0);
        }

        include("lib/MPDF56/mpdf.php");
        $top = '10';
        $bottom = '10';
        $left = '10';
        $right = '10';
        // $params['printing_format']
        $mpdf = new mPDF('', 'B6', 8, '', '', '', '', '');

        $mpdf->WriteHTML($contents->toHtml());

        echo $mpdf->Output();
        die;
    }

    public function massprintBarcodeAction() {
        $this->loadLayout();
        $this->renderLayout();
        return;
    }
    public function printViewAction() {
        $barPerRow = $this->getRequest()->getParam('barPerRow');
        $barUnit = $this->getRequest()->getParam('barUnit');
        $pageHeight = $this->getRequest()->getParam('pageHeight');
        $velticalDistantce = $this->getRequest()->getParam('velticalDistantce');
        $horizontalDistance = $this->getRequest()->getParam('horizontalDistance');
        $attributeShow = $this->getRequest()->getParam('attributeShow');
        $pageWidth = $this->getRequest()->getParam('pageWidth');
        $topMargin = $this->getRequest()->getParam('topMargin');
        $leftMargin = $this->getRequest()->getParam('leftMargin');
        $rightMargin = $this->getRequest()->getParam('rightMargin');
        $bottomMargin = $this->getRequest()->getParam('bottomMargin');
        $barType = $this->getRequest()->getParam('barType');
        $barcodeWidth = $this->getRequest()->getParam('barcodeWidth');
        $barcodeHeight = $this->getRequest()->getParam('barcodeHeight');
        $fontSize = $this->getRequest()->getParam('fontSize');
        $attribute_Show = explode(',', $attributeShow);
        
        $contents = $this->getLayout()->createBlock('inventorybarcode/adminhtml_printbarcode')
                ->setTemplate('inventorybarcode/printbarcode/printview.phtml')
                ->assign('barPerRow', $barPerRow)
                ->assign('barUnit', $barUnit)
                ->assign('pageHeight',$pageHeight)
                ->assign('velticalDistantce', $velticalDistantce)
                ->assign('horizontalDistance', $horizontalDistance)
                ->assign('attributeShow',$attribute_Show)
                ->assign('pageWidth', $pageWidth)
                ->assign('topMargin', $topMargin)
                ->assign('leftMargin',$leftMargin)
                ->assign('rightMargin',$rightMargin)
                ->assign('bottomMargin', $bottomMargin)
                ->assign('barType', $barType)
                ->assign('barcodeWidth',$barcodeWidth)
                ->assign('barcodeHeight', $barcodeHeight)
                ->assign('fontSize', $fontSize);
        echo $contents->toHtml();
    }

    
}
