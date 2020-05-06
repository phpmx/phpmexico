<?php

namespace App\Twig;

use Gravatar\Gravatar;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GravatarExtension extends AbstractExtension
{
    private $gravatar;

    public function __construct(Gravatar $gravatar)
    {
        $this->gravatar = $gravatar;
    }

    public function gravatarLink(string $email, int $size): string
    {
        return $this->gravatar->avatar($email, ['s' => $size]);
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('gravatar', [$this, 'gravatarLink']),
        ];
    }
}
