<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Form;

use Zf2User\Entity\Perfil;
use Zend\Form\Fieldset,
	Zend\InputFilter\InputFilterProviderInterface,
	Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class PerfilFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $em = null;
    private $id = null;

 	public function __construct($name = null, $options = array())
	{
        $this->em = $options['em'];
        $this->id = $options['id'];

		parent::__construct($name);
		$this->setHydrator(new ClassMethodsHydrator(false))
			 ->setObject(new Perfil);

        $this->setLabel('Perfil');

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Nombre y Apellido',
            ),
            'options' => array(
                'label' => 'Nombre y Apellido',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'date_birth',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Fecha Nacimiento',
            ),
            'options' => array(
                'label' => 'Nacimiento',
            ),
        ));

		    $this->add(array(
            'name' => 'localization',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Direccion',
            ),
            'options' => array(
                'label' => 'Direccion',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'obs',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'obs',
                'placeholder' => 'Observaciones',
             ),
            'options' => array(
                'label' => 'Observaciones',
            ),
        ));

        $this->add(array(
            'name' => 'avatar',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'id-input-file',
            ),
            'options' => array(
                'label' => 'Imagen:',
                'multiple' => false,
                'id' => 'avatar',
                'disable_inarray_validator' => true,
            )
        ));
	}

	/**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array();
    }

    public function getEm(){
        return $this->em;
    }
}
