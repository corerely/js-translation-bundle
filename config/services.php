<?php
declare(strict_types=1);

use Corerely\JsTranslationBundle\Provider\TranslationsProvider;
use Corerely\JsTranslationBundle\Provider\TranslationsProviderInterface;
use Corerely\JsTranslationBundle\JsTranslationsService;
use Corerely\JsTranslationBundle\Resolver\ChainLocaleResolver;
use Corerely\JsTranslationBundle\Resolver\CookieLocaleResolver;
use Corerely\JsTranslationBundle\Resolver\DefaultLocaleResolver;
use Corerely\JsTranslationBundle\Resolver\LocaleResolverInterface;
use Corerely\JsTranslationBundle\Resolver\RequestHeaderLocaleResolver;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('corerely.js_translation.service', JsTranslationsService::class)
        ->arg(0, new Reference(TranslationsProviderInterface::class))
        ->arg(1, new Reference(LocaleResolverInterface::class))
        ->arg(2, new Parameter('corerely.js_translation.domains'))
    ;
    $services->alias(JsTranslationsService::class, 'corerely.js_translation.service');

    $services->set('corerely.js_translation.translations_provider')
        ->class(TranslationsProvider::class)
        ->arg(0, new Reference('translator.default'))
        ->arg(1, new Parameter('corerely.js_translation.default_locale'));
    $services->alias(TranslationsProviderInterface::class, 'corerely.js_translation.translations_provider');

    $services->set('corerely.js_translation.resolver.locale.chain')
        ->arg(0, new Parameter('corerely.js_translation.locales'))
        ->class(ChainLocaleResolver::class);

    $services->alias(LocaleResolverInterface::class, 'corerely.js_translation.resolver.locale.chain');

    $services->set('corerely.js_translation.resolver.locale.cookie_resolver')
        ->class(CookieLocaleResolver::class)
        ->arg(0, new Reference('request_stack'))
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
