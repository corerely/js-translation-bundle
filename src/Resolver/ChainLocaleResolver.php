<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Resolver;

final class ChainLocaleResolver implements LocaleResolverInterface
{
    /**
     * @var LocaleResolverInterface[]
     */
    private array $resolvers = [];

    public function __construct(private array $locales)
    {
    }

    public function addResolver(LocaleResolverInterface $resolver): self
    {
        $this->resolvers[] = $resolver;

        return $this;
    }

    public function resolve(): string
    {
        foreach ($this->resolvers as $resolver) {
            $locale = $resolver->resolve();

            if ($this->supportLocale($locale)) {
                return $locale;
            }
        }

        throw new \LogicException('Could not resolve locale. Please check configuration. At least default locale should be resolved');
    }

    private function supportLocale(?string $locale): bool
    {
        return null !== $locale && in_array($locale, $this->locales, true);
    }
}
