<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Form;

use Zend\Form\Form;

class Resource extends Form
{
    public function __construct($name = null, array $options = null)
    {
        parent::__construct('resource');

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
                'placeholder' => 'Nombre Controlador',
            ),
            'options' => array(
                'label' => 'Nombre Controlador',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Guardar Controlador',
                'class' => 'btn btn-success'
            )
        ));
    }

}
