<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Tests\Resolver;

use Corerely\JsTranslation\Resolver\CookieLocaleResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CookieLocaleResolverTest extends TestCase
{
    public function testResolve()
    {
        $locales = ['sv', 'uk'];
        $request = new Request(cookies: [CookieLocaleResolver::LOCALE_COOKIE_NAME => 'uk']);
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $resolver = new CookieLocaleResolver($requestStack, $locales);

        $this->assertEquals('uk', $resolver->resolve());
    }

    public function testResolveReturnNullIfNoCookie()
    {
        $locales = ['sv', 'uk'];
        $request = new Request();
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $resolver = new CookieLocaleResolver($requestStack, $locales);

        $this->assertNull($resolver->resolve());
    }

    public function testResolveReturnNullIfRequest()
    {
        $locales = ['sv', 'uk'];
        $requestStack = new RequestStack();

        $resolver = new CookieLocaleResolver($requestStack, $locales);

        $this->assertNull($resolver->resolve());
    }
}
