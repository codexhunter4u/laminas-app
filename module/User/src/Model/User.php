<?php

namespace User\Model;

use DomainException;
use Laminas\Filter\ToInt;
use Laminas\Filter\StripTags;
use Laminas\Filter\StringTrim;
use Laminas\Validator\StringLength;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

class User
{
    public $id;
    public $email;
    public $contact;
    public $lastname;
    public $firstname;
    public $profilephoto;
    private $inputFilter;

    /**
     * @param array $data
     * 
     * @return void
     */
    public function exchangeArray(array $data): void
    {
        $this->id           = !empty($data['id']) ? $data['id'] : null;
        $this->firstname    = !empty($data['firstname']) ? $data['firstname']:  null;
        $this->lastname     = !empty($data['lastname']) ? $data['lastname']: null;
        $this->email        = !empty($data['email']) ? $data['email'] : null;
        $this->contact      = !empty($data['contact']) ? $data['contact']:  null;
        $this->profilephoto = !empty($data['profilephoto']) ? $data['profilephoto'] : null;
        $this->uploadedFile = !empty($data['uploadedFile']) ? $data['uploadedFile'] : null;
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'id'     => $this->id,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'email'  => $this->email,
            'contact'  => $this->contact,
            'profilephoto'  => $this->profilephoto,
        ];
    }

    /**
     * @param InputFilterInterface $inputFilter
     * 
     * @return void
     */
    public function setInputFilter(InputFilterInterface $inputFilter): void
    {
        sprintf('%s does not allow injection of an alternative input filters', __CLASS__);
    }

    /**
     * @return array
     */
    public function getInputFilter(): array
    {
        if ($this->inputFilter) {
            return $this->inputFIlter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'firstname',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 15
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'lastname',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 15
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'contact',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ]
        ]);

        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                    ]
                ]
            ]
        ]);
        
        $this->inputFilter = $inputFilter;

        return $this->inputFilter;
    }
}
