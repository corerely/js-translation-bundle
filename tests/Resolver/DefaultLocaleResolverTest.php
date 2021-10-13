<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Tests\Resolver;

use Corerely\JsTranslation\Resolver\DefaultLocaleResolver;
use PHPUnit\Framework\TestCase;

class DefaultLocaleResolverTest extends TestCase
{
    public function testResolveReturnDefaultLocale()
    {
        $resolver = new DefaultLocaleResolver('uk');

        $this->assertEquals('uk', $resolver->resolve());
    }
}
