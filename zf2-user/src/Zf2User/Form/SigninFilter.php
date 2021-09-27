<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Form;

use Zend\InputFilter\InputFilter;

class SigninFilter extends InputFilter
{
    public function __construct()
    {
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
                            'notEmptyInvalid' => "Datos Invalido.",
                            'isEmpty' => "Por favor digite un usuario.",
                        )
                    )
                ),
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
                            'notEmptyInvalid' => "Datos Invalido",
                            'isEmpty' => "Por favor digite password.",
                        )
                    )
                ),
            )
        ));

        $this->add(array(
            'name'=>'rememberme',
            'required'=>false,
        ));
    }
}
