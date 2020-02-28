<?php

namespace App\Controller\Crm;

use App\Entity\Crm\AdminProperties;
use App\Controller\BaseController;
use App\Form\Crm\AdminPropertiesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(){
        $success = TRUE;
        $data = [];
        $yamlFile = __DIR__ . '/../../../config/leadcrm.yaml';
        $yaml = Yaml::parseFile($yamlFile);
        foreach ($yaml as $k=>$v) {
            $data[] = [
                'key' => $k,
                'value' => $v
            ];
        }
        $response = [
            'data' => $data,
            'success' => $success
        ];
        return new JsonResponse($response);
    }

    /**
     * @Route("/savesettings", name="admin_save_settings", methods={"POST"})
     */
    public function savesettings(Request $request){
        $settings = json_decode($request->get('settings'), 1);
        $yamlFile = __DIR__ . '/../../../config/leadcrm.yaml';
        $yaml = [];
        foreach ($settings as $setting) {
            $yaml[$setting['key']] = $setting['value'];
        }
        $new_yaml = Yaml::dump($yaml);
        file_put_contents($yamlFile, $new_yaml);

        return new JsonResponse([
            'success' => TRUE
        ]);
    }

}
