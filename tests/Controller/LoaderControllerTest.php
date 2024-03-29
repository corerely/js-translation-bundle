<?php
declare(strict_types=1);

namespace Corerely\JsTranslationBundle\Tests\Controller;

use Corerely\JsTranslationBundle\Tests\CorerelyJsTranslationKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class LoaderControllerTest extends TestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new KernelBrowser(new CorerelyJsTranslationKernel());
    }

    public function testLoadTranslations(): void
    {
        $this->client->request('GET', '/translations/en');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }
}
