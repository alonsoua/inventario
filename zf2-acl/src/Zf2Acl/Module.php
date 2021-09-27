<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
	public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'Acl' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\Acl;
                    $viewHelper->setAcl($locator->get("Zf2Acl\Permissions\Acl"));
                    return $viewHelper;
                }
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zf2Acl\Service\Role' => function($sm){
                    return new Service\Role($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'Zf2Acl\Service\Resource' => function($sm){
                    return new Service\Resource($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'Zf2Acl\Service\Privilege' => function($sm){
                    return new Service\Privilege($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'Zf2Acl\Permissions\Acl' => function($sm)
                {
                    $em = $sm->get('Doctrine\ORM\EntityManager');

                    $repoRole = $em->getRepository("Zf2Acl\Entity\Role");
                    $roles = $repoRole->findAll();

                    $repoResource = $em->getRepository("Zf2Acl\Entity\Resource");
                    $resources = $repoResource->findAll();

                    $repoPrivilege = $em->getRepository("Zf2Acl\Entity\Privilege");
                    $privilege = $repoPrivilege->findAll();

                    return new Permissions\Acl($roles,$resources,$privilege);
                }
            )
        );
    }
}
