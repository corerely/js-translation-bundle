<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests;

use Corerely\JsTranslationBundle\TranslationsCacheService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BundleInitializationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return CorerelyJsTranslationKernel::class;
    }

    private ContainerInterface $testContainer;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $this->testContainer = self::getContainer();
    }

    public function testCanGetTranslationsCacheService(): void
    {
        $this->assertTrue($this->testContainer->has(TranslationsCacheService::class));

        $service = $this->testContainer->get(TranslationsCacheService::class);
        $this->assertInstanceOf(TranslationsCacheService::class, $service);
    }
}
