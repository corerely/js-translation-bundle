<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Resolver;

interface LocaleResolverInterface
{
    public function resolve(): ?string;
}
