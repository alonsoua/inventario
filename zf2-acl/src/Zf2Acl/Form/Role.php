<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Form;

use Zend\Form\Form;

class Role extends Form
{
    public function __construct($name = null, array $options = null)
    {
        parent::__construct('role');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Nombre Perfil',
            ),
            'options' => array(
                'label' => 'Nombre Perfil',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'layout',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Layout',
            ),
            'options' => array(
                'label' => 'Layout:',
                'label_attributes' => array(
                    'class' => 'control-label'
                ),
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'layout',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Layout',
            ),
            'options' => array(
                'label' => 'Layout',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'redirect',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Redireccionar',
            ),
            'options' => array(
                'label' => 'Redireccionar',
            ),
        ));

        $this->add(array(
            'name' => 'parent',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => "Tipo Perfil",
                'object_manager' => $options['em'],
                'target_class' => 'Zf2Acl\Entity\Role',
                'property' => 'name',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'developer',
            'options' => array(
                'label' => "Super Usuario",
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-success'
            )
        ));
    }

}
