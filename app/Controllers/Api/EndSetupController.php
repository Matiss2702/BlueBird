<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;

class EndSetupController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function endSetupAction()
    {
        $folderPath = "setup";
        $delete = $this->deleteDirectory($folderPath);
        echo json_encode(['success' => $delete]);
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $path = $dir . '/' . $file;
                if (is_dir($path)) {
                    $this->deleteDirectory($path);
                } else {
                    unlink($path);
                }
            }
        }

        rmdir($dir);
        return true;
    }

    public function getStructureAction()
    {
        $formStructure = [
            "type" => "form",
            "attributes" => [
                "method" => "POST",
                "action" => "#",
                "class" => "form-group container mt-5"
            ],
            "children" => [
                [
                    "type" => "div",
                    "attributes" => ["class" => "form-group"],
                    "children" => [
                        [
                            "type" => "input",
                            "attributes" => [
                                "type" => "submit",
                                "value" => "Terminer l'installation",
                                "class" => "btn btn-primary"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($formStructure);
    }
}
