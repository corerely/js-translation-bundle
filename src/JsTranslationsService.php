<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle;

use Corerely\JsTranslationBundle\Provider\TranslationsProviderInterface;
use Corerely\JsTranslationBundle\Resolver\LocaleResolverInterface;

/**
 * Helper service that helps to retrieve translations for resolved locale and configured domains
 */
final class JsTranslationsService
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
        $locale = $this->getActiveLocale();

        return $this->translationsProvider->get([$locale], $this->domains);
    }

    public function getActiveLocale(): string
    {
        return $this->locale ??= $this->localeResolver->resolve();
    }
}
