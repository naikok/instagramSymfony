<?php
namespace Manager\Exception;

 /**
  * Class Exception
  * 
  * Manages exception
  * 
  */

class ManagerException extends \Exception {

    public function __construct($message, $modelName , $id = null)
    {
        parent::__construct($message,$modelName, $id);
    }
} 