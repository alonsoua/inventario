<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Controller;

use Zf2Base\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractActionController
{
    public function __construct()
    {
        $this->entity = "Zf2Acl\Entity\Role";
        $this->service = "Zf2Acl\Service\Role";
        $this->form = "Zf2Acl\Form\Role";
        $this->controller = "role";
        $this->route = "acl-all/default";
    }
}
