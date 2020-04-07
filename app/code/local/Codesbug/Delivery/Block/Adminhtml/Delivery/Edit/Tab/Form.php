<?php

class Codesbug_Delivery_Block_Adminhtml_Delivery_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('delivery_form', array('legend' => Mage::helper('delivery')->__('Item information')));
        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
        );
        $fieldset->addField('label', 'text', array(
            'label' => Mage::helper('delivery')->__('Label'),
            'class' => 'required-entry ',
            'required' => true,
            'name' => 'label',
        ));
/*
 * Add the the dates_type feild which show different type of time ,like all days , dateinterval etc..
 */
        $status = $fieldset->addField('dates_type', 'select', array(
            'label' => Mage::helper('delivery')->__('Types'),
            'name' => 'dates_type',
            'values' => array(
                array(
                    'value' => 'allday',
                    'label' => Mage::helper('delivery')->__('Select Day'),
                ),
                array(
                    'value' => 'dateinterval',
                    'label' => Mage::helper('delivery')->__('Date Interval'),
                ),
                array(
                    'value' => 'specificday',
                    'label' => Mage::helper('delivery')->__('Specific Days'),
                ),
                array(
                    'value' => 'timeinterval',
                    'label' => Mage::helper('delivery')->__('Time Intervals'),
                ),
                array(
                    'value' => 'datetimeinterval',
                    'label' => Mage::helper('delivery')->__('Date and Time Interval'),
                ),

            ),
        ));

        $allday = $fieldset->addField('all_day', 'select', array(
            'label' => Mage::helper('delivery')->__('All day'),
            'name' => 'all_day',
            'values' => array('-1' => 'Please Select..', 'Sunday' => 'Sunday', 'Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', '6' => 'Friday', 'Saturday' => 'Saturday'),
        ));

        $specificday = $fieldset->addField('specific_day', 'date', array(
            'label' => Mage::helper('delivery')->__('Specific Day'),
            'name' => 'specific_day',
            'note' => $this->__('Specific Day'),
            'required' => true,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => $dateFormatIso,
            'class' => 'required-entry validate-date',
        ));

        $dateintervalfrom = $fieldset->addField('date_from', 'date', array(
            'label' => Mage::helper('delivery')->__('Start Date'),
            'name' => 'date_from',
            'note' => $this->__('Start Date'),
            'required' => true,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => $dateFormatIso,
            'class' => 'required-entry validate-date validate-date-range date-range-custom_theme-from',
        ));

        $dateintervalto = $fieldset->addField('date_to', 'date', array(
            'label' => Mage::helper('delivery')->__('End Date'),
            'name' => 'date_to',
            'note' => $this->__('End Date'),
            'required' => true,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => $dateFormatIso,
            'class' => 'required-entry validate-date validate-date-range date-range-custom_theme-to',
        ));

        $timeintervalfrom = $fieldset->addField('time_from', 'select', array(
            'label' => Mage::helper('delivery')->__('Star Time'),
            'class' => 'validate-time-first',
            'required' => true,
            'name' => 'time_from',
            'values' => Mage::getModel('delivery/hours')->toOptionArray(),
            'disabled' => false,
            'readonly' => false,

        ));

        $timeintervalto = $fieldset->addField('time_to', 'select', array(
            'label' => Mage::helper('delivery')->__('End Time'),
            'class' => 'required-entry validate-time-last',
            'required' => true,
            'name' => 'time_to',
            'values' => Mage::getModel('delivery/hours')->toOptionArray(),
            'disabled' => false,
            'readonly' => false,
        ));

        $datespecificday = $fieldset->addField('datespecific_day', 'date', array(
            'label' => Mage::helper('delivery')->__('Date'),
            'name' => 'datespecific_day',
            'note' => $this->__('Specific Day'),
            'required' => true,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => $dateFormatIso,
            'class' => 'required-entry validate-date',
        ));

        $datetimeintervalfrom = $fieldset->addField('datetime_from', 'select', array(
            'label' => Mage::helper('delivery')->__('Star Time'),
            'class' => 'validate-time-first1',
            'required' => true,
            'name' => 'datetime_from',
            'values' => Mage::getModel('delivery/hours')->toOptionArray(),
            'disabled' => false,
            'readonly' => false,
//            'after_element_html' => '<small>Comments</small>',

        ));

        $datetimeintervalto = $fieldset->addField('datetime_to', 'select', array(
            'label' => Mage::helper('delivery')->__('End Time'),
            'class' => 'validate-time-last1',
            'required' => true,
            'name' => 'datetime_to',
            'values' => Mage::getModel('delivery/hours')->toOptionArray(),
            'disabled' => false,
            'readonly' => false,
        ));
        if (Mage::getSingleton('adminhtml/session')->getDeliveryData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getDeliveryData());
            Mage::getSingleton('adminhtml/session')->setDeliveryData(null);
        } elseif (Mage::registry('delivery_data')) {
            $form->setValues(Mage::registry('delivery_data')->getData());
        }

        $this->setForm($form);
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
                ->addFieldMap($status->getHtmlId(), $status->getName())
                ->addFieldMap($allday->getHtmlId(), $allday->getName())
                ->addFieldMap($dateintervalfrom->getHtmlId(), $dateintervalfrom->getName())
                ->addFieldMap($dateintervalto->getHtmlId(), $dateintervalto->getName())
                ->addFieldMap($specificday->getHtmlId(), $specificday->getName())
                ->addFieldMap($timeintervalfrom->getHtmlId(), $timeintervalfrom->getName())
                ->addFieldMap($timeintervalto->getHtmlId(), $timeintervalto->getName())
                ->addFieldMap($datetimeintervalto->getHtmlId(), $datetimeintervalto->getName())
                ->addFieldMap($datetimeintervalfrom->getHtmlId(), $datetimeintervalfrom->getName())
                ->addFieldMap($datespecificday->getHtmlId(), $datespecificday->getName())
                ->addFieldDependence(
                    $allday->getName(), $status->getName(), 'allday'
                )
                ->addFieldDependence(
                    $dateintervalfrom->getName(), $status->getName(), 'dateinterval'
                )
                ->addFieldDependence(
                    $dateintervalto->getName(), $status->getName(), 'dateinterval'
                )
                ->addFieldDependence(
                    $specificday->getName(), $status->getName(), 'specificday'
                )
                ->addFieldDependence(
                    $timeintervalfrom->getName(), $status->getName(), 'timeinterval'
                )
                ->addFieldDependence(
                    $timeintervalto->getName(), $status->getName(), 'timeinterval'
                )
                ->addFieldDependence(
                    $datespecificday->getName(), $status->getName(), 'datetimeinterval'
                )
                ->addFieldDependence(
                    $datetimeintervalfrom->getName(), $status->getName(), 'datetimeinterval'
                )
                ->addFieldDependence(
                    $datetimeintervalto->getName(), $status->getName(), 'datetimeinterval'
                )
        );
        return parent::_prepareForm();
    }

}
