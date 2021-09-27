<?php

namespace Zf2User\Form;

use Zend\InputFilter\InputFilter,
    DoctrineModule\Validator\NoObjectExists,
    DoctrineModule\Validator\UniqueObject;

class UserFilter extends InputFilter
{
    private $em = null;

    public function __construct($options = array())
    {
        $this->em = array_key_exists('em', $options) ? $options['em'] : null ;
        $this->id = array_key_exists('id', $options) ? $options['id'] : null ;

        $validator_email = array(
            'name' => 'DoctrineModule\Validator\NoObjectExists',
            'options' => array(
                'object_repository' => $this->getEm()->getRepository('Zf2User\Entity\User'),
                'fields' => 'email',
                'messages' => array( NoObjectExists::ERROR_OBJECT_FOUND => "Correo electrónico ya en uso." )
            ),
        );


        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'notEmptyInvalid' => "E-mail invalido.",
                            'isEmpty' => "Por favor digite un e-mail.",
                        )
                    )
                ),
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'messages' => array(
                            'emailAddressInvalid' => "E-mail invalido.",
                            'emailAddressInvalidFormat' => "Formato de e-mail invalido.",
                            'emailAddressInvalidHostname' => "Hostname e-mail invalido.",
                        )
                    )
                ),
            ),
        ));

        $validator_username = array(
            'name' => 'DoctrineModule\Validator\NoObjectExists',
            'options' => array(
                'object_repository' => $this->getEm()->getRepository('Zf2User\Entity\User'),
                'fields' => 'username',
                'messages' => array( NoObjectExists::ERROR_OBJECT_FOUND => "Este nombre de usuario ya esta en uso." )
            ),
        );

        $this->add(array(
            'name'=>'username',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'notEmptyInvalid' => "Usuario invalido.",
                            'isEmpty' => "Por favor digite un usuario.",
                        )
                    )
                ),
            )
        ));

        if (!$this->id) {
            $this->add(array(
                'name'=>'password',
                'required'=>true,
                'filters' => array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'notEmptyInvalid' => "Contraseña invalida.",
                                'isEmpty' => "Por favor digite una contraseña.",
                            )
                        )
                    ),
                )
            ));

            $this->add(array(
                'name' => 'confirmation',
                'required' => true,
                'filters' => array(
                    array('name'=>'StripTags'),
                    array('name'=>'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'notEmptyInvalid' => "Contraseña invalida.",
                                'isEmpty' => "Por favor digite una contraseña.",
                            )
                        )
                    ),
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'password',
                            'messages' => array(
                                'notSame' => "Contraseña invalida.",
                                'missingToken' => "Por favor digite una contraseña.",
                            )
                        ),
                    ),
                )
            ));
        }

        $this->add(array(
            'name' => 'role',
            'required' => true
        ));
    }
    
    public function getEm(){
        return $this->em;
    }
}
