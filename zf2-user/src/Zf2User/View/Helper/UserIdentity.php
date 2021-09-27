<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class UserIdentity extends AbstractHelper {

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * __invoke
     *
     * @access public
     * @return \Zf2User\Entity\User
     */
    public function __invoke()
    {
        if ($this->getAuthService()->hasIdentity()) {
            return $this->getAuthService()->getIdentity();
        } else {
            return false;
        }
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
     * @return \Zf2User\View\Helper\UserIdentity
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }
}
