<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests\Resolver;

use Corerely\JsTranslationBundle\Resolver\CookieLocaleResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CookieLocaleResolverTest extends TestCase
{
    public function testResolve()
    {
        $request = new Request(cookies: ['locale' => 'uk']);
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $resolver = new CookieLocaleResolver($requestStack);

        $this->assertEquals('uk', $resolver->resolve());
    }

    public function testResolveReturnNullIfNoCookie()
    {
        $request = new Request();
        $requestStack = new RequestStack();
        $requestStack->push($request);

        $resolver = new CookieLocaleResolver($requestStack);

        $this->assertNull($resolver->resolve());
    }

    public function testResolveReturnNullIfRequest()
    {
        $locales = ['sv', 'uk'];
        $requestStack = new RequestStack();

        $resolver = new CookieLocaleResolver($requestStack);

        $this->assertNull($resolver->resolve());
    }
}
