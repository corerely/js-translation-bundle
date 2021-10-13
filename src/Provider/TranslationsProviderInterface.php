<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Provider;

interface TranslationsProviderInterface
{
    /**
     * Return array of translations for given locales and domains
     */
    public function get(array $locales, array $domains): array;
}
