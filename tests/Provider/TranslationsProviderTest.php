<?php
declare(strict_types=1);

namespace Corerely\JsTranslation\Tests\Provider;

use Corerely\JsTranslation\Provider\TranslationsProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\MessageCatalogueInterface;
use Symfony\Component\Translation\TranslatorBagInterface;

class TranslationsProviderTest extends TestCase
{
    public function testGet()
    {
        $mockedBag = $this->createMock(MessageCatalogueInterface::class);
        $mockedBag->expects($this->once())->method('all')->willReturn([
            'some.nested.key' => 'translated label',
            'some.nested.key2' => 'translated label2',
            'some_other_key' => 'some key',
            'two.levels' => 'two levels'
        ]);

        $mockedTranslatorBag = $this->createMock(TranslatorBagInterface::class);
        $mockedTranslatorBag->expects($this->once())->method('getCatalogue')->willReturn($mockedBag);

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
                        'levels' => 'two levels',
                    ],
                ],
            ],
        ];

        $this->assertEquals($expect, $subject->get(['en'], ['app']));
    }
}
