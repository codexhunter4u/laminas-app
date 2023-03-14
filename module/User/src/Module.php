<?php

declare(strict_types=1);

namespace User;

use User\Model\User;
use User\Model\UserTable;
use User\Service\UserTableFactory;
use Laminas\Db\ResultSet\ResultSet;
use User\Controller\UserController;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use User\Service\UserTableGatewayFactory;
use User\Controller\UserControllerFactory;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [
                UserController::class => UserControllerFactory::class,
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                UserTable::class => UserTableFactory::class,
                Model\UserTableGateway::class => UserTableGatewayFactory::class,
            ],
        ];
    }
}
