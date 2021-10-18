<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Resolver;

abstract class AbstractResolver implements LocaleResolverInterface
{

    public function __construct(private array $locales)
    {
    }

    public function resolve(): ?string
    {
        $locale = $this->doResolver();
        if (null !== $locale && $this->supportLocale($locale)) {
            return $locale;
        }

        return null;
    }

    protected function supportLocale(string $locale): bool
    {
        return in_array($locale, $this->locales, true);
    }

    abstract protected function doResolver(): ?string;
}
