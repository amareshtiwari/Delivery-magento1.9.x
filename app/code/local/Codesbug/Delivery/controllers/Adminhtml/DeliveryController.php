<?php

class Codesbug_Delivery_Adminhtml_DeliveryController extends Mage_Adminhtml_Controller_action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('delivery/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('delivery/delivery')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            //  print_r($data);
            //  die();
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('delivery_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('delivery/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('delivery/adminhtml_delivery_edit'))
                ->_addLeft($this->getLayout()->createBlock('delivery/adminhtml_delivery_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('delivery')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('delivery/delivery');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            /**
             * save time_from and time_to as string
             */
            if (isset($data['time_from'])) {
                $timefrom = $data['time_from'];
                $timeto = $data['time_to'];
                $model->setTimeFrom($timefrom);
                $model->setTimeTo($timeto);
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('delivery')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } else if (isset($data['datetime_from'])) {
                $datetimefrom = $data['datetime_from'];
                $datetimeto = $data['datetime_to'];
                $model->setDatetimeFrom($datetimefrom);
                $model->setDatetimeTo($datetimeto);
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('delivery')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } else {
                try {
                    if ($model->getCreatedTime == null || $model->getUpdateTime() == null) {
                        $model->setCreatedTime(now())
                            ->setUpdateTime(now());
                    } else {
                        $model->setUpdateTime(now());
                    }

                    $model->save();
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('delivery')->__('Item was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);

                    if ($this->getRequest()->getParam('back')) {
                        $this->_redirect('*/*/edit', array('id' => $model->getId()));
                        return;
                    }
                    $this->_redirect('*/*/');
                    return;
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    Mage::getSingleton('adminhtml/session')->setFormData($data);
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                }
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('delivery')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('delivery/delivery');

                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $deliveryIds = $this->getRequest()->getParam('delivery');
        if (!is_array($deliveryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($deliveryIds as $deliveryId) {
                    $delivery = Mage::getModel('delivery/delivery')->load($deliveryId);
                    $delivery->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($deliveryIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}
