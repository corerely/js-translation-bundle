<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Tests;

use Corerely\JsTranslation\CorerelyJsTranslationBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class CorerelyJsTranslationKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles()
    {
        return [
            new CorerelyJsTranslationBundle(),
            new FrameworkBundle(),
        ];
    }

    public function configureContainer(ContainerConfigurator $container): void
    {
        $parameters = $container->parameters();
        $parameters->set('corerely.js_translation.domains', ['app']);
        $parameters->set('corerely.js_translation.default_locale', 'en');
        $parameters->set('corerely.js_translation.locales', ['en']);
    }

    public function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/../config/routes.php')->prefix('translations');
    }
}
