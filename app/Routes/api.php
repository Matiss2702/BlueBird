<?php

use App\Controllers\Api\StartSetupController;
use App\Controllers\Api\DatabaseSetupController;
use App\Controllers\Api\AdminAccountSetupController;
use App\Controllers\Api\WebInfoSetupController;
use App\Controllers\Api\EndSetupController;

/**
 * API
 */

$router->get('/api/installation/step1', StartSetupController::class, 'getStructure');

$router->get('/api/installation/step2', DatabaseSetupController::class, 'getStructure');
$router->post('/api/installation/createDatabase', DatabaseSetupController::class, 'createDatabase');

$router->get('/api/installation/step3', AdminAccountSetupController::class, 'getStructure');
$router->post('/api/installation/createUser', AdminAccountSetupController::class, 'createUser');

$router->get('/api/installation/step4', WebInfoSetupController::class, 'getStructure');
$router->post('/api/installation/setWebInfo', WebInfoSetupController::class, 'setWebInfo');

$router->get('/api/installation/step5', EndSetupController::class, 'getStructure');
$router->post('/api/installation/endSetup', EndSetupController::class, 'endSetup');