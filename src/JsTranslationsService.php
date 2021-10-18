<?php
declare(strict_types=1);

namespace Corerely\JsTranslation;

use Corerely\JsTranslation\Provider\TranslationsProviderInterface;
use Corerely\JsTranslation\Resolver\LocaleResolverInterface;

/**
 * Helper service that helps to retrieve translations for resolved locale and configured domains
 */
class JsTranslationsService
{
    private ?string $locale = null;

    public function __construct(
        private TranslationsProviderInterface $translationsProvider,
        private LocaleResolverInterface       $localeResolver,
        private array                         $domains,
    ) {
    }

    public function getTranslationsForActiveLocale(): array
    {
        $locale = $this->localeResolver->resolve();

        return $this->translationsProvider->get([$locale], $this->domains);
    }

    public function getActiveLocale(): string
    {
        return $this->locale ??= $this->localeResolver->resolve();
    }
}
