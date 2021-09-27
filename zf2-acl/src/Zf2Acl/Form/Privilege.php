<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Form;

use Zend\Form\Form;

class Privilege extends Form
{
    public function __construct($name = null, array $options = null)
    {
        parent::__construct('privilege');

        $this->setInputFilter(new PrivilegeFilter())
             ->setAttribute('method', 'post');

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Accion',
            ),
            'options' => array(
                'label' => 'Accion',
            ),
        ));

        $this->add(array(
            'name' => 'role',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => "Perfil",
                'object_manager' => $options['em'],
                'target_class' => 'Zf2Acl\Entity\Role',
                'property' => 'name',
            ),
        ));

        $this->add(array(
            'name' => 'resource',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => "Controlador",
                'object_manager' => $options['em'],
                'target_class' => 'Zf2Acl\Entity\Resource',
                'property' => 'name',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Guardar',
                'class' => 'btn btn-primary'
            )
        ));
    }
}
