<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2Acl\Controller;

use Zf2Base\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ResourceController extends AbstractActionController
{
    public function __construct()
    {
        $this->entity = "Zf2Acl\Entity\Resource";
        $this->service = "Zf2Acl\Service\Resource";
        $this->form = "Zf2Acl\Form\Resource";
        $this->controller = "resource";
        $this->route = "acl-all/default";
    }
}
