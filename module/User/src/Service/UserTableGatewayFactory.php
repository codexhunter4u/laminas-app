<?php

declare(strict_types=1);

namespace User\Service;

use User\Model\User;
use Laminas\Db\ResultSet\ResultSet;
use Psr\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserTableGatewayFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * 
     * @return TableGateway
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): TableGateway {
        $dbAdapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new User());
        
        return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);        
    }
}
