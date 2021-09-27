<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Service;

use Zf2Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Resource extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = "Zf2Acl\Entity\Resource";
    }
}
