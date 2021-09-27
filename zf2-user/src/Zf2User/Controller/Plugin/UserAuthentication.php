<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserAuthentication extends AbstractPlugin
{
    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Proxy convenience method
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }

    /**
     * Proxy convenience method
     *
     * @access public
     * @return \Zf2User\Entity\User
     */
    public function getIdentity()
    {
        return $this->getAuthService()->getIdentity();
    }

    /**
     * Get authService.
     *
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Set authService.
     *
     * @param AuthenticationService $authService
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }

}
