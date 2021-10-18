<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Resolver;

interface LocaleResolverInterface
{
    public function resolve(): ?string;
}
