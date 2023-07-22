<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;

class StartSetupController extends Controller
{
 
    public function __construct()
    {
        parent::__construct();
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
                            "type" => "h1",
                            "children" => ["Bienvenue sur l'installation de votre site"]
                        ],
                        [
                            "type" => "p",
                            "attributes" => ["class" => "font-weight-bold"],
                            "children" => ["Votre installation se fera en 3 étapes :"]
                        ],
                        [
                            "type" => "ul",
                            "children" => [
                                [
                                    "type" => "li",
                                    "children" => ["Configuration de la base de données"]
                                ],
                                [
                                    "type" => "li",
                                    "children" => ["Création du compte administrateur"]
                                ],
                                [
                                    "type" => "li",
                                    "children" => ["Configuration du site"]
                                ]
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