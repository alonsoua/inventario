<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Service;

use Zf2Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Privilege extends AbstractService
{
	public function __construct(\Doctrine\ORM\EntityManager $em)
	{
		parent::__construct($em);
		$this->entity = "Zf2Acl\Entity\Privilege";
	}

	public function persist(array $data, $id = null)
	{
		$data['role'] = $this->em->getReference('Zf2Acl\Entity\Role', $data['role']);
		$data['resource'] = $this->em->getReference('Zf2Acl\Entity\Resource', $data['resource']);

		return parent::persist($data, $id);
	}
}
