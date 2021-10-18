<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests\Resolver;

use Corerely\JsTranslationBundle\Resolver\RequestHeaderLocaleResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestHeaderLocaleResolverTest extends TestCase
{
    /**
     * @dataProvider acceptLanguageProvider
     */
    public function testResolve(?string $expect, string $acceptLanguage)
    {
        $locales = ['en', 'uk'];
        $request = new Request(server: ['HTTP_ACCEPT_LANGUAGE' => $acceptLanguage]);
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $resolver = new RequestHeaderLocaleResolver($requestStack, $locales);

        $this->assertEquals($expect, $resolver->resolve());
    }

    public function acceptLanguageProvider(): array
    {
        return [
            ['uk', 'uk-UA,uk;q=0.9,ru;q=0.8,en-US;q=0.7,en;q=0.6,sv;q=0.5,de;q=0.4,pl;q=0.3'],
            ['en', 'en-GB,en;q=0.9,ru;q=0.8,en-US;q=0.7,en;q=0.6,sv;q=0.5,de;q=0.4,pl;q=0.3'],
            [null, 'fr-CH, fr;q=0.9, ch;q=0.8, de;q=0.7, *;q=0.5'],
        ];
    }

    public function testResolveReturnNullIfNotRequest()
    {
        $locales = ['en', 'uk'];
        $requestStack = new RequestStack();

        $resolver = new RequestHeaderLocaleResolver($requestStack, $locales);

        $this->assertNull($resolver->resolve());
    }
}
