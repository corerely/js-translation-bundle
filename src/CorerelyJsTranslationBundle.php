<?php
declare(strict_types=1);

namespace Corerely\JsTranslation;

use Corerely\JsTranslation\DependencyInjection\Compiler\AddLocaleResolversToChainCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CorerelyJsTranslationBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AddLocaleResolversToChainCompilerPass());
    }
}
