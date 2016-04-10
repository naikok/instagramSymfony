<?php

namespace tests\AppBundle\Manager\ManagerTypes;
use \Manager\ManagerTypes\CsvManager;

class CsvManagerTest extends \PHPUnit_Framework_TestCase
{
    
    protected $csvManager;
    public function setUp()
    {
        $this->csvManager = CsvManager::getInstance();
    }
    
    /**
     * @expectedException Exception
     */
     
    public function testInitCsv()
    {
        $this->csvManager->deleteCsv();
        $this->assertTrue(is_string($this->csvManager->initCsv()));
    }

    public function testSaveData()
    {
        $data = ['title' => "Test", 'createdAt' => date('Y-m-d H:i:s'), 'imageName' =>  "test.jpeg"];
        $result = $this->csvManager->saveData($data);
        $this->assertNotEmpty($result);
    }
    
    /**
     * @expectedException Exception
     * @covers saveData
     */
     
    public function testSaveDataFail()
    {
        $data = [];
        try {
            $result = $this->csvManager->saveData($data);
        }catch(Exception $e) {
            $this->assertEquals($e->getMessage(), "Data not provided to be saved into the csv file");
            return;
        }
    }
    
    public function testLastIdInserted()
    {
        $data = ['title' => "Test", 'createdAt' => date('Y-m-d H:i:s'), 'imageName' =>  "test.jpeg"];
        $result = $this->csvManager->saveData($data);
        $this->assertTrue($this->csvManager->getLastIdInserted() > 1 );
    }
    
    public function testExportData()
    {
        $response = $this->csvManager->exportData();
        $fileLength = strlen($response->getContent());
        $this->assertTrue($fileLength > 0);
    }
    
    public function readData()
    {
        $result = $this->csvManager->readData();
        $countItems = count($result);
        $this->assertNotEmpty($result);
        $this->assertTrue($countItems > 0);
    }
}