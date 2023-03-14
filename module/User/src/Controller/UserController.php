<?php

declare(strict_types=1);

namespace User\Controller;

use Exception;
use User\Model\User;
use User\Form\UserForm;
use User\Model\UserTable;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;

class UserController extends AbstractActionController
{
    private UserTable $table;

    /**
     * @param UserTable $table
     */
    public function __construct(UserTable $table) {
        $this->table = $table;
    }

    /**
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $paginator = $this->table->fetchAll(true);
        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);

        return new ViewModel(['paginator' => $paginator]);
    }

    /**
     * @return array
     */
    public function addAction(): array
    {
        $form = new UserForm('user');
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $user = new User();
            $formData = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $form->setData($formData);

            if (!$form->isValid()) {
                return ['form' => $form];
            }

            $user->exchangeArray($form->getData());
            $this->table->saveUser($user);

            return $this->redirect()->toRoute('user');
        }

        return ['form' => $form];
    }

    /**
     * @return array
     */
    public function editAction(): array
    {
        $id = (int) $this->params()->fromRoute('id');

        if (0 === $id) {
            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }

        try {
            $user = $this->table->getUser($id);
        } catch (Exception $e) {
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }

        $form = new userForm('user');
        $form->bind($user);
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $postData = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );
        $form->setData($postData);

        if (!$form->isValid()) {
            return $viewData;
        }

        $this->table->saveuser($user);

        return $this->redirect()->toRoute('user', ['action' => 'index']);
    }

    /**
     * @return array
     */
    public function deleteAction(): array
    {
        $id = (int) $this->params()->fromRoute('id');

        if (!$id) {
            return $this->redirect()->toRoute('user');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $confirmDelete = $request->getPost('del', 'No');

            if ($confirmDelete == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteUser($id);
            }

            return $this->redirect()->toRoute('user');
        }

        return [
            'id'    => $id,
            'user' => $this->table->getUser($id),
        ];
    }
}
