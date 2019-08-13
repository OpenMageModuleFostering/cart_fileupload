<?php

/**
 * Dynamic Dreamz
 * @category   DD
 * @package    DD_Upload
 * @copyright  Copyright (c) 2014-2015 Dynamic Dreamz. (http://www.dynamicdreamz.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */


class DD_Upload_Model_Upload extends Mage_Core_Model_Abstract {

    protected function _construct() {

        $this->_init("upload/upload");
    }

    /**
     * save record of particular uploaded file
     * @param string $quote_id
     * @param string $filename
     * @param string $type
     */
    public function saveFile($quote_id, $filename, $type) {
        $this->setFilename($filename);
        $this->setQuoteId($quote_id);
        $this->setType($type);
        $this->save();
        Mage::getSingleton('core/session')->unsData();
    }
    
    /**
     * get details of last uploded file
     * @param string $quote_id
     * @return object
     */
    public function getCurrentUploadedFiles($quote_id) {
        $collection = Mage::getModel('upload/upload')->getCollection();
        $collection->addFieldToFilter('quote_id', $quote_id);
        return $collection;
    }

}
