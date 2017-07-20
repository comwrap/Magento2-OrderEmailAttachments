<?php

namespace Comwrap\OrderEmailAttachments\Model\Sales\Order\Email;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Sales\Model\Order\Email\Container\IdentityInterface;
use Magento\Sales\Model\Order\Email\Container\Template;
use Comwrap\OrderEmailAttachments\Helper\Data as EmailHelper;

class SenderBuilder extends \Magento\Sales\Model\Order\Email\SenderBuilder
{
    /**
     * Helper for get Email attachement values.
     *
     * @var EmailHelper
     */
    protected $emailHelper;

    /**
     * @param Template          $templateContainer
     * @param IdentityInterface $identityContainer
     * @param TransportBuilder  $transportBuilder
     */
    public function __construct(
        Template $templateContainer,
        IdentityInterface $identityContainer,
        TransportBuilder $transportBuilder,
        EmailHelper $emailHelper
    ) {
        $this->templateContainer = $templateContainer;
        $this->identityContainer = $identityContainer;
        $this->transportBuilder = $transportBuilder;
        $this->emailHelper = $emailHelper;
        parent::__construct($templateContainer, $identityContainer, $transportBuilder);
    }

    /**
     * Prepare and send email message.
     */
    public function send()
    {
        $this->configureEmailTemplate();

        $this->transportBuilder->addTo(
            $this->identityContainer->getCustomerEmail(),
            $this->identityContainer->getCustomerName()
        );

        $copyTo = $this->identityContainer->getEmailCopyTo();

        if (!empty($copyTo) && $this->identityContainer->getCopyMethod() == 'bcc') {
            foreach ($copyTo as $email) {
                $this->transportBuilder->addBcc($email);
            }
        }

        $orderAttachment1 = $this->emailHelper->getOrderEmailAttachment(1, $this->identityContainer->getStore()->getId());
        if ($orderAttachment1) {
            $this->transportBuilder->addAttachment($orderAttachment1['content'], $orderAttachment1['name'], $orderAttachment1['type']);
        }

        $orderAttachment2 = $this->emailHelper->getOrderEmailAttachment(2, $this->identityContainer->getStore()->getId());
        if ($orderAttachment2) {
            $this->transportBuilder->addAttachment($orderAttachment2['content'], $orderAttachment2['name'], $orderAttachment2['type']);
        }

        $orderAttachment3 = $this->emailHelper->getOrderEmailAttachment(3, $this->identityContainer->getStore()->getId());
        if ($orderAttachment3) {
            $this->transportBuilder->addAttachment($orderAttachment3['content'], $orderAttachment3['name'], $orderAttachment3['type']);
        }

        $transport = $this->transportBuilder->getTransport();

        $transport->sendMessage();
    }
}
