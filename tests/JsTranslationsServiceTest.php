<?php
declare(strict_types=1);

namespace Corerely\JsTranslations\Tests;

use Corerely\JsTranslationBundle\JsTranslationsService;
use Corerely\JsTranslationBundle\Provider\TranslationsProviderInterface;
use Corerely\JsTranslationBundle\Resolver\LocaleResolverInterface;
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
