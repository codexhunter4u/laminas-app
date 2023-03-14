<?php

declare(strict_types=1);

namespace User\Service;

use User\Model\UserTable;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserTableFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * 
     * @return RankingService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): UserTable {
        $tableGateway = $container->get('User\Model\UserTableGateway');

        return new UserTable($tableGateway);
    }
}
