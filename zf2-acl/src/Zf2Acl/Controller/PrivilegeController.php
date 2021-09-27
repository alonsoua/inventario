<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Controller;

use Zf2Base\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PrivilegeController extends AbstractActionController
{
    public function __construct()
    {
        $this->entity = "Zf2Acl\Entity\Privilege";
        $this->service = "Zf2Acl\Service\Privilege";
        $this->form = "Zf2Acl\Form\Privilege";
        $this->controller = "privilege";
        $this->route = "acl-all/default";
    }
}
