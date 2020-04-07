<?php

class Codesbug_Delivery_Block_Adminhtml_Delivery_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'delivery';
        $this->_controller = 'adminhtml_delivery';

        $this->_updateButton('save', 'label', Mage::helper('delivery')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('delivery')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('delivery_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'delivery_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'delivery_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('delivery_data') && Mage::registry('delivery_data')->getId()) {
            return Mage::helper('delivery')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('delivery_data')->getTitle()));
        } else {
            return Mage::helper('delivery')->__('Add Item');
        }
    }
}
