<?php

namespace User\Model;

use User\Model\User;
use RuntimeException;
use Laminas\Db\Sql\Select;
use Laminas\Paginator\Paginator;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Db\TableGateway\TableGatewayInterface;

class UserTable 
{   
    private TableGatewayInterface $tableGateway;

    /**
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param boolean $paginated
     * 
     * @return Paginator
     */
    public function fetchAll($paginated = false): Paginator
    {
        if ($paginated) {
            return $this->fetchPaginatedResults();
        }

        return $this->tableGateway->select();
    }

    /**
     * @param Paginator
     * 
     * @return void
     */
    private function fetchPaginatedResults(): Paginator
    {
        $select = new Select($this->tableGateway->getTable());
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new User());
        $paginatorAdapter = new DbSelect($select, $this->tableGateway->getAdapter(), $resultSetPrototype);
        
        return new Paginator($paginatorAdapter);
    }

    /**
     * @param int $id
     * 
     * @return User
     */
    public function getUser(int $id): User
    {
        $user = $this->tableGateway->select(['id' => $id]);

        if (!$user->current()) {
            throw new RuntimeException(
                sprintf("Record not found for id %d", $id)
            );
        }

        return $user->current();
    }

    /**
     * @param User $user
     * 
     * @return void|int|RuntimeException
     */
    public function saveUser(User $user)
    {
        $data = [
            'firstName' => $user->firstname,
            'lastName' => $user->lastname,
            'email' => $user->email,
            'contact' => $user->contact,
            'profilephoto' => $this->getFiles($user),
        ];
        $id = (int) $user->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);

            return $id;
        }

        try {
            $this->getUser($id);
        } catch (RuntimeException $exception) {
            throw new RuntimeException(
                sprintf("Can not update this record, User not found for %d", $id)
            );
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    /**
     * @param int $id
     * 
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $this->tableGateway->delete(['id' => $id]);
    }

    /**
     * @param User $user
     * 
     * @return string
     */
    public function getFiles(User $user): string
    {
        $temp = explode('/', $user->profilephoto['tmp_name']);

        return $user->profilephoto['size'] === 0 ? $user->uploadedFile : $temp[2];
    }
}
