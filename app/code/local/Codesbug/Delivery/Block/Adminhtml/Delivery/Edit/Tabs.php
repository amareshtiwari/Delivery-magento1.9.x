<?php

class Codesbug_Delivery_Block_Adminhtml_Delivery_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('delivery_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('delivery')->__('Settings'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('delivery')->__('Days Settings'),
            'title' => Mage::helper('delivery')->__('Days Settings'),
            'content' => $this->getLayout()->createBlock('delivery/adminhtml_delivery_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
