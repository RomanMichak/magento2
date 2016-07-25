<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Amqp\Model\Topology;

use Magento\Framework\MessageQueue\Topology\Config\ExchangeConfigItem\BindingInterface;
use PhpAmqpLib\Channel\AMQPChannel;

/**
 * {@inheritdoc}
 */
class BindingInstaller implements BindingInstallerInterface
{
    /**
     * @var array|BindingInstallerInterface[]
     */
    private $installers;

    /**
     * Initialize dependencies.
     *
     * @param BindingInstallerInterface[] $installers
     */
    public function __construct(array $installers)
    {
        $this->installers = $installers;
    }

    /**
     * {@inheritdoc}
     */
    public function install(AMQPChannel $channel, BindingInterface $binding, $exchangeName)
    {
        $this->getInstaller($binding->getDestinationType())->install($channel, $binding, $exchangeName);
    }

    /**
     * Get binding installer by type.
     *
     * @param string $type
     * @return BindingInstallerInterface
     */
    private function getInstaller($type)
    {
        return $this->installers[$type];
    }
}
