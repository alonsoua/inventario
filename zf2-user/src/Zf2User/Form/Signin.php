<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Form;

use Zend\Form\Form;

class Signin extends Form
{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);

        $this->setAttribute('method', 'post')
             ->setInputFilter(new SigninFilter())
             ->setAttribute('class', 'form-signin');

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'username',
            'attributes' => array(
                'class' => 'form-control input-lg',
                'placeholder' => 'Usuario',
                'id' => 'username',
            ),
            'options' => array(
                'label' => 'Usuario',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'attributes' => array(
                'class' => 'form-control input-lg',
                'placeholder' => 'Password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'rememberme',
            'attributes' => array(
                'id' => 'rememberme',
            ),
            'options' => array(
                'label' => 'Recordar'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value'=>'Ingresar',
                'class' => 'btn btn-lg btn-success btn-block'
            )
        ));
    }
}
