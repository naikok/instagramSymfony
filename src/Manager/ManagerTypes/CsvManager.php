<?php

namespace Manager\ManagerTypes;

use \Manager\ManagerDataInterface;
use \Manager\Exception\ManagerException;
use \Manager\Exception\ExceptionCode;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class CsvManager
 * @package Manager\ManagerTypes
 */
 
class CsvManager implements ManagerDataInterface {

    private static $instance;
    public $columns = '';
    public $filepath = '';

    private function __construct()
    {
        $this->columns = ['id', 'title', 'createdAt', 'imageName'];
        $this->filepath = __DIR__."/csv/demo.csv";
    }

    public static function getInstance() {
      if (!self::$instance instanceof self) {
         self::$instance = new self;
      }
      return self::$instance;
    }
   
    public function initCsv() 
    {    
       try {
            $file = fopen($this->filepath, 'w');
            fputcsv($file, $this->columns); // save the columns headers
            fclose($file);
            return file_get_contents($file);
        } catch (Exception $e) {
            throw new ManagerException("Error when creating the  csv file", ExceptionCode::NOT_FOUND);
        }
    }
    
    public function getLastIdInserted() 
    {
        if (!file_exists($this->filepath)) 
            throw new ManagerException('File csv could not be found under' . $this->filepath, ExceptionCodes::NOT_FOUND);
        $rows = file($this->filepath);
        $last_row = array_pop($rows);
        $lastRow = str_getcsv($last_row);
        $lastId = (int) $lastRow[0];
        return ( $lastId > 0)  ? $lastId + 1 : 1;
    }
    
    public function deleteCsv()
    {
        if (file_exists($this->filepath)) {
            unlink($this->filepath);
            return true;
        } else {
            return false;
        }
    }
   
    public function saveData($data) {

        if (!file_exists($this->filepath)) 
            $this->initCsv();
            
        $id = $this->getLastIdInserted();
        $data = [$id, $data["title"], $data['createdAt'], $data['imageName']];    
        $dataList = [$data];
        try {
            if (!empty($dataList) && is_array($dataList)) {
                $file = fopen($this->filepath, 'a');
                foreach ($dataList as $field) {          
                    fputcsv($file, $field);   
                }  
                fclose($file);
                return $data;
            } else {
                throw new ManagerException('Data not provided to be saved into the csv file', ExceptionCodes::BAD_REQUEST);
            }
        } catch (Exception $e) {
            throw new ManagerException('Data could not be saved properly into the csv file', ExceptionCodes::OPERATION_FAILED); 
        }   
   }
   
 
   public function readData() {       
        $results = [];
        $file = fopen($this->filepath, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            //$line is an array of the csv elements
            $results[] = $line;
        }
        fclose($file);
        return array_reverse($results);  
   }     
   
    public function exportData()
    { 
        $response = new Response();
        $response->headers->set('Content-type', 'application/octect-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', "demo.csv"));
        $response->headers->set('Content-Length', filesize($this->filepath));
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->setContent(file_get_contents($this->filepath));
        return $response;
    }
}
