<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User;

use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

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

    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach("Zend\Mvc\Controller\AbstractActionController",
                MvcEvent::EVENT_DISPATCH,
                array($this,'validAuthAcl'),100);
    }

    public function validAuthAcl($e)
    {
        $storage = new SessionStorage();
        $auth = new AuthenticationService;
        $auth->setStorage($storage);

        //pega controller e action
        $controller = $e->getTarget();
        $em = $controller->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
        $matchedController = $controller->getEvent()->getRouteMatch()->getParam('controller');
        $matchedAction = $controller->getEvent()->getRouteMatch()->getParam('action', 'index');
        //user logado
        if ($auth->hasIdentity()) {
            $arrayUser = $auth->getIdentity();
            $repository = $em->getRepository("Zf2User\Entity\User");
            $user = $repository->findOneById($arrayUser->getId());
            $role = $user->getRole()->getName();
        } elseif (!$auth->hasIdentity()) {
                $role = 'Visit';
        }
        //acl
        $acl = $controller->getServiceLocator()->get("Zf2Acl\Permissions\Acl");
        if (!$acl->isAllowed($role,$matchedController,$matchedAction)) {
            if($role!='Visit'){
                $url ='error/404';
            }else{
                $url ='/auth/logout';
            }

                $e->getResponse()->setStatusCode(Response::STATUS_CODE_404);
                $e->stopPropagation();

                
                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                return $response;
        }
    }

    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'UserAuthentication' => function ($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $authService = $serviceLocator->get('user_auth_service');
                    $controllerPlugin = new Controller\Plugin\UserAuthentication;
                    $controllerPlugin->setAuthService($authService);
                    return $controllerPlugin;
                },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'UserIdentity' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\UserIdentity;
                    $viewHelper->setAuthService($locator->get('user_auth_service'));
                    return $viewHelper;
                }
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'user_auth_service' => function ($sm) {
                    return new \Zend\Authentication\AuthenticationService();
                },
                'Zf2User\Service\User' => function($sm) {
                    return new Service\User($sm->get('Doctrine\ORM\EntityManager'),
                                            $sm->get('Zf2Base\Mail\Transport'),
                                            $sm->get('View')
                                        );
                },
                'Zf2User\Service\Perfil' => function($sm) {
                    return new Service\Perfil($sm->get('Doctrine\ORM\EntityManager')
                                            );
                },
                'Zf2User\Auth\Adapter' => function($sm) {
                    return new Auth\Adapter($sm->get('Doctrine\ORM\EntityManager'));
                },
            )
        );
    }
}
