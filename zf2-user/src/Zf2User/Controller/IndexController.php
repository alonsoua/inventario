<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Controller;

use Zend\View\Model\ViewModel;
use Zf2Base\Controller\AbstractActionController;
use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;

class IndexController extends AbstractActionController
{
    public function __construct()
    {
        $this->entity = "Zf2User\Entity\User";
        $this->form = "Zf2User\Form\User";
        $this->service = "Zf2User\Service\User";
        $this->controller = "index";
        $this->route = "user-admin";
    }

    //FORMULARIO INDEX
    public function indexAction()
    {
        $userLog = $this->UserAuthentication()->getIdentity();
        //PREGUNTA SI EL USUARIO ESTA LOGEADO SINO REDIRECCION O CIERRA SESION
        if ($userLog->getRole()->getDeveloper()) {
            $list = $this->getEm()
                ->getRepository($this->entity)
                ->findAll();
        } else {
            $this->redirect()->toRoute('user-auth/default', array('action' => 'logout'));
            $list = $this->getEm()
                 ->getRepository($this->entity)
                 ->findNoDev();
        }

        $page = $this->params()->fromRoute('page');

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
            ->setDefaultItemCountPerPage(20);

        return new ViewModel(array(
            'data'=>$paginator,
            'page'=>$page,
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));
    }

    //FORMULARIO PARA REGISTRAR
    public function registerAction()
    {
        $renderer = $this->serviceLocator->get('Zend\View\Renderer\RendererInterface');
        $renderer->headScript()->appendFile($renderer->basePath() . '/public/js/rut/jquery.Rut.js');
        $renderer->headScript()->appendFile($renderer->basePath() . '/public/js/validador/validator.js');

        //RECEPCIONA ID
        $id = $this->params()->fromRoute('id',0);

        //NUEVO FORMULARIO
        $form = new $this->form('register_user', array('id' => $id, 'em' => $this->getEm()));
        $request = $this->getRequest();

        if($id!=1 && $id!=0){
            $form->get('username')->setAttribute('readonly', 'readonly');
            $form->get('email')->setAttribute('readonly', 'readonly');
        }

        if($id) {
            $repository = $this->getEm()->getRepository($this->entity);
            $entity = $repository->find($this->params()->fromRoute('id',0));
            /* @TODO */
            $userLog = $this->UserAuthentication()->getIdentity();
            if (!$userLog->getRole()->getDeveloper() && $entity->getRole()->getDeveloper()) {
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
            $entity = $entity->toArray();
            unset($entity['password']);
            $form->setData($entity);
        }

        if($request->isPost())
        {
            $form->setData($request->getPost());
            $passInicio  = $request->getPost('password');
            $passConfirm = $request->getPost('confirmation');

            if($passInicio!=$passConfirm){
                    $this->flashMessenger()->addMessage('Verificar Contraseñas');
                    return $this->redirect()->toRoute('user-admin/default',  array('controller' => 'index', 'action' => 'register', 'id' => $id));
            }

            if(empty($passInicio)){
                    $this->flashMessenger()->addMessage('Ingrese una Contraseña');
                    return $this->redirect()->toRoute('user-admin/default',  array('controller' => 'index', 'action' => 'register', 'id' => $id));
            }

            if($form->isValid())
            {
                try {
                    $id = $this->params()->fromRoute('id',$request->getPost('id', 0));
                    $service = $this->getServiceLocator()->get($this->service);
                    if ($service->persist($request->getPost()->toArray(), $id))
                        $this->flashMessenger()->addMessage('Guardado Correctamente!');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addMessage('Error al Guardar!'.$e->getMessage());
                }
                return $this->redirect()->toRoute('user-admin/default');
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'id' => $id,
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));
    }
}
