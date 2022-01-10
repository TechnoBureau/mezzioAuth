<?php

declare(strict_types=1);

namespace TechnoBureau\mezzioAuth\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Mezzio\Authentication\UserInterface;
use Mezzio\Session\Session;

use function current;

class GetDetails extends AbstractHelper
{
    use SessionTrait;

    public function __invoke(): array
    {
        $session     = new Session($this->getSession());
        $hasLoggedIn = $session->has(UserInterface::class);

        if (! $hasLoggedIn) {
            return null;
        }
        return current($session->get(UserInterface::class)['details']);
    }
}
