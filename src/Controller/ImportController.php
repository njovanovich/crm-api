<?php
/**
 * ImportController.php
 * Created by: nick
 * @ 30/12/2019 9:17 am
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Json;
use App\Entity\Crm\Util;

/**
 * @Route("/import")
 */
class ImportController extends AbstractController
{
    /**
     * @Route("/schema", name="import_schema", methods={"GET"})
     */
    public function schema(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        //$base->checkCsrf();
        $base->checkLogin();

        $data = "lead[leadSource],lead[leadId],lead[amount],lead[campaign],lead[notes],person[title],person[firstName],person[lastName],person[jobTitle],person[gender],person[email],person[phone],person[notes],business[name],business[phone],business[email],business[website],business[abn],business[acn],business[numberOfEmployees],business[industry],business[annualRevenue],business[notes],address[address1],address[address2],address[suburb],addrees[state],address[postcode],address[country]\r\n";
        return new Response($data,200,[
            'Cache-Control' => 'private',
            'Content-Type' => 'application/ms-excel',
            'Content-Disposition' => 'attachment; filename="schema.csv"',
            "Pragma"=>"public",
            'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT'
        ]);
    }

    /**
     * @Route("/import", name="import_import", methods={"POST"})
     */
    public function import(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
//        $base->checkCsrf();
//        $base->checkLogin();

        $em = $this->getDoctrine()->getManager();

        $file = $request->files->get('file');
        $filename = $file->getRealPath();

        $rowNumber = 0;
        $failed = 0;
        $success = 0;
        $headers = [];
        $rows = [];
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row = [];
                for ($c=0; $c < $num; $c++) {
                    if (!$rowNumber) {
                        $headers[] = $data[$c];
                    } else {
                        $row[$headers[$c]] = $data[$c];
                    }
                }
                if ($rowNumber) {
                    try{
                        // process the row
                        $objects = [];
                        foreach ($row as $k=>$v) {
                            preg_match('/(\w+)\[(\w+)\]/',$k, $matches);
                            $objectName = $matches[1];
                            $fieldName = $matches[2];
                            if (!$objectName || !$fieldName) {
                                throw new \Exception("Column names badly formatted");
                            }
                            $objects[$objectName][$fieldName] = $v;
                        }

                        $outObjects = [];
                        foreach ($objects as $objectName=>$data) {
                            try{
                                $className = Util::getClassName($objectName);
                                $object = new $className();
                                foreach ($data as $fieldName=>$value) {
                                    $setter = Util::getSetter($fieldName);
                                    if ($fieldName == "notes") {
                                        $note = new \App\Entity\Crm\Note();
                                        $note->setContents($value);
                                        $em->persist($note);
                                        $object->$setter([$note]);
                                    } {
                                        $object->$setter($value);
                                    }
                                }
                            }catch(Exception $ex){
                                $message = $ex->getMessage();
                            }
                            $outObjects[$objectName] = $object;
                        }
                        if (in_array("address", array_keys($outObjects)) &&
                                in_array("business", array_keys($outObjects))) {
                            $outObjects["business"]->setAddress($outObjects["address"]);
                            $em->persist($outObjects["address"]);
                        }

                        if (in_array("business", array_keys($outObjects))) {
                            $em->persist($outObjects["business"]);
                            $outObjects["lead"]->setBusiness($outObjects["business"]);
                        }

                        if (in_array("person", array_keys($outObjects))) {
                            $em->persist($outObjects["person"]);
                            $outObjects["lead"]->setPerson($outObjects["person"]);
                        }
                        $outObjects["lead"]->setStatus('new');
                        $em->persist($outObjects["lead"]);
                        $success++;
                    }catch(\Exception $ex){
                        $failed++;
                    }
                }

                $rowNumber++;
            }
            $em->flush();
            fclose($handle);
        }

        return new JsonResponse(["success"=>TRUE,"successful"=>$success,"failed"=>$failed]);
    }
}
