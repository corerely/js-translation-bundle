<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests\Resolver;

use Corerely\JsTranslationBundle\Resolver\ChainLocaleResolver;
use Corerely\JsTranslationBundle\Resolver\LocaleResolverInterface;
use PHPUnit\Framework\TestCase;

class ChainLocaleResolverTest extends TestCase
{
    public function testResolveReturnLocaleFromFirstResolverThatReturnSupportedLocale(): void
    {
        $locale = 'en';

        $resolver1 = $this->createMock(LocaleResolverInterface::class);
        $resolver1->expects($this->once())->method('resolve')->willReturn(null);

        $resolver2 = $this->createMock(LocaleResolverInterface::class);
        $resolver2->expects($this->once())->method('resolve')->willReturn($locale);

        $resolver3 = $this->createMock(LocaleResolverInterface::class);
        $resolver3->expects($this->never())->method('resolve');

        $chainResolver = (new ChainLocaleResolver(['en']))->addResolver($resolver1)->addResolver($resolver2)->addResolver($resolver3);

        $this->assertEquals($locale, $chainResolver->resolve());
    }

    public function testResolveThrownExceptionIfNothingResolved(): void
    {
        $resolver = $this->createMock(LocaleResolverInterface::class);
        $resolver->expects($this->once())->method('resolve')->willReturn(null);

        $chainResolver = (new ChainLocaleResolver(['uk']))->addResolver($resolver);

        $this->expectException(\LogicException::class);
        $chainResolver->resolve();
    }

    public function testResolveThrownExceptionIfAllResolvedIsNotSupported(): void
    {
        $resolver1 = $this->createMock(LocaleResolverInterface::class);
        $resolver1->expects($this->once())->method('resolve')->willReturn('uk');

        $resolver2 = $this->createMock(LocaleResolverInterface::class);
        $resolver2->expects($this->once())->method('resolve')->willReturn(null);

        $resolver3 = $this->createMock(LocaleResolverInterface::class);
        $resolver3->expects($this->once())->method('resolve')->willReturn('en');

        $chainResolver = (new ChainLocaleResolver(['sv']))->addResolver($resolver1)->addResolver($resolver2)->addResolver($resolver3);

        $this->expectException(\LogicException::class);
        $chainResolver->resolve();
    }
}
