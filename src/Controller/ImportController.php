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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/import")
 */
class ImportController extends AbstractController
{
    /**
     * @Route("/schema", name="import_schema", methods={"GET"})
     */
    public function schema(): Response
    {
        $data = "lead[leadSource],lead[amount],lead[campaign],lead[notes],person[firstName],person[lastName],person[gender],person[email],person[phone],person[notes],business[name],business[phone],business[email],business[website],business[abn],business[acn],business[numberOfEmployees],business[industry],business[annualRevenue],business[notes]\r\n";
        return new Response($data,200,[
            "Content-Type" => "text/csv",
            'Content-disposition" => "attachment; filename="schema.csv"'
        ]);
    }

    /**
     * @Route("/import", name="import_import", methods={"POST"})
     */
    public function import(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('file', 'file') // If I remove this line data is submitted correctly
            ->getForm();

        $request = $this->getRequest();
        $form->bindRequest($request);

        $data = $form->getData();


    }
}
