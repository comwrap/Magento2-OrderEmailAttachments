<?php

namespace Comwrap\OrderEmailAttachments\Model\Config\Backend;

class OrderAttachment extends \Magento\Config\Model\Config\Backend\File
{
    /**
     * @return string[]
     */
    public function getAllowedExtensions()
    {
        return ['pdf', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg'];
    }
}
