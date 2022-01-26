<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests;

use Corerely\JsTranslationBundle\TranslationsCacheService;
use PHPUnit\Framework\TestCase;

class TranslationsCacheServiceTest extends TestCase
{
    private array $cleanFiles = [];

    public function testClearCataloguesForLocale()
    {
        $file1 = __DIR__ . '/fixtures/var/translations/catalogue.en.8Fea9HX.php';
        $file2 = __DIR__ . '/fixtures/var/translations/catalogue.en.8Fea9HX.php.meta';

        array_push($this->cleanFiles, $file1, $file2);

        file_put_contents($file1, '');
        file_put_contents($file2, '');

        $this->assertTrue(file_exists($file1));
        $this->assertTrue(file_exists($file2));

        $cacheService = new TranslationsCacheService(__DIR__ . '/fixtures/var');
        $cacheService->clearCataloguesForLocale('en');

        $this->assertFalse(file_exists($file1));
        $this->assertFalse(file_exists($file2));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        foreach ($this->cleanFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
