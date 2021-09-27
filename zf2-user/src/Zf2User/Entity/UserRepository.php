<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
	public function findByUsernameAndPassword($username = '', $password = '')
	{
		$user = $this->findOneByUsername($username);
		if ($user)
		{
			$hashPassword = $user->encryptPassword($password);
			if ($hashPassword == $user->getPassword())
				return $user;
			else
				return false;
		} else {
			return false;
		}
	}

	public function findOneByActivation($key)
	{
		$activacion = $this->findOneByActivationKey($key);
		if ($activacion)
		{
			return true;
		} else {
			return false;
		}
	}

	/* @TODO */
	public function findNoDev()
	{
		$users = $this->findAll();
		$list = array();
		foreach ($users as $user) {
			if (!$user->getRole()->getDeveloper())
				$list[] = $user;
		}
		return $list;
	}
}
