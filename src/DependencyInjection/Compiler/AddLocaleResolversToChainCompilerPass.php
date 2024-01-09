<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final readonly class AddLocaleResolversToChainCompilerPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('corerely.js_translation.resolver.locale.chain');
        $resolverServices = $this->findAndSortTaggedServices('corerely.js_translation.locale_resolver', $container);

        foreach ($resolverServices as $resolverService) {
            $definition->addMethodCall('addResolver', [$resolverService]);
        }
    }
}
