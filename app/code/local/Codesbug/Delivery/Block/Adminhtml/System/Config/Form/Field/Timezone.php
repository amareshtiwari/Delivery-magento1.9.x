<?php

class Codesbug_Delivery_Block_Adminhtml_System_Config_Form_Field_Timezone extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $datem = new Zend_Date(Mage::getModel('core/date')->timestamp(time()));
        $utc = Mage::getStoreConfig('general/locale/timezone');

        $html = '<input type="text" class="input-text" value="' . $datem . ' (' . $utc . ')" disabled>';

        return $html;
    }
}
