<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Provider;

use Symfony\Component\Translation\TranslatorBagInterface;

class TranslationsProvider implements TranslationsProviderInterface
{
    public function __construct(
        private readonly TranslatorBagInterface $translatorBag,
        private readonly string                 $defaultLocale,
    ) {
    }

    public function get(array $locales, array $domains): array
    {

        $translations = [];
        foreach ($locales as $locale) {
            // Collect translations for single locale
            $localeTranslations = $this->getTranslationForLocale($locale, $domains);

            // If this locale is not default, merge translations with default, because translations might be missing
            if ($locale !== $this->defaultLocale) {
                $defaultTranslations = $translations[$this->defaultLocale] ??= $this->getTranslationForLocale(
                    $this->defaultLocale,
                    $domains,
                );

                $localeTranslations = $this->replaceArrayRecursive(
                    $defaultTranslations,
                    $localeTranslations,
                );
            }

            $translations[$locale] = $localeTranslations;
        }

        // Remove default translations if it was not needed, but added while population
        if (! in_array($this->defaultLocale, $locales, true)) {
            unset($translations[$this->defaultLocale]);
        }

        return $translations;
    }

    private function getTranslationForLocale(string $locale, array $domains): array
    {
        $translations = [];
        foreach ($domains as $domain) {
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
                    $nestedTranslation,
                );
            }
        }

        return $translations;
    }

    private function replaceArrayRecursive(array $array, array $replacements): array
    {
        foreach ($replacements as $replacementKey => $replacement) {
            if ($replacement) {
                if (is_array($replacement) && is_array($array[$replacementKey] ?? null)) {
                    $array[$replacementKey] = $this->replaceArrayRecursive($array[$replacementKey], $replacement);
                } else {
                    $array[$replacementKey] = $replacement;
                }
            }
        }

        return $array;
    }
}
