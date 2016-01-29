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
 * Inventorybarcode Grid Block
 * 
 * @category    Magestore
 * @package     Magestore_Inventorybarcode
 * @author      Magestore Developer
 */
class Magestore_Inventorybarcode_Block_Adminhtml_Printbarcode_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('BarcodeTemplateId');
        $this->setDefaultSort('barcode_template_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
    
    /**
     * prepare collection for block to display
     *
     * @return Magestore_Inventorybarcode_Block_Adminhtml_Barcode_Grid
     */
    protected function _prepareCollection()
    {        
        $collection = Mage::getModel('inventorybarcode/barcodetemplate')->getCollection();
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }
    
    /**
     * prepare columns for this grid
     *
     * @return Magestore_Inventorybarcode_Block_Adminhtml_Barcode_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('barcode_template_id', array(
            'header'    => Mage::helper('inventorybarcode')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'barcode_template_id',
        ));

        $this->addColumn('barcode_template_name', array(
            'header'    => Mage::helper('inventorybarcode')->__('Title'),
            'align'     =>'left',
            'index'     => 'barcode_template_name',
        ));

        $this->addColumn('attribute_show', array(
            'header'    => Mage::helper('inventorybarcode')->__('Attribute Show'),
            'align'     =>'left',
            'index'     => 'qty',
            'type' => 'text',
            'filter'    => false,
            'renderer'=>'Magestore_Inventorybarcode_Block_Adminhtml_Printbarcode_Renderer_ShowAttribtule',
        ));
        
        $this->addColumn('page_width', array(
            'header'    => Mage::helper('inventorybarcode')->__('Page Width'),
            'align'     =>'left',
            'index'     => 'page_width',
            'type' => 'text'
        ));
        
        $this->addColumn('barcode_per_row', array(
            'header'    => Mage::helper('inventorybarcode')->__('Barcode Per Row'),
            'align'     =>'left',
            'index'     => 'barcode_per_row',
            'type' => 'text'
        ));
        
        $this->addColumn('status', array(
            'header'    => Mage::helper('inventorybarcode')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'        => 'options',
            'options'     => array(
                1 => 'Enabled',
                0 => 'Disabled',
            ),
        ));

        $this->addColumn('action',
            array(
                'header'    =>    Mage::helper('inventorybarcode')->__('Action'),
                'width'        => '100',
                'type'        => 'action',
                'getter'    => 'getId',
                'actions'    => array(
                    array(
                        'caption'    => Mage::helper('inventorybarcode')->__('Edit'),
                        'url'        => array('base'=> '*/*/edit'),
                        'field'        => 'id'
                    )),
                'filter'    => false,
                'sortable'    => false,
                'index'        => 'stores',
                'is_system'    => true,
        ));


        return parent::_prepareColumns();
    }

    /**
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}