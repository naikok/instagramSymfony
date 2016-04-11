<?php
namespace Manager;
use \Manager\Exception\ManagerException;
use \Manager\Exception\ExceptionCodes;
use \Manager\ManagerTypes\CsvManager;

/**
 * Class ManagerDataFactory
 * @package Manager
 */
 
class ManagerDataFactory
{
    /**
     * @param $type
     * @return CsvManager
     * @throws ManagerException
     */
     
    public static function getType($type) 
    {
        $instance = null;
        switch ($type) {
            case 'csv':
                $instance = CsvManager::getInstance();
                break;
            default:
                throw new ManagerException('Error when creating a new Manager to handle the data', ExceptionCodes::NOT_FOUND);
                break;
        }
        return $instance;
    }
}
