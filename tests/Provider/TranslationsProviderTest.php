<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests\Provider;

use Corerely\JsTranslationBundle\Provider\TranslationsProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\MessageCatalogueInterface;
use Symfony\Component\Translation\TranslatorBagInterface;

class TranslationsProviderTest extends TestCase
{
    public function testGet(): void
    {
        $mockedBag = $this->createMock(MessageCatalogueInterface::class);
        $mockedBag->expects($this->exactly(2))->method('all')->willReturnOnConsecutiveCalls(
            [
                'some.nested.key' => 'translated label',
                'some.nested.key2' => 'translated label2',
                'some_other_key' => 'some key',
                'two.levels' => 'second level',
            ],
            [
                'some.nested.key' => 'swedish translated label',
                'some.nested.key2' => 'swedish translated label2',
                'some_other_key' => '',
                'two.levels' => 'swedish second level',
                'multiple.levels.third' => 'third level title',
            ],
        );

        $mockedTranslatorBag = $this->createMock(TranslatorBagInterface::class);
        $mockedTranslatorBag->expects($this->exactly(2))->method('getCatalogue')->willReturn($mockedBag);

        $subject = new TranslationsProvider(
            $mockedTranslatorBag,
            'en',
        );

        $expect = [
            'en' => [
                'app' => [
                    'some' => [
                        'nested' => [
                            'key' => 'translated label',
                            'key2' => 'translated label2',
                        ],
                    ],
                    'some_other_key' => 'some key',
                    'two' => [
                        'levels' => 'second level',
                    ],
                ],
            ],
            'sv' => [
                'app' => [
                    'some' => [
                        'nested' => [
                            'key' => 'swedish translated label',
                            'key2' => 'swedish translated label2',
                        ],
                    ],
                    'some_other_key' => 'some key', // Should not override with empty string
                    'two' => [
                        'levels' => 'swedish second level',
                    ],
                    'multiple' => [
                        'levels' => [
                            'third' => 'third level title',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expect, $subject->get(['en', 'sv'], ['app']));
    }
}
