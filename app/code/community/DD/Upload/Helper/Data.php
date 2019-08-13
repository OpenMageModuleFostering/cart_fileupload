<?php

/**
 * Dynamic Dreamz
 * @category   DD
 * @package    DD_Upload
 * @copyright  Copyright (c) 2014-2015 Dynamic Dreamz. (http://www.dynamicdreamz.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */

class DD_Upload_Helper_Data extends Mage_Core_Helper_Abstract {
    
    
    /**
     * Check if module is enable or not
     * @return int
     */
    
    public function isEnabled() {
        return Mage::getStoreConfig("generalsettings/configuration/enable_module");
    }
    
    /**
     * Check uploaded file extnsion and return file type
     * @param string $ext
     * @return string
     */
    
    public function checkFileType($ext) {
        switch ($ext) {
            case 'jpeg':return 'Image';
                break;
            case 'jpg':return 'Image';
                break;
            case 'gif':return 'Image';
                break;
            case 'png':return 'Image';
                break;
            case 'ico':return 'Tmage';
                break;
            case 'doc':return 'Document';
                break;
            case 'docx':return 'Document';
                break;
            case 'odt':return 'Document';
                break;
            case 'pdf':return 'PDF';
                break;
            case 'txt':return 'Text';
                break;
            case 'xls':return 'Excel';
                break;
            case 'ppt':return 'Powerpoint';
                break;
            case 'pptx':return 'Powerpoint';
                break;
            case 'csv':return 'CSV';
                break;
            case 'ods':return 'Document';
                break;
            case 'xml':return 'XML';
                break;
            default:return 'Unknown';
                break;
        }
    }
    
}
