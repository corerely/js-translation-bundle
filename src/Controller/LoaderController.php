<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Controller;

use Corerely\JsTranslation\Provider\TranslationsProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoaderController
{

    public function __construct(private TranslationsProviderInterface $translationsProvider, private array $domains)
    {
    }

    public function __invoke(string $locale): JsonResponse
    {
        $translations = $this->translationsProvider->get([$locale], $this->domains);

        return new JsonResponse($translations);
    }
}