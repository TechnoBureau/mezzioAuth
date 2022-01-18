<?php

declare(strict_types=1);

namespace TechnoBureau\mezzioAuth\Handler;

use Laminas\Diactoros\Response\HtmlResponse;

use Mezzio\Router;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

use TechnoBureau\mezzioAuth\Entity\AuthGroup;

class UserHandler extends \Doctrine\ORM\EntityRepository implements RequestHandlerInterface
{

    /** @var Router\RouterInterface */
    private $router;

    /** @var null|TemplateRendererInterface */
    private $template;

    /** @var EntityManager */
    protected $_em;

    public function __construct(
        Router\RouterInterface $router,
        ?TemplateRendererInterface $template = null,
        EntityManagerInterface $em,
    ) {
        $this->_em = $em;
        $this->router        = $router;
        $this->template      = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
    // $GroupRepo = $this->_em->getRepository(\TechnoBureau\mezzioAuth\Entity\AuthUser::class);
    // $data = $GroupRepo->findOneBy(array('groups' => ['1']));

    $GroupRepo = $this->_em->getRepository(\TechnoBureau\mezzioAuth\Entity\AuthGroup::class);
    $data = $GroupRepo->findOneBy(array('id' => ['1']));

        return new HtmlResponse($this->template->render('user::index',[
            'data' => $data,
            ] )
        );
    }
}
