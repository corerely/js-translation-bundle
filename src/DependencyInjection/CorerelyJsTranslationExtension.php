<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\DependencyInjection;

use Corerely\JsTranslationBundle\Resolver\LocaleResolverInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class CorerelyJsTranslationExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.php');
        $loader->load('controllers.php');

        $container->registerForAutoconfiguration(LocaleResolverInterface::class)->addTag('corerely.js_translation.locale_resolver');
    }
}
