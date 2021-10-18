<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle;

use Corerely\JsTranslationBundle\DependencyInjection\Compiler\AddLocaleResolversToChainCompilerPass;
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
