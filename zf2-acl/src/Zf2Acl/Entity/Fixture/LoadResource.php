<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Zf2Acl\Entity\Resource;

class LoadResource extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /*id = 1*/
        $resource = new Resource;
        $resource->setName("Zf2Acl\Controller\Role");
        $manager->persist($resource);

        /*id = 2*/
        $resource = new Resource;
        $resource->setName("Zf2Acl\Controller\Resource");
        $manager->persist($resource);

        /*id = 3*/
        $resource = new Resource;
        $resource->setName("Zf2Acl\Controller\Privilege");
        $manager->persist($resource);

        /*id = 4*/
        $resource = new Resource;
        $resource->setName("Application\Controller\Index");
        $manager->persist($resource);

        /*id = 5*/
        $resource = new Resource;
        $resource->setName("Zf2User\Controller\Auth");
        $manager->persist($resource);

        /*id = 6*/
        $resource = new Resource;
        $resource->setName("Zf2User\Controller\Index");
        $manager->persist($resource);

        $manager->flush();
    }

    public function getOrder() {
        return 4;
    }
}
