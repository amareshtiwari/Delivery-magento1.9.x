<?php
/*
 * Here we show the grid of Codesbug_delivery
 */
class Codesbug_Delivery_Block_Adminhtml_Delivery_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('deliveryGrid');
        $this->setDefaultSort('delivery_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('delivery/delivery')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('delivery_id', array(
            'header' => Mage::helper('delivery')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'delivery_id',
        ));

        $this->addColumn('label', array(
            'header' => Mage::helper('delivery')->__('Label'),
            'align' => 'left',
            'index' => 'label',
        ));

        $this->addColumn('dates_type', array(
            'header' => Mage::helper('delivery')->__('Type'),
            'align' => 'left',
            'index' => 'dates_type',
            'type' => 'options',
            'options' => array(
                'allday' => 'All Days',
                'dateinterval' => 'Date Interval',
                'specificday' => 'Specific Days',
                'timeinterval' => 'Time Intervals',
                'datetimeinterval' => 'Date and Time Interval',
            ),
        ));

        $this->addColumn('dates', array(
            'header' => Mage::helper('delivery')->__('Dates'),
            'align' => 'left', 'width' => '200px',
            'index' => 'delivery_id',
            'renderer' => new Excellence_Delivery_Block_Adminhtml_Renderer_Customdate(),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('delivery')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('delivery')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id',
                ),
                array(
                    'caption' => Mage::helper('delivery')->__('Delete'),
                    'url' => array('base' => '*/*/delete'),
                    'field' => 'id',
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

//        $this->addExportType('*/*/exportCsv', Mage::helper('delivery')->__('CSV'));
        //        $this->addExportType('*/*/exportXml', Mage::helper('delivery')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('delivery_id');
        $this->getMassactionBlock()->setFormFieldName('delivery');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('delivery')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('delivery')->__('Are you sure?'),
        ));

//        $statuses = Mage::getSingleton('delivery/status')->getOptionArray();
        //
        //        array_unshift($statuses, array('label' => '', 'value' => ''));
        //        $this->getMassactionBlock()->addItem('status', array(
        //            'label' => Mage::helper('delivery')->__('Change status'),
        //            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
        //            'additional' => array(
        //                'visibility' => array(
        //                    'name' => 'status',
        //                    'type' => 'select',
        //                    'class' => 'required-entry',
        //                    'label' => Mage::helper('delivery')->__('Status'),
        //                    'values' => $statuses
        //                )
        //            )
        //        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
