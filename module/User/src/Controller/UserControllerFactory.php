<?php

declare(strict_types=1);

namespace User\Controller;

use User\Model\UserTable;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * 
     * @return UserController
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): UserController {
        return new UserController($container->get(UserTable::class));
    }
}
