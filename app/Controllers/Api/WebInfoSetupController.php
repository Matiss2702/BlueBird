<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;

class WebInfoSetupController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function setWebInfoAction()
    {
        $post = $this->getRequest()->getPost();

        $title = $post->title;
        $description = $post->description;

        $fileContent = '<?php' . PHP_EOL .
            'define("WEBSITE_TITLE", "' . $title . '");' . PHP_EOL .
            'define("WEBSITE_DESCRIPTION", "' . $description . '");' . PHP_EOL;

        $fileName = 'website.config.php';

        file_put_contents($fileName, $fileContent);
        // chmod($fileName, 0666);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]); // ou false en cas d'échec
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
                            "type" => "label",
                            "attributes" => [
                                "for" => "title",
                                "class" => "form-label"
                            ],
                            "children" => ["Titre"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "id" => "title",
                                "name" => "title"
                            ]
                        ]
                    ]
                ],
                [
                    "type" => "div",
                    "attributes" => ["class" => "form-group"],
                    "children" => [
                        [
                            "type" => "label",
                            "attributes" => [
                                "for" => "description",
                                "class" => "form-label"
                            ],
                            "children" => ["Description"]
                        ],
                        [
                            "type" => "textarea",
                            "attributes" => [
                                "class" => "form-control",
                                "id" => "description",
                                "name" => "description"
                            ]
                        ]
                    ]
                ],
                [
                    "type" => "div",
                    "attributes" => ["class" => "form-group"],
                    "children" => [
                        [
                            "type" => "input",
                            "attributes" => [
                                "type" => "submit",
                                "value" => "Terminer",
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
