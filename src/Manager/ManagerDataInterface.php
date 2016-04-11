<?php
namespace Manager;

/**
 * Interface ManagerDataInterface
 * @package Manager
 */

interface ManagerDataInterface
{
    /**
     * @param array $data
     */
    public function saveData($data);
    public function readData();
    public function exportData();
    
}