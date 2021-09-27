<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Zf2Acl\Entity\Privilege;

class LoadPrivilege extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $visit       = $manager->getReference('Zf2Acl\Entity\Role',1);
        $client      = $manager->getReference('Zf2Acl\Entity\Role',2);
        $functionary = $manager->getReference('Zf2Acl\Entity\Role',3);
        $admin       = $manager->getReference('Zf2Acl\Entity\Role',4);
        $developer   = $manager->getReference('Zf2Acl\Entity\Role',5);

        $aclRole      = $manager->getReference('Zf2Acl\Entity\Resource',1);
        $aclResource  = $manager->getReference('Zf2Acl\Entity\Resource',2);
        $aclPrivi     = $manager->getReference('Zf2Acl\Entity\Resource',3);
        $application  = $manager->getReference('Zf2Acl\Entity\Resource',4);
        $auth         = $manager->getReference('Zf2Acl\Entity\Resource',5);
        $user         = $manager->getReference('Zf2Acl\Entity\Resource',6);

        // Visitante
        $privilege = new Privilege;
        $privilege->setName("All")
                  ->setRole($visit)
                  ->setResource($auth);
        $manager->persist($privilege);

        $privilege = new Privilege;
        $privilege->setName("index")
                  ->setRole($visit)
                  ->setResource($application);
        $manager->persist($privilege);

        // Cliente
        $privilege = new Privilege;
        $privilege->setName("client")
                  ->setRole($client)
                  ->setResource($application);
        $manager->persist($privilege);
        // Cliente FIM

        // Funcionario
        $privilege = new Privilege;
        $privilege->setName("admin")
                  ->setRole($functionary)
                  ->setResource($application);
        $manager->persist($privilege);
        // Funcionario FIm

        // Admin
        $privilege = new Privilege;
        $privilege->setName("All")
                  ->setRole($admin)
                  ->setResource($user);
        $manager->persist($privilege);
        // Admin fim

        $manager->flush();
    }

    public function getOrder() {
        return 5;
    }
}
