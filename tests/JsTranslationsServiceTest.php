<?php
declare(strict_types=1);

namespace Corerely\JsTranslations\Tests;

use Corerely\JsTranslation\JsTranslationsService;
use Corerely\JsTranslation\Provider\TranslationsProviderInterface;
use Corerely\JsTranslation\Resolver\LocaleResolverInterface;
use PHPUnit\Framework\TestCase;

class JsTranslationsServiceTest extends TestCase
{
    public function testGetActiveLocaleCalledOnlyOnce()
    {
        $mockedLocaleResolver = $this->createMock(LocaleResolverInterface::class);
        $mockedLocaleResolver->expects($this->once())->method('resolve')->willReturn('en');

        $service = new JsTranslationsService(
            $this->createMock(TranslationsProviderInterface::class),
            $mockedLocaleResolver,
            ['app']
        );

        $service->getActiveLocale();
        $this->assertEquals('en', $service->getActiveLocale());
    }
}
