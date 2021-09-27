<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Form;

use Zend\InputFilter\InputFilter;

class PrivilegeFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'=>'name',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array('name'=>'NotEmpty')
            )
        ));

        $this->add(array(
            'name'=>'role',
            'required'=>true,
            'validators' => array(
                array('name'=>'NotEmpty')
            )
        ));

        $this->add(array(
            'name'=>'resource',
            'required'=>true,
            'validators' => array(
                array('name'=>'NotEmpty')
            )
        ));
    }

}
