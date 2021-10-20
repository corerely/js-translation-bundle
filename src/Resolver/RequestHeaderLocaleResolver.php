<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class RequestHeaderLocaleResolver implements LocaleResolverInterface
{
    private ?Request $request;

    public function __construct(RequestStack $requestStack, private array $locales)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function resolve(): ?string
    {
        $languages = $this->request?->getLanguages() ?? [];
        foreach ($languages as $language) {
            [$locale] = explode('_', $language);

            // Check if resolved locale is supported
            if (in_array($locale, $this->locales, true)) {
                return $locale;
            }
        }

        return null;
    }
}
