<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests\Resolver;

use Corerely\JsTranslationBundle\Resolver\DefaultLocaleResolver;
use PHPUnit\Framework\TestCase;

class DefaultLocaleResolverTest extends TestCase
{
    public function testResolveReturnDefaultLocale(): void
    {
        $resolver = new DefaultLocaleResolver('uk');

        $this->assertEquals('uk', $resolver->resolve());
    }
}
