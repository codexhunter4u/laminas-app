<?php

/**
 * User Module config file
 *
 * PHP version 8.2
 *
 * @author Mohan Jadhav <m.jadhav@easternenterprise.com>
 */

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
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig(): array
    {
        return [
            'factories' => [
                UserController::class => UserControllerFactory::class,
            ],
        ];
    }

    public function getServiceConfig(): array
    {
        return [
            'factories' => [
                UserTable::class => UserTableFactory::class,
                Model\UserTableGateway::class => UserTableGatewayFactory::class,
            ],
        ];
    }
}
