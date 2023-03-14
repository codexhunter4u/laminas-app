<?php

declare(strict_types=1);

namespace User\Form;

use Laminas\Form\Form;
use Laminas\InputFilter;
use Laminas\Form\Element;
use Laminas\Form\Element\File;

class UserForm extends Form
{
    /**
     * @param string $name
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'firstname',
            'type' => 'text',
            'options' => [
                'label' => 'First Name',
            ],
        ]);

        $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'options' => [
                'label' => 'Last Name',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email',
            ],
        ]);

        $this->add([
            'name' => 'contact',
            'type' => 'text',
            'options' => [
                'label' => 'Contact No',
            ],
        ]);

        $this->add([
            'name' => 'uploadedFile',
            'type' => Element\Hidden::class,
            'attributes' => [
                'value' => '',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id'    => 'submitbutton',
            ],
        ]);

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * @return void
     */
    public function addElements(): void
    {
        $file = new Element\File('profilephoto');
        $file->setLabel('Upload Profile Photo');
        $file->setAttribute('id', 'profilephoto');
        $file->setAttribute('multiple', false);

        $this->add($file);
    }

    /**
     * @return void
     */
    public function addInputFilter(): void
    {
        $inputFilter = new InputFilter\InputFilter();
        $fileInput = new InputFilter\FileInput('profilephoto');
        $fileInput->setRequired(false);
        $fileInput->getValidatorChain()
            ->attachByName('filesize',      ['max' => 204800])
            ->attachByName('filemimetype',  ['mimeType' => 'image/png, image/jpeg, image/jpg'])
            ->attachByName('fileimagesize', ['maxWidth' => 1000, 'maxHeight' => 800]);
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload', [
                'target'    => 'public/img/user.png',
                'randomize' => true,
            ]
        );
        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }
}
