<?php

namespace App\Requests;

use App\Core\FormRequest;
use App\Models\DatabaseModel;

class DatabaseRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'dbName' => 'required|string|min:3|max:60',
            'dbUser' => 'required|string|min:3|max:60',
            'dbPassword' => 'required|string|min:4|max:200',
            'dbPasswordConfirm' => 'required|same:dbPassword',
            'dbHost' => 'required|string|min:2|max:200',
            'dbPort' => 'required|integer|min:1|max:65535',
            'tablePrefix' => 'required|string|min:1|max:10',
        ];
    }

    protected function messages(): array
    {
        return [
            'dbName.required' => 'Le nom de la base de données est requis.',
            'dbName.string' => 'Le nom de la base de données doit être une chaîne de caractères.',
            'dbName.max' => 'Le nom de la base de données ne doit pas dépasser 60 caractères.',
            'dbName.min' => 'Le nom de la base de données doit contenir au moins 3 caractères.',
            'dbUser.required' => 'Le nom d\'utilisateur est requis.',
            'dbUser.string' => 'Le nom d\'utilisateur doit être une chaîne de caractères.',
            'dbUser.max' => 'Le nom d\'utilisateur ne doit pas dépasser 60 caractères.',
            'dbPassword.required' => 'Le mot de passe est requis.',
            'dbPassword.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'dbPassword.max' => 'Le mot de passe ne doit pas dépasser 200 caractères.',
            'dbHost.required' => 'L\'hôte de la base de données est requis.',
            'dbHost.string' => 'L\'hôte de la base de données doit être une chaîne de caractères.',
            'dbHost.max' => 'L\'hôte de la base de données ne doit pas dépasser 200 caractères.',
            'dbHost.min' => 'L\'hôte de la base de données doit contenir au moins 2 caractères.',
            'dbPort.required' => 'Le port de la base de données est requis.',
            'dbPort.integer' => 'Le port de la base de données doit être un entier.',
            'dbPort.max' => 'Le port de la base de données ne doit pas dépasser 65535.',
            'dbPort.min' => 'Le port de la base de données doit être supérieur à 0.',
            'tablePrefix.required' => 'Le préfixe de table est requis.',
            'tablePrefix.string' => 'Le préfixe de table doit être une chaîne de caractères.',
            'tablePrefix.max' => 'Le préfixe de table ne doit pas dépasser 10 caractères.',
            'tablePrefix.min' => 'Le préfixe de table doit contenir au moins 1 caractère.'
        ];
    }

    public function createDatabase(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (strpos($validatedData['tablePrefix'], '_')) {
            $validatedData['tablePrefix'] = str_replace('_', '', $validatedData['tablePrefix']);
        }
        $validatedData['tablePrefix'] .= '_';

        $databaseModel = new DatabaseModel();
        $databaseModel->setDbName($validatedData['dbName']);
        $databaseModel->setDbUser($validatedData['dbUser']);
        $databaseModel->setDbPassword($validatedData['dbPassword']);
        $databaseModel->setDbHost($validatedData['dbHost']);
        $databaseModel->setDbPort($validatedData['dbPort']);
        $databaseModel->setTablePrefix($validatedData['tablePrefix']);

        if (!$databaseModel->initPdo()) {
            $this->addError('dbName', 'Erreur lors de la connexion à la base de données.');
            return false;
        }

        if ($databaseModel->getPdo()) {
            // fichier sql_config.php
            $configContent = "<?php\n\n"
                . "define('DB_DATABASE', '" . $databaseModel->getDbName() . "');\n"
                . "define('DB_USERNAME', '" . $databaseModel->getDbUser() . "');\n"
                . "define('DB_PASSWORD', '" . $databaseModel->getDbPassword() . "');\n"
                . "define('DB_HOST', '" . $databaseModel->getDbHost() . "');\n"
                . "define('DB_PORT', '" . $databaseModel->getDbPort() . "');\n"
                . "define('DB_PREFIX', '" . $databaseModel->getTablePrefix() . "');\n";

            $filename = __DIR__ . '/../../config/sql_config.php';

            file_put_contents($filename, $configContent);
        }

        if (!$databaseModel->initTables($databaseModel->getTablePrefix())) {
            $this->addError('dbName', 'Erreur lors de l\'initialisation de la base de données.');
            return false;
        }
    
        return true;
    }
}
