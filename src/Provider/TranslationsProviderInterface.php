<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Provider;

interface TranslationsProviderInterface
{
    /**
     * Return array of translations for given locales on configured domains
     */
    public function get(array $locales): array;
}
