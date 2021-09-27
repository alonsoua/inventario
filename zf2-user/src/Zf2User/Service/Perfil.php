<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Service;

use Zf2Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;

class Perfil extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = "Zf2User\Entity\Perfil";
    }
}
