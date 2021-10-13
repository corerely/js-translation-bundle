<?php
declare(strict_types=1);

use Corerely\JsTranslation\Provider\TranslationsProvider;
use Corerely\JsTranslation\Provider\TranslationsProviderInterface;
use Corerely\JsTranslation\Resolver\ChainLocaleResolver;
use Corerely\JsTranslation\Resolver\CookieLocaleResolver;
use Corerely\JsTranslation\Resolver\DefaultLocaleResolver;
use Corerely\JsTranslation\Resolver\LocaleResolverInterface;
use Corerely\JsTranslation\Resolver\RequestHeaderLocaleResolver;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('corerely.js_translation.translations_provider')->class(TranslationsProvider::class);
    $services->alias(TranslationsProviderInterface::class, 'corerely.js_translation.translations_provider');

    $services->set('corerely.js_translation.resolver.locale.chain')
        ->class(ChainLocaleResolver::class);

    $services->alias(LocaleResolverInterface::class, 'corerely.js_translation.resolver.locale.chain');

    $services->set('corerely.js_translation.resolver.locale.cookie_resolver')
        ->class(CookieLocaleResolver::class)
        ->arg(0, new Reference('request_stack'))
        ->arg(1, new Parameter('corerely.js_translation.locales'))
        ->tag('corerely.js_translation.locale_resolver', ['priority' => -10]);

    $services->set('corerely.js_translation.resolver.locale.request_header_resolver')
        ->class(RequestHeaderLocaleResolver::class)
        ->arg(0, new Reference('request_stack'))
        ->arg(1, new Parameter('corerely.js_translation.locales'))
        ->tag('corerely.js_translation.locale_resolver', ['priority' => -15]);

    $services->set('corerely.js_translation.resolver.locale.default_resolver')
        ->class(DefaultLocaleResolver::class)
        ->arg(0, new Parameter('corerely.js_translation.default_locale'))
        ->tag('corerely.js_translation.locale_resolver', ['priority' => -99]);
};
