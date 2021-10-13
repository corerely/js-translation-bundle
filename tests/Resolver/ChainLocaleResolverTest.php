<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Tests\Resolver;

use Corerely\JsTranslation\Resolver\ChainLocaleResolver;
use Corerely\JsTranslation\Resolver\LocaleResolverInterface;
use PHPUnit\Framework\TestCase;

class ChainLocaleResolverTest extends TestCase
{
    public function testResolveReturnLocaleFromFirstResolverThatReturnsTruthyValue()
    {
        $locale = 'en';

        $resolver1 = $this->createMock(LocaleResolverInterface::class);
        $resolver1->expects($this->once())->method('resolve')->willReturn(null);

        $resolver2 = $this->createMock(LocaleResolverInterface::class);
        $resolver2->expects($this->once())->method('resolve')->willReturn($locale);

        $resolver3 = $this->createMock(LocaleResolverInterface::class);
        $resolver3->expects($this->never())->method('resolve');

        $chainResolver = (new ChainLocaleResolver())->addResolver($resolver1)->addResolver($resolver2)->addResolver($resolver3);

        $this->assertEquals($locale, $chainResolver->resolve());
    }

    public function testResolveThrownExceptionIfNothingResolved()
    {
        $resolver = $this->createMock(LocaleResolverInterface::class);
        $resolver->expects($this->once())->method('resolve')->willReturn(null);

        $chainResolver = (new ChainLocaleResolver())->addResolver($resolver);

        $this->expectException(\LogicException::class);
        $chainResolver->resolve();
    }
}
