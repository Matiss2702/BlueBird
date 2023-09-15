<?php

require __DIR__ . '/Helpers/functions.php';
require __DIR__ . '/config/config.php';
require __DIR__ . '/Generators/ModelGenerator.php';

use App\Generators\ModelGenerator;

if (isset($argv[1])) {
    $tableName = $argv[1];
    $generator = new ModelGenerator($tableName);
    $generator->generateModel();
} else {
    echo "Veuillez spécifier le nom de la table.\n";
}