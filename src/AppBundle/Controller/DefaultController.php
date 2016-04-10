<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \Manager\ManagerTypes\CsvManager;
use Symfony\Component\HttpFoundation\Response;
use \Manager\ManagerDataFactory;
use \AppBundle\Service\ManagerService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
    
    /**
     * @Route("/exportCsvFile", name="export_csv_file")
     */
     
    public function exportCsvFileAction()
    {
        $manager = new ManagerService('csv');
        return $manager->export(); 
    }
    
    /**
     * @Route("/readData", name="read_data")
     */
    
    public function readDataAtion()
    {
        $manager = new ManagerService('csv');
        $result = $manager->read();
        
        return new JsonResponse(['message' => $result, 'success' => 1]);
    }
    
    /**
     * @Route("/uploadFile", name="upload_file")
     */
     
    public function uploadFileAction(Request $request)
    {
        $filename = basename($_FILES['photo']['name']);
        $uploadDir = realpath($this->getParameter('kernel.root_dir').'/..') . '/web/images/';
        if (!empty($filename)) {
            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $filename = hash_file('md5', $_FILES['photo']['tmp_name']) . '.' . $extension;
            $uploadedFile = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadedFile)) {   
                $manager = new ManagerService('csv');
                $result = $manager->save($uploadedFile, $filename, $extension);
                if (is_array($result) && !empty($result)) {
                    return new JsonResponse(['message'=>$result,'success'=> 1]);
                } else {
                    return new JsonResponse(['message'=> $result,'success'=> 0]);
                }
            } else {
               return new JsonResponse(['message'=> "Error moving uploaded file",'success'=> 0]);
            } 
        }else {
             return new JsonResponse(['message'=> "File is not defined",'success'=> 0]);
        }
    }
}