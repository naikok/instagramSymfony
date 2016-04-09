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
     */
     
    public function testSaveDataFail()
    {
        $data = [];
        $result = $this->csvManager->saveData($data);
    }
    
    public function testLastIdInserted()
    {
        $data = ['title' => "Test", 'createdAt' => date('Y-m-d H:i:s'), 'imageName' =>  "test.jpeg"];
        $result = $this->csvManager->saveData($data);
        $this->assertTrue($this->csvManager->getLastIdInserted() > 1 );
    }
    
    public function exportData(){
        $this->csvManager->exportData();
    }

}