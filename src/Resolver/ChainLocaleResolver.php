<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Resolver;

final class ChainLocaleResolver implements LocaleResolverInterface
{
    /**
     * @var LocaleResolverInterface[]
     */
    private array $resolvers = [];

    public function addResolver(LocaleResolverInterface $resolver): self
    {
        $this->resolvers[] = $resolver;

        return $this;
    }

    public function resolve(): string
    {
        foreach ($this->resolvers as $resolver) {
            if ($locale = $resolver->resolve()) {
                return $locale;
            }
        }

        throw new \LogicException('Could not resolve locale. Please check configuration. At least default locale should be resolved');
    }
}
