<?php
namespace AppBundle\Service;
use \Manager\ManagerDataFactory;

class ManagerService 
{
    public $manager;   
    public $validExtensions = [];
    public $limitFileSize = 0; //KB
    public $maxWidth = 0;
    public $maxHeight = 0;
    
    function __construct($type) 
    {  
        if (!$type) 
            trigger_error("Type is not defined on constructor");
            
        $this->validExtensions = ['gif', 'jpeg', 'jpg', 'png'];
        $this->manager = ManagerDataFactory::getType($type); 
        $this->maxHeight = 1080;
        $this->maxWidth = 1920;
        $this->limitFileSize = 2048;
    } 
    
    /**
     * it returns true or false depending if the extension given is included in the array defined
     * @return bool
     */
    
    public function isExtensionValid($extension)
    {
        return (in_array($extension, $this->validExtensions))  ? true : false;
    }
     
    /**
     * it returns true or false depending if the resolution is valid within the specific width and height
     * @return bool
     */
    
    public function isResolutionValid($width, $height)
    {
        return ($width <= $this->maxWidth && $height <= $this->maxHeight) ? true : false;
    }
    
    /**
     * it returns true or false depending if the fileSize given is in the specific limitFileSize defined
     * @return bool
     */
     
    public function isFileSizeValid($fileSize)
    {
        return ($fileSize <= $this->limitFileSize) ? true : false;
    }

    /**
     * Function that saves the data through the manager
     * @param $uploadedFile string It's the path where the file was uploaded to.
     * @param $filename string, It's the name of the file uploaded.
     * @param $extension string, It's the extension of the file uploaded.
     * @return mixed it could return an array of the data inserted or it could return just a string message
     */
     
    public function save($uploadedFile, $filename, $extension)
    {
        $data = getimagesize($uploadedFile);
        $width = $data[0];
        $height = $data[1];
        $fileSize = filesize($uploadedFile); // Get file size in bytes
        $fileSize = $fileSize / 1024; // Get file size in KB
        if ($this->isExtensionValid($extension)) {
            if ($this->isResolutionValid($width, $height)) {          
                if ($this->isFileSizeValid($fileSize)) { 
                    $createdAt = date('Y-m-d H:i:s');
                    $postTitle = $_POST['title-photo'];
                    $data = ['title' => $postTitle, 'createdAt' => date('Y-m-d H:i:s'), 'imageName' =>  $filename];
                    try {
                        $result = $this->manager->saveData($data);
                        return $result;
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                } else {
                  return 'fileSize is not valid';
                }
            } else {
                return 'resolution is not valid';
            }
        } else {
            return 'extension is not valid';
        }
    }  
    
    /** It retunrs the array of data coming from the manager.
     * @throws error if action is not carried out
     * @return bool
     */
     
    public function read()
    {   
        try {
            return $this->manager->readData();
        } catch (Exception $e) {
           trigger_error("error reading file"); 
        }
    }
    
    /** It returns the data into a file to be downloaded through the manager
     * @return mixed
     */
     
    public function export()
    {
        return $this->manager->exportData();
    }
}
