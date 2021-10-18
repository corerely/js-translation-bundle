<?php
declare(strict_types=1);

use Corerely\JsTranslationBundle\Controller\LoaderController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set(LoaderController::class)
        ->arg(0, new Reference('corerely.js_translation.translations_provider'))
        ->arg(1, new Parameter('corerely.js_translation.domains'))
        ->public()
    ;
};
