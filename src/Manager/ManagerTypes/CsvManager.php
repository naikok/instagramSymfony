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
    public $filename = '';

    private function __construct()
    {
        $this->columns = ['id', 'title', 'createdAt', 'imageName'];
        $this->filename = 'demo.csv';
        $this->filepath = __DIR__ . '/csv/' . $this->filename;
    }

    /**
     * it creates an instance of this class if it was not already instancied
     * @return object 
     */
     
    public static function getInstance() 
    {
        if (!self::$instance instanceof self) 
            self::$instance = new self;
        
        return self::$instance;
    }
    
    /**
     * it gets the current class name of this object
     * @return string 
     */
     
    public function getClass()
    {
        return get_called_class();
    }
    
    /**
     * it returns the content into a string of the file created
     * @throws Exception when error is found
     * @return string 
     */
     
    public function initCsv() 
    {    
       try {
            $file = fopen($this->filepath, 'w');
            fputcsv($file, $this->columns); // save the columns headers
            fclose($file);
            @chmod($this->filepath, 0777);
            return file_get_contents($file);
        } catch (Exception $e) {
            throw new ManagerException("Error when creating the  csv file", ExceptionCode::NOT_FOUND);
        }
    }
    
    /**
     * it returns the nextId to be inserted on the csv file
     * @throws Exception when error is found
     * @return int 
     */
     
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
    
    /**
     * it returns if the file was deleted or not
     * @throws Exception when error is found
     * @return bool 
     */
    public function deleteCsv()
    {
        if (file_exists($this->filepath)) {
            try {
                 unlink($this->filepath);
                 return true;
            } catch (Exception $e) {
                throw new ManagerException("Error deleting csv file from the system", ExceptionCode::OPERATION_FAILED);
            }
        } else {
            return false;
        }
    }
    
    /**
     * it returns an array with the data inserted
     * @param $data array it contains the associative array data to be saved
     * @throws Exception when error is found
     * @return array 
     */
     
    public function saveData($data) 
    {
        if (!file_exists($this->filepath)) 
            $this->initCsv();
            
        $id = $this->getLastIdInserted();
        $data = [$id, $data["title"], $data['createdAt'], $data['imageName']];    
        $dataList = [$data];
        try {
            if (!empty($dataList) && is_array($dataList)) {
                try{
                    $file = fopen($this->filepath, 'a');
                    foreach ($dataList as $field) {          
                        fputcsv($file, $field);   
                    }  
                    fclose($file);
                    return $data;
                }catch (Exception $e) {
                    throw new ManagerException('Operation Failed when saving data', ExceptionCodes::OPERATION_FAILED);
                }
            } else {
                throw new ManagerException('Data not provided to be saved into the csv file', ExceptionCodes::BAD_REQUEST);
            }
        } catch (Exception $e) {
            throw new ManagerException('Data could not be saved properly into the csv file', ExceptionCodes::OPERATION_FAILED); 
        }   
    }
   
     
    /**
     * it returns an array with the results ordered by id desc
     * @throws Exception when error is found
     * @return array
     */
     
    public function readData() 
    {       
        $results = [];
        if (!file_exists($this->filepath)) 
            throw new ManagerException('File csv could not be found under' . $this->filepath, ExceptionCodes::NOT_FOUND);
        try {
            $file = fopen($this->filepath, 'r');
            while (($line = fgetcsv($file)) !== FALSE) {
                $results[] = $line;
            }
            fclose($file);
            return array_reverse($results); //order by date desc
        } catch (Exception $e) {
            throw new ManagerException('Csv file could not be read as expected', ExceptionCodes::OPERATION_FAILED);
        }
    }
    
    /**
     * it returns a csv file binary file to be downloaded
     * @throws Exception when error is found
     * @return mixed 
     */
     
    public function exportData()
    { 
        $response = new Response();
        $response->headers->set('Content-type', 'application/octect-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $this->filename));
        $response->headers->set('Content-Length', filesize($this->filepath));
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->setContent(file_get_contents($this->filepath));
        return $response;
    }
}
