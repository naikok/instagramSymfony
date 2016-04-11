<?php
namespace Tests\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testExportCsvFile()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/exportCsvFile');
        $this->assertTrue(is_string($client->getResponse()->getContent()));
        $fileLength = strlen($client->getResponse()->getContent());
        $this->assertTrue($fileLength > 0);
    }
}
