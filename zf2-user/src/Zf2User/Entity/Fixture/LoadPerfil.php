<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Zf2User\Entity\Perfil;

class LoadPerfil extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $dev   = $manager->getReference('Zf2User\Entity\User',1);
        $admin = $manager->getReference('Zf2User\Entity\User',2);
        $boot  = $manager->getReference('Zf2User\Entity\User',3);

        $perfil = new Perfil();
        $perfil->setUser($dev)
               ->setName("Developer")
               ->setDateBirth("14-05-1992");
        $manager->persist($perfil);

        $perfil = new Perfil();
        $perfil->setUser($admin)
               ->setName("Administrator")
               ->setDateBirth("14-05-1992");
        $manager->persist($perfil);

        $perfil = new Perfil();
        $perfil->setUser($boot)
               ->setName("Boot Functionary")
               ->setDateBirth("14-05-1992");
        $manager->persist($perfil);

        $manager->flush();
    }

    public function getOrder() {
        return 8;
    }
}
