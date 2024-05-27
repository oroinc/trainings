<?php

namespace TC\Bundle\SalesBundle\Workflow\Action;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\EmailBundle\Model\EmailHolderInterface;
use Oro\Bundle\EmailBundle\Tools\EmailAddressHelper;
use Oro\Bundle\EntityBundle\Provider\EntityNameResolver;
use Oro\Bundle\NotificationBundle\Async\Topic\SendEmailNotificationTopic;
use Oro\Bundle\SecurityBundle\Owner\EntityOwnerAccessor;
use Oro\Component\Action\Action\AbstractAction;
use Oro\Component\Action\Exception\InvalidParameterException;
use Oro\Component\ConfigExpression\ContextAccessor;
use Oro\Component\ConfigExpression\ContextAccessorAwareInterface;
use Oro\Component\ConfigExpression\ContextAccessorAwareTrait;
use Oro\Component\MessageQueue\Client\MessageProducerInterface;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Workflow action that sends email
 */
class NotifyOwner extends AbstractAction
{
    private array $options;

    public function __construct(
        ContextAccessor $contextAccessor,
        private ConfigManager $configManager,
        private EntityOwnerAccessor $entityOwnerAccessor,
        private EntityNameResolver $entityNameResolver,
        private MessageProducerInterface $messageProducer,
        private TranslatorInterface $translator
    ) {
        parent::__construct($contextAccessor);
    }

    public function initialize(array $options): self
    {
        if (empty($options['entity'])) {
            throw new InvalidParameterException('Entity parameter is required');
        }

        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function executeAction($context): void
    {
        $entity = $this->contextAccessor->getValue($context, $this->options['entity']);
        $owner = $this->entityOwnerAccessor->getOwner($entity);
        if (!$owner instanceof EmailHolderInterface) {
            return;
        }
        $this->messageProducer->send(
            SendEmailNotificationTopic::getName(),
            [
                'from' => $this->configManager->get('oro_notification.email_notification_sender_email'),
                'toEmail' => $owner->getEmail(),
                'subject' => $this->translator->trans('tc.sales.opportunity.owner_mismatch.email.subject'),
                'body' => $this->translator->trans(
                    'tc.sales.opportunity.owner_mismatch.email.body',
                    [
                        '{{ entityName }}' => $this->entityNameResolver->getName($entity),
                    ]
                ),
                'contentType' => 'text/html'
            ]
        );
    }
}
