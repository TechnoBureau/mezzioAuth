<?php

namespace TechnoBureau\mezzioAuth\Repository;

use TechnoBureau\mezzioAuth\Entity\AuthUser;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface as MezzioAuthInterface;

class AuthUserRepository extends \Doctrine\ORM\EntityRepository
{
  public function authenticate(string $credential, string $password = null): ?UserInterface
    {
        /** @var ?AuthUser $user */
        $user = $this->findOneBy(['email' => $credential,'isActive' => TRUE]);

        if ($user === null) {
            return null;
        }

        if (password_verify($password, $user->getPassword())) {
            return $user;
        }

        return null;
      }
}