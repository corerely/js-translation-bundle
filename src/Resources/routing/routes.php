<?php
declare(strict_types=1);

use Corerely\JsTranslationBundle\Controller\LoaderController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('corerely_js_translation_translations_loader', '/{locale}')
        ->controller(LoaderController::class)
        ->methods(['GET']);
};
