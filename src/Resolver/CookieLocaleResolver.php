<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class CookieLocaleResolver extends AbstractResolver
{
    public const LOCALE_COOKIE_NAME = 'locale';

    private ?Request $request;

    public function __construct(RequestStack $requestStack, array $locales)
    {
        parent::__construct($locales);

        $this->request = $requestStack->getCurrentRequest();
    }

    protected function doResolver(): ?string
    {
        return $this->request?->cookies->get(self::LOCALE_COOKIE_NAME);
    }
}
