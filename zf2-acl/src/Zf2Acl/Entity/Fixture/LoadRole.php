<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Zf2Acl\Entity\Role;

class LoadRole extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
    {
        $role = new Role;
        $role->setName("Visit");
        $manager->persist($role);

        $visit = $manager->getReference('Zf2Acl\Entity\Role',1);

        $role = new Role;
        $role->setName("Client")
            ->setParent($visit)
			->setRedirect("dashboard");
        $manager->persist($role);

        $role = new Role;
        $role->setName("Functionary")
              ->setParent($visit)
        	  ->setRedirect("dashboard");
        $manager->persist($role);

		$functionary = $manager->getReference('Zf2Acl\Entity\Role',3);

        $role = new Role;
        $role->setName("Administrator")
        	  ->setParent($functionary)
              ->setRedirect("dashboard");
        $manager->persist($role);

        $role = new Role;
        $role->setName("Developer")
              ->setDeveloper(1)
              ->setRedirect("dashboard");
        $manager->persist($role);

        $manager->flush();
    }

    public function getOrder() {
        return 3;
    }
}
