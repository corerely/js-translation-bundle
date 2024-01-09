<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PublicServicePass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('corerely.js_translation.translation_cache_service');
        $definition->setPublic(true);
    }
}
