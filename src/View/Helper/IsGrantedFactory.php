<?php

declare(strict_types=1);

namespace TechnoBureau\mezzioAuth\View\Helper;

use Laminas\View\HelperPluginManager;
use Mezzio\Authorization\Acl\LaminasAcl;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;

class IsGrantedFactory
{
    public function __invoke(ContainerInterface $container): IsGranted
    {
        $acl                 = $container->get(LaminasAcl::class);
        $helperPluginManager = $container->get(HelperPluginManager::class);
        $getRole             = $helperPluginManager->get('getRole');
        $url                 = $helperPluginManager->get('url');
        $router              = $container->get(RouterInterface::class);

        return new IsGranted($acl, $getRole, $url, $router);
    }
}
