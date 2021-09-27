<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Form;

use Zend\Form\Form;
use Zf2User\Form\PerfilFieldset,
    Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class User extends Form
{
    private $em = null;
    private $id = null;

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->em = $options['em'];
        $this->id = $options['id'];

        $this->setAttribute('method', 'post');
        $this->setAttribute('data-toggle', 'validator');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form')
            ->setInputFilter(new UserFilter($options));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
                'required' => 'required',
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
                'placeholder' => 'Rut',
                'id' => 'username',
            ),
            'options' => array(
                'label' => 'Usuario (Rut)',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Contraseña',
                'id' => 'password',
                'data-minlength' => '6',
                'data-minlength-error' => "La contraseña debe ser mayor a 6 caracteres",
            ),
            'options' => array(
                'label' => 'Contraseña',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'confirmation',
            'attributes' => array(
                'id' => 'confirmation',
                'placeholder' => 'Repetir Contraseña',
                'class' => 'form-control',
                'data-match' => '#password',
                'data-match-error' => "Las contraseñas no coinciden",
            ),
            'options' => array(
                'label' => 'Repetir Contraseña',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'password_clue',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Sugerencia Contraseña',
            ),
            'options' => array(
                'label' => 'Sugerencia Contraseña',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'role',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => "Tipo Perfil",
                'object_manager' => $this->getEm(),
                'target_class' => 'Zf2Acl\Entity\Role',
                'property' => 'name',
                /* @TODO */
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('developer' => 0)
                    ),
                ),
                'empty_option' => 'Por favor, seleccione un tipo de perfil',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'status',
            'options' => array(
                'label' => 'Activar'
            )
        ));

        $usuario_fieldset = new PerfilFieldset('perfil', $options);
        $this->add($usuario_fieldset);

        $this->add(array(
            'type'=>'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value'=>'Guardar',
                'class' => 'btn btn-success'
            )
        ));
    }

    public function getEm(){
        return $this->em;
    }
}
