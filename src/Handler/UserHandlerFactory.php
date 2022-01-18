<?php

declare(strict_types=1);

namespace TechnoBureau\mezzioAuth\Handler;

use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManager;


use function get_class;

class UserHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        $entityManager = $container->get($config['entity-manager-class'] ?? EntityManager::class);

        return new UserHandler($router, $template,$entityManager);
    }
}