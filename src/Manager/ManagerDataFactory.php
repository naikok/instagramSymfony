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
     * @return CsvManager | MysqlManager | null
     * @throws ManagerException
     */
    public static function get($type) 
    {
        $instance = null;
        switch ($type) {
            case 'csv':
                $instance = new CsvManager();
            case 'mysql':
                $instance = new MysqlManager();
                break;
            default:
                throw new ManagerException('Error when creating a new Manager to handle the data', ExceptionCodes::OPERATION_FAILED);
        }
        return $instance;
    }
}
