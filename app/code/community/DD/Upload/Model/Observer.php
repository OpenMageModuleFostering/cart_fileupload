<?php

/**
 * Dynamic Dreamz
 * @category   DD
 * @package    DD_Upload
 * @copyright  Copyright (c) 2014-2015 Dynamic Dreamz. (http://www.dynamicdreamz.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
class DD_Upload_Model_Observer {

    /**
     * runs after product added to cart
     * @param object $evt
     */
    public function saveQuoteAfter($evt) {
        if (Mage::helper('upload')->isEnabled()) {
            $quote = $evt->getQuote();
            try {
                $flag = '';
                $data = Mage::getSingleton('core/session')->getData();
                $flag = Mage::getSingleton('core/session')->getFlag();
                if (isset($data['file_upload_path']) && $flag == 'on') {
                    $quote_id = $quote->getId();
                    Mage::getModel('upload/upload')->saveFile($quote_id, $data['file_upload_path'], $data['file_upload_type']);
                    Mage::getSingleton('core/session')->unsData();
                    Mage::getSingleton('core/session')->unsFlag();
                    $flag = 'off';
                }
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }
    }

    /**
     * runs after placing order
     * @param object $event
     */
    public function placeOrderAfter($event) {
        if (Mage::helper('upload')->isEnabled()) {
            try {
                $order_id = $event->getEvent()->getOrder()->getId();
                $order = Mage::getModel('sales/order')->load($order_id);
                $quote_id = $order->getQuoteId();
                $collection = Mage::getModel('upload/upload')->getCollection();
                $collection->addFieldToFilter('quote_id', $quote_id);
                foreach ($collection as $object) {
                    Mage::getModel('upload/order')->saveFile($order_id, $object->getFilename(), $object->getType());
                }
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }
    }

}
