<?php

namespace Comwrap\OrderEmailAttachments\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_EMAIL_ORDER_ATTACHMENT_1 = 'sales_email/order/attachment_1';
    const XML_EMAIL_ORDER_ATTACHMENT_2 = 'sales_email/order/attachment_2';
    const XML_EMAIL_ORDER_ATTACHMENT_3 = 'sales_email/order/attachment_3';

    protected $_filesystem;

    /**
     * @param Context $context
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context, \Magento\Framework\Filesystem $_filesystem)
    {
        $this->_filesystem = $_filesystem;
        parent::__construct($context);
    }

    public function getOrderEmailAttachment($index = 1, $store = null)
    {
        $usedConstant = "self::XML_EMAIL_ORDER_ATTACHMENT_{$index}";
        $file = $this->scopeConfig->getValue(constant($usedConstant), \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
        if ($file) {
            $filename = explode('/', $file);
            if (count($filename) > 1) {
                $filename = $filename[count($filename) - 1];
            }

            $mediaFolderPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
            $pdfPath = $mediaFolderPath.'order_email/'.$file;

            if (file_exists($pdfPath)) {
                return ['name' => $filename, 'content' => file_get_contents($pdfPath), 'type' => mime_content_type($pdfPath)];
            }
        }

        return false;
    }
}
