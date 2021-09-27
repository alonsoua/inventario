<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Acl extends AbstractHelper
{
    protected $acl;

    /**
     * __invoke
     *
     * @access public
     */
    public function __invoke()
    {
        return $this->acl;
    }

    /**
     * Get acl.
     *
     * @return Acl
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * Set acl.
     *
     * @param Acl $acl
     * @return \Zf2Acl\View\Helper\Acl
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;
        return $this;
    }
}
