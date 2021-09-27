<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Form;

use Zend\InputFilter\InputFilter;
use DoctrineModule\Validator\NoObjectExists,
    DoctrineModule\Validator\UniqueObject;

class SignupFilter extends InputFilter
{
    private $em = null;

    public function __construct($options = array())
    {
        $this->em = array_key_exists('em', $options) ? $options['em'] : null ;

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
                array(
                    'name' => 'DoctrineModule\Validator\NoObjectExists',
                    'options' => array(
                        'object_repository' => $this->getEm()->getRepository('Zf2User\Entity\User'),
                        'fields' => 'username',
                        'messages' => array( NoObjectExists::ERROR_OBJECT_FOUND => "Este nombre de usuario esta en uso." )
                    ),
                )
            )
        ));

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
                            'isEmpty' => "Por favor digite uma contraseña.",
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
                            'isEmpty' => "Por favor digite uma contraseña.",
                        )
                    )
                ),
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                        'messages' => array(
                            'notSame' => "Contraseña invalida.",
                            'missingToken' => "Por favor digite uma contraseña.",
                        )
                    ),
                ),
            )
        ));

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
                            'emailAddressInvalid' => "E-mail inválido.",
                            'emailAddressInvalidFormat' => "Formato de e-mail invalido.",
                            'emailAddressInvalidHostname' => "Hostname de e-mail invalida.",
                        )
                    )
                ),
                array(
                    'name' => 'DoctrineModule\Validator\NoObjectExists',
                    'options' => array(
                        'object_repository' => $this->getEm()->getRepository('Zf2User\Entity\User'),
                        'fields' => 'email',
                        'messages' => array( NoObjectExists::ERROR_OBJECT_FOUND => "Este e-mail esta en uso." )
                    ),
                )
            ),
        ));

        $this->add(array(
            'name'=>'terms',
            'required'=>true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => "Debe aceptar los términos.",
                        )
                    )
                ),
            )
        ));
    }

    private function getEm(){
        return $this->em;
    }
}
