<?php

namespace Comwrap\OrderEmailAttachments\Model\Mail;

class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    public function addAttachment($fileContent, $filename = 'default.pdf', $type = 'application/pdf')
    {
        if ($fileContent) {
            $this->message->createAttachment(
                $fileContent,
                $type,
                \Zend_Mime::DISPOSITION_ATTACHMENT,
                \Zend_Mime::ENCODING_BASE64,
                $filename
            );

            return $this;
        }
    }
}
