<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestHeaderLocaleResolver extends AbstractResolver
{
    private ?Request $request;

    public function __construct(RequestStack $requestStack, array $locales)
    {
        parent::__construct($locales);

        $this->request = $requestStack->getCurrentRequest();
    }

    protected function doResolver(): ?string
    {
        $languages = $this->request?->getLanguages() ?? [];
        foreach ($languages as $language) {
            [$locale] = explode('_', $language);

            // Check if resolved locale is supported
            if ($this->supportLocale($locale)) {
                return $locale;
            }
        }

        return null;
    }
}
