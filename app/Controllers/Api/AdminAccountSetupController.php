<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use App\Requests\AdminAccountSetupRequest;

class AdminAccountSetupController extends Controller
{
 
    public function __construct()
    {
        parent::__construct();
    }

    public function createUserAction()
    {
        header('Content-Type: application/json');

        $request = new AdminAccountSetupRequest();;
        if (!$request->createUser()) {
            echo json_encode(['success' => false, 'errors' => array_values($request->getErrors())]);
            return;
        }

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
                                "for" => "lastname",
                                "class" => "form-label"
                            ],
                            "children" => ["Nom"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "id" => "lastname",
                                "name" => "lastname",
                                "class" => "form-control"
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
                                "for" => "firstname",
                                "class" => "form-label"
                            ],
                            "children" => ["Prénom"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "id" => "firstname",
                                "name" => "firstname",
                                "class" => "form-control"
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
                                "for" => "email",
                                "class" => "form-label"
                            ],
                            "children" => ["Email"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "email",
                                "id" => "email",
                                "name" => "email",
                                "class" => "form-control"
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
                                "for" => "password",
                                "class" => "form-label"
                            ],
                            "children" => ["Mot de passe"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "password",
                                "id" => "password",
                                "name" => "password",
                                "class" => "form-control"
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
                                "for" => "passwordConfirm",
                                "class" => "form-label"
                            ],
                            "children" => ["Confirmer"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "password",
                                "id" => "passwordConfirm",
                                "name" => "passwordConfirm",
                                "class" => "form-control"
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
                                "value" => "Suivant",
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