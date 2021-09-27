<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Service;

use Doctrine\ORM\EntityManager,
    Zend\Stdlib\Hydrator,
    Zend\Mail\Transport\Smtp as SmtpTransport,
    Zf2Base\Mail\Mail,
    Zf2Base\Service\AbstractService;

class User extends AbstractService
{
    protected $transport;
    protected $view;

    public function __construct(EntityManager $em, SmtpTransport $transport, $view)
    {
        parent::__construct($em);

        $this->entity = "Zf2User\Entity\User";
        $this->transport = $transport;
        $this->view = $view;
    }

    public function persist(array $data, $id = null)
    {
        if(empty($data['password']))
            unset($data['password']);

        $data['role'] = $this->em->getReference("Zf2Acl\Entity\Role", $data['role']);
        if ($id) {
            $entity = $this->em->getReference($this->entity, $id);
            $entity_perfil = $this->em->getReference("Zf2User\Entity\Perfil", $data['perfil']['id']);

            $hydrator = new Hydrator\ClassMethods();
            $hydrator->hydrate($data, $entity);
            $data['perfil']['user'] = $entity;
            $hydrator->hydrate($data['perfil'], $entity_perfil);
        } else {
            $entity = new $this->entity($data);
            $data['perfil']['user'] = $entity;
            $entity_perfil = new \Zf2User\Entity\Perfil($data['perfil']);
        }

        $this->em->persist($entity);
        $this->em->persist($entity_perfil);
        $this->em->flush();

        if ($entity->getStatus() == 0) {
             $dataEmail = array('email' => $entity->getEmail(), 'activationKey' => $entity->getActivationKey());

             $mail = new Mail($this->transport, $this->view, 'add-user');
             $mail->setSubject('Confirmacion Registro')
                  ->setTo($entity->getEmail())
                  ->setData($dataEmail)
                  ->prepare()
                  ->send();
        }
        return $entity;
    }

    public function activate($key)
    {
        $repo = $this->em->getRepository($this->entity);
        $user = $repo->findOneByActivation($key);
        if($user)
        {
            $repo->setStatus(true);

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        }
    }
}
