<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class CookieLocaleResolver implements LocaleResolverInterface
{
    public const LOCALE_COOKIE_NAME = 'locale';

    private ?Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function resolve(): ?string
    {
        return $this->request?->cookies->get(self::LOCALE_COOKIE_NAME);
    }
}
