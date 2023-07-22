<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use App\Requests\DatabaseRequest;

class DatabaseSetupController extends Controller
{
 
    public function __construct()
    {
        parent::__construct();
    }

    public function createDatabaseAction()
    {
        header('Content-Type: application/json');

        $request = new DatabaseRequest();;
        if (!$request->createDatabase()) {
            echo json_encode(['success' => false, 'errors' => array_values($request->getErrors())]);
            return;
        }

        echo json_encode(['success' => true]);
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
                                "for" => "dbName",
                                "class" => "form-label"
                            ],
                            "children" => ["Nom de la base de données"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "id" => "dbName",
                                "name" => "dbName",
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
                                "for" => "dbUser",
                                "class" => "form-label"
                            ],
                            "children" => ["Nom d'utilisateur de la base de données"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "id" => "dbUser",
                                "name" => "dbUser",
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
                                "for" => "dbPassword",
                                "class" => "form-label"
                            ],
                            "children" => ["Mot de passe de la base de données"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "password",
                                "id" => "dbPassword",
                                "name" => "dbPassword",
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
                                "for" => "dbPasswordConfirm",
                                "class" => "form-label"
                            ],
                            "children" => ["Confirmer le Mot de passe"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "password",
                                "id" => "dbPasswordConfirm",
                                "name" => "dbPasswordConfirm",
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
                                "for" => "dbHost",
                                "class" => "form-label"
                            ],
                            "children" => ["Hôte de la base de données"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "id" => "dbHost",
                                "name" => "dbHost",
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
                                "for" => "dbPort",
                                "class" => "form-label"
                            ],
                            "children" => ["Port de la base de données"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "id" => "dbPort",
                                "name" => "dbPort",
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
                                "for" => "tablePrefix",
                                "class" => "form-label"
                            ],
                            "children" => ["Préfixe des tables"]
                        ],
                        [
                            "type" => "input",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "id" => "tablePrefix",
                                "name" => "tablePrefix",
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