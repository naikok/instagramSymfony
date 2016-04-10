<?php

namespace tests\AppBundle\Manager;
use \Manager\ManagerDataFactory;

class CsvManagerTest extends \PHPUnit_Framework_TestCase
{
    
    public function setUp(){}
    
    /**
     * @expectedException Exception
	 * @covers getType
	 */
    
    public function testGetTypeFail()
    {
        try {
            ManagerDataFactory::getType();
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "Error when creating a new Manager to handle the data");
            return;
        }
    }
    
    /**
	 * @covers getType
	 */
	 
    public function testGetType()
    {
        $objectManager = ManagerDataFactory::getType('csv');
        $class = $objectManager->getClass();
        $this->assertEquals("Manager\ManagerTypes\CsvManager", $class);
    }

    

}