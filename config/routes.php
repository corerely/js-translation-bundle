<?php
declare(strict_types=1);

use Corerely\JsTranslation\Controller\LoaderController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('corerely_js_translation_translations_loader', '/load/{locale}')
        ->controller(LoaderController::class)
        ->methods(['GET']);
};
