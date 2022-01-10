<?php

declare(strict_types=1);

namespace TechnoBureau\mezzioAuth\Handler;

use TechnoBureau\mezzioAuth\Form\LoginForm;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Csrf\CsrfMiddleware;
use Mezzio\Flash\FlashMessageMiddleware;
use Mezzio\Session\SessionMiddleware;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginPageHandler implements MiddlewareInterface
{
    /** @var TemplateRendererInterface */
    private $template;
    /** @var int */
    private $rememberMeSeconds;

    public function __construct(TemplateRendererInterface $template, int $rememberMeSeconds)
    {
        $this->template          = $template;
        $this->rememberMeSeconds = $rememberMeSeconds;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $guard     = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
        $loginForm = new LoginForm($guard);

        /** @var array $prg */
        $prg = $request->getParsedBody();
        if ($prg) {
            $loginForm->setData($prg);
            if ($loginForm->isValid()) {
                $response = $handler->handle($request);

                $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
                if ($response->getStatusCode() !== 302) {
                    if ((int) $prg['rememberme'] === 1) {
                        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
                        $session->persistSessionFor($this->rememberMeSeconds);
                    }
                    $flashMessages->flash('message', 'You are succesfully authenticated');
                    return new RedirectResponse('/');
                }

                $flashMessages->flash('message', 'Login Failure, please try again');
                return $response;
            }
        }

        $token = $guard->generateToken();
        return new HtmlResponse(
            $this->template->render('user::login', [
                'form'  => $loginForm,
                'token' => $token,
            ])
        );
    }
}
