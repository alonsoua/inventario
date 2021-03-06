<?php
/**
* Class CrudController
*
* @author Jhon Mike Soares <https://github.com/jhonmike>
* @version 1.0
*
* Dependencia Doctrine (https://github.com/doctrine/DoctrineORMModule.git
*/

namespace Zf2Base\Controller;

use Zend\Mvc\Controller\AbstractActionController as ActionController,
    Zend\View\Model\ViewModel,
    Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;

abstract class AbstractActionController extends ActionController
{
    protected $em;
    protected $service;
    protected $entity;
    protected $form;
    protected $route;
    protected $controller;

    public function indexAction()
    {
        $list = $this->getEm()
            ->getRepository($this->entity)
            ->findAll();

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

    public function getAction()
    {
        // pega o ID
        $id = $this->params()->fromRoute('id',0);

        $entity = $this->getEm()
            ->getRepository($this->entity)
            ->findOneById($id);

        return new ViewModel(array(
            'data'=>$entity,
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));
    }

    public function registerAction()
    {
        // pega o ID
        $id = $this->params()->fromRoute('id',0);
        // New formulario
        $form = new $this->form('', array('id' => $id, 'em' => $this->getEm()));
        // request posts
        $request = $this->getRequest();

        // se ID existir da um setData para popular o formulario
        if($id) {
            // com o id efetuar uma busca no banco de dados para popular o form
            $entity = $this->getEm()
                ->getRepository($this->entity)
                ->findOneById($id);
            // popula o form
            $form->setData($entity->toArray());
        }

        // verifica se ahh post
        if($request->isPost())
        {
            // popula o form com os dados do post
            $form->setData($request->getPost());
            // valida os mesmos
            if($form->isValid())
            {
                try {
                    $id = $this->params()->fromRoute('id',$request->getPost('id', 0));
                    $service = $this->getServiceLocator()->get($this->service);
                    if ($service->persist($request->getPost()->toArray(), $id))
                        $this->flashMessenger()->addMessage('Guardado Correctamente!');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addMessage('Lo sentimos, el registro seleccionado no pudo ser guardado!!');
                }

                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'id' => $id
        ));
    }

    public function deleteAction()
    {
        try {
            $service = $this->getServiceLocator()->get($this->service);
            if ($service->delete($this->params()->fromRoute('id',0)))
                $this->flashMessenger()->addMessage('Eliminado correctamente!');

        } catch (\Exception $e) {
            $this->flashMessenger()->addMessage('Lo sentimos, el usuario seleccionado no pudo ser eliminado!');
        }
        return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
    }

    /**
     *
     * @return EntityManager
     */
    protected function getEm()
    {
        if(null === $this->em)
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        return $this->em;
    }
}
