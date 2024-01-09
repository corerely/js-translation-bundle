<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Resolver;

final readonly class DefaultLocaleResolver implements LocaleResolverInterface
{

    public function __construct(private string $defaultLocale)
    {
    }

    public function resolve(): ?string
    {
        return $this->defaultLocale;
    }
}
