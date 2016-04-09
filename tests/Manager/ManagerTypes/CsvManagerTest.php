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
        var_dump($this->csvManager->exportData());
    }
    /*
    public function testSetName()
    {
        $this->context->setName('pacomadinabeitia');
        $this->assertEquals('pacomadinabeitia', $this->context->getName());
    }
    
    public function testSetDescription()
    {
        $this->context->setDescription('This is just a short description');
        $this->assertEquals('This is just a short description', $this->context->getDescription());
    }
    
    public function testSetFlag()
    {
        $this->context->setFlag(134251266);
        $this->assertEquals(134251266, $this->context->getEmail());
    }
    
    public function testSetFlagInfo()
    {
        $this->context->setFlagInfo(null);
        $this->assertEquals(null, $this->context->getFlagInfo());
    }
    
    public function setPath()
    {
        $this->context->setPath('/12/');
        $this->assertEquals('/12/', $this->context->getPath());
    }
    public function testSetOwnerId()
    {
        $this->context->setOwnerId(6865);
        $this->assertEquals(6865, $this->context->getOwnerId());
    }
    
    public function testSetKeyword()
    {
        $this->context->setKeyword('php developer');
        $this->assertEquals('php developer', $this->context->getKeyword());
    }
    
    public function testSetSubscribersCount()
    {
        $this->context->setSubscribersCount(0);
        $this->assertEquals(0, $this->context->getSubscribersCount());
    }
    
    public function testSetIsOpen()
    {
        $this->context->setIsOpen(1);
        $this->assertEquals(1, $this->context->getIsOpen());
    }
    
    public function testSetParentId()
    {
        $this->context->setParentId(12);
        $this->assertEquals(12, $this->context->getParentId());
    }
    
    public function testSetDeletionDate()
    {
        $newDate = new \DateTime("now");
        $this->context->setDeletionDate($newDate);
        $this->assertEquals($newDate, $this->context->getDeletionDate());
    }
    
    public function testSetIsModerated()
    {
        $this->context->setIsModerated(1);
        $this->assertEquals(1, $this->context->getIsModerated());
    }
    
    public function testSetIsMandatory()
    {
        $this->context->setIsMandatory(1);
        $this->assertEquals(1, $this->context->getIsMandatory());
    }
    
    public function testSetIsSocialShared()
    {
        $this->context->setIsSocialShared(1);
        $this->assertEquals(1, $this->context->getIsSocialShared());
    }
    
    public function testSetCategory(){
        $this->context->setCategory(2);
        $this->assertEquals(2, $this->context->getCategory());
    }
    
    public function testSetFamily(){
        $this->context->setFamily(3);
        $this->assertEquals(3, $this->context->getFamily());
    }*/
}