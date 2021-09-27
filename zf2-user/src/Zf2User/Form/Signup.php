<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Form;

use Zend\Form\Form;

class Signup extends Form
{
    private $em = null;

    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $this->em = $options['em'];

        $this->setAttribute('method', 'post')
             ->setInputFilter(new SignupFilter($options))
             ->setAttribute('class', 'form-signup');

        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'username',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Usuario',
            ),
            'options' => array(
                'label' => 'Usuario',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'attributes' => array(
                'placeholder' => 'Password',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Password',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'confirmation',
            'attributes' => array(
                'placeholder' => 'Confirmación Password',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Confirmación Password:',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'terms',
            'options' => array(
                'label' => 'Términos',
                'use_hidden_element' => true
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Register',
                'class' => 'btn btn-primary btn-lg col-xs-12'
            )
        ));
    }

    public function getEm(){
        return $this->em;
    }
}
