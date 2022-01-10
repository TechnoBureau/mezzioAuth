<?php

declare(strict_types=1);

namespace TechnoBureau\mezzioAuth\Repository;

use Mezzio\Authentication\Exception;
use Mezzio\Authentication\UserInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

class AuthUserRepositoryFactory
{
    public function __invoke(ContainerInterface $container): AuthUserRepository
    {
        return new AuthUserRepository(
            $container->get($config['entity-manager-class'] ?? EntityManager::class),
            $container->get(EntityManager::class)->getClassMetadata(\TechnoBureau\mezzioAuth\Entity\AuthUser::class)
        );
    }
}