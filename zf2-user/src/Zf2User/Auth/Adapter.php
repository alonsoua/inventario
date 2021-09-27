<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result;

use Doctrine\ORM\EntityManager;

class Adapter implements AdapterInterface
{
    protected $em;
    protected $username;
    protected $password;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function authenticate()
    {
        $repository = $this->em->getRepository("Zf2User\Entity\User");
        $user = $repository->findByUsernameAndPassword($this->getUsername(),$this->getPassword());

        if($user) {
            if ($user->getStatus() == 1) {
                return new Result(Result::SUCCESS, array('user'=>$user), array('OK'));
            } else {
                if ($user->getStatus() == 0) {
                    return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array('Usuario no Activo!'));
                } else {
                    return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array('Usuario bloqueado!'));
                }
            }
        } else
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array('Datos de usuario invalidos!'));
    }
}
