# JsTranslationBundle

## Installation

Open a command console, enter your project directory and execute:

```console
$ composer require corerely/js-translation-bundle
```

Configuration
-------------

```yaml
# Add required bundle parameters
parameters:
    # Default App locale
    corerely.js_translation.default_locale: 'en'
    # All App locales
    corerely.js_translation.locales: [ 'en', 'sv' ]
    # All App domains
    corerely.js_translation.domains: [ 'app' ]
```

## Usage

### 1. Get translations for current locale

In your service inject helper service with ID `corerely.js_translation.service` or just use contructor with Symfony autowiring.

```php
<?php

namespace App\Controller;

use Corerely\JsTranslationBundle\JsTranslationsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    public function __construct(private JsTranslationsService $translationsService)
    {
    }

    #[Route('/', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin.html.twig', [
            'locale' => $this->translationsService->getActiveLocale(),
            'translations' => $this->translationsService->getTranslationsForActiveLocale(),
        ]);
    }
}

```

### 2. Configure route for loading translations dynamically

If you need to load translations as JSON dynamically configure coresponding endpoint.

Add to routes `config/routes.yaml`

```yaml
corerely_js_translation:
    resource: '@CorerelyJsTranslationBundle/Resources/routing/routes.php'
    prefix: /locale
```

Now try to open url `/locale/en`. It should return translations for `en` locale for configured domains as JSON.

**Replace `en` with any App locale.** 

### 3. Public API

 - `Corerely\JsTranslationBundle\Provider\TranslationsProviderInterface` - use for gettings translations for given locales and domains.
 - `Corerely\JsTranslationBundle\Resolver\LocaleResolverInterface` - service for resolving current App locale

### 4. Custom App locale resolver

By default bundle is checking if cookie with name `locale` is set in order determinate App locale.
If not it's trying to resolve locale from `Accept-Language` header.

If nothing from above is working bundle fallback to default locale set in parameter `corerely.js_translation.default_locale`.

It's possible to add custom locale resolver. Just create new service that implements `Corerely\JsTranslationBundle\Resolver\LocaleResolverInterface`.
Thanks to Symfony autowiring it'll automatilly tagged with `corerely.js_translation.locale_resolver` tag.

```php
// app/CustomResolver.php
namespace App;

class CustomResolver implements Corerely\JsTranslationBundle\Resolver\LocaleResolverInterface
{
    public function resolve(): ?string
    {
        if (true /* some logic */ ) {
            return 'en'; // was able to resolve locale
        }
        
        return null; // was not able to resolve locale. allow other service to try.
    }
}
```

## Testing

### Step 1: Go to root folder using console and run

```shell
composer install
```

### Step 2: Run code sniffer

```shell
./vendor/bin/phpcs -n
```

### Step 2: Run PHPUnit tests

```shell
./vendor/bin/simple-phpunit
```
