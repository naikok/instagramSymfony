<?php
namespace Manager;

/**
 * Interface ManagerDataInterface
 * @package Manager
 */

interface ManagerDataInterface
{
    /**
     * @param mixed $data
     */
     
    public function saveData($data);
    public function readData();
    public function exportData();
    
}