<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Provider;

use Symfony\Component\Translation\TranslatorBagInterface;

class TranslationsProvider implements TranslationsProviderInterface
{
    public function __construct(
        private TranslatorBagInterface $translatorBag,
        private array                  $domains,
        private string                 $defaultLocale,
    ) {
    }

    public function get(array $locales): array
    {

        $translations = [];
        foreach ($locales as $locale) {
            // Collect translations for single locale
            $localeTranslations = $this->getTranslationForLocale($locale);

            // If this locale is not default, merge translations with default, because translations might be missing
            if ($locale !== $this->defaultLocale) {
                $defaultTranslations = $translations[$this->defaultLocale] ??= $this->getTranslationForLocale($this->defaultLocale);

                $localeTranslations = array_replace_recursive(
                    $defaultTranslations,
                    $localeTranslations
                );
            }

            $translations[$locale] = $localeTranslations;
        }

        // Remove default translations if it was not needed, but added while population
        if (!in_array($this->defaultLocale, $locales, true)) {
            unset($translations[$this->defaultLocale]);
        }

        return $translations;
    }

    private function getTranslationForLocale(string $locale): array
    {
        $translations = [];
        foreach ($this->domains as $domain) {
            $domainTranslations = $this->translatorBag->getCatalogue($locale)->all($domain);

            foreach ($domainTranslations as $key => $translation) {
                // We receive translation as 'nested.keys.some_key' => 'label'
                // Need to convert it to nested array [nested => [keys => [some_key => 'label']]]
                $keyParts = array_reverse(explode('.', $key));
                $nestedTranslation = array_reduce($keyParts, function (string|array $acc, string $key) {
                    return [$key => $acc];
                }, $translation);

                $translations[$domain] = array_merge_recursive(
                    $translations[$domain] ?? [],
                    $nestedTranslation
                );
            }
        }

        return $translations;
    }
}
