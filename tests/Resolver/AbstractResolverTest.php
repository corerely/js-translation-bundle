<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Tests\Resolver;

use Corerely\JsTranslation\Resolver\AbstractResolver;
use PHPUnit\Framework\TestCase;

class AbstractResolverTest extends TestCase
{
    public function testResolveReturnNullIfReturnedLocaleIsNotSupported()
    {
        $locales = ['sv', 'uk'];

        $resolver = new class($locales) extends AbstractResolver {
            protected function doResolver(): ?string
            {
                return 'en';
            }
        };

        $this->assertNull($resolver->resolve());
    }

    public function testResolveReturnResolvedLocaleIfSupported()
    {
        $locales = ['sv', 'uk'];

        $resolver = new class($locales) extends AbstractResolver {
            protected function doResolver(): ?string
            {
                return 'uk';
            }
        };

        $this->assertEquals('uk', $resolver->resolve());
    }

    public function testResolveReturnNullIfNotResolved()
    {
        $locales = ['sv', 'uk'];

        $resolver = new class($locales) extends AbstractResolver {
            protected function doResolver(): ?string
            {
                return null;
            }
        };

        $this->assertNull($resolver->resolve());
    }
}
