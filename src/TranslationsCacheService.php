<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle;

use Symfony\Component\Finder\Finder;

final class TranslationsCacheService
{

    public function __construct(private string $cacheDir)
    {
    }

    public function clearCataloguesForLocale(string $locale): void
    {
        $this->clearCacheFiles(sprintf('catalogue.%s*', $locale), 'translations');
    }

    public function clearCacheFiles(string $pattern, string $dir): void
    {
        $cacheDir = sprintf('%s/%s', $this->cacheDir, $dir);

        $finder = (new Finder())
            ->name($pattern)
            ->in($cacheDir)
            ->files();

        foreach ($finder as $file) {
            unlink($file->getPathname());
        }
    }
}
