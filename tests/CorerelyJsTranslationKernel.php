<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests;

use Corerely\JsTranslationBundle\CorerelyJsTranslationBundle;
use Corerely\JsTranslationBundle\Tests\DependencyInjection\PublicServicePass;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class CorerelyJsTranslationKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        return [
            new CorerelyJsTranslationBundle(),
            new FrameworkBundle(),
        ];
    }

    public function getCacheDir(): string
    {
        return __DIR__ . '/../var/cache' . spl_object_hash($this);
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addCompilerPass(new PublicServicePass());

        $loader->load(__DIR__ . '/config/config.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/../src/Resources/routing/routes.php')->prefix('translations');
    }
}
