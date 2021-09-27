<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractRestfulController as RestfulController;
use Zend\View\Model\JsonModel;
use Zend\Stdlib\Hydrator;

abstract class AbstractRestfulController extends RestfulController 
{
	protected $em;
	protected $entity;
	protected $service;

	public function getList() 
	{
		$data = $this->params()->fromQuery();

		if (count($data) > 0) 
			$list = $this->getEm()->getRepository($this->entity)->findBy($data);
		else
			$list = $this->getEm()->getRepository($this->entity)->findAll();

		foreach ($list as $key => $entity) {
			$list[$key] = $entity->toArray();
		}

		return new JsonModel(array(
			'data' => $list
		));
	}

	public function get($id) 
	{
		$entity = $this->getEm()
			->getRepository($this->entity)
			->findOneById($id);

		return new JsonModel($entity->toArray());
	}

	public function create($data) 
	{
		try {
            $service = $this->getServiceLocator()->get($this->service);
            $entity = $service->persist($data);
            return new JsonModel(array(
				'id' => $entity->getId(),
			));
        } catch (\Exception $e) {
            return new JsonModel(array(
				'error' => $e->getMessage(),
			));
        }
	}

	public function update($id, $data) 
	{
		try {
            $service = $this->getServiceLocator()->get($this->service);
            $entity = $service->persist($data, $id);
            return new JsonModel(array(
				'id' => $entity->getId(),
			));
        } catch (\Exception $e) {
            return new JsonModel(array(
				'error' => $e->getMessage(),
			));
        }
	}

	public function delete($id) 
	{
		try {
            $service = $this->getServiceLocator()->get($this->service);
            $service->delete($id);
            return new JsonModel(array(
				'data' => 'deleted',
			));
        } catch (\Exception $e) {
            return new JsonModel(array(
				'error' => $e->getMessage(),
			));
        }
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