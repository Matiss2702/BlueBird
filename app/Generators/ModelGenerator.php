<?php

namespace App\Generators;

use \PDO;
use \PDOException;

// TODO : Refaire le générateur pour s'adapter au nouveau format lié a l'ORM
class ModelGenerator
{
    private $pdo;
    private $table;

    private static $db_dsn       = 'pgsql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT;
    private static $db_username  = DB_USERNAME;
    private static $db_password  = DB_PASSWORD;

    public function  __construct($tableName)
    {
        try {
            $this->pdo = new PDO(self::$db_dsn, self::$db_username, self::$db_password);
        } catch (PDOException $p) {
            die("Erreur lors de la connexion à la BD : " . $p->getCode() ." => ". $p->getMessage());
        }

        if (strpos($tableName, DB_PREFIX) !== false) {
            $this->table = str_replace(DB_PREFIX, '', $this->table);
        } else {
            $this->table = $tableName;
        }
    }

    public function generateModel()
    {
        if (!preg_match('/^[a-zA-Z_]+$/', $this->table)) {
            exit("Nom de table invalide. Le nom de table ne doit contenir que des lettres et des underscores.\n");
        }

        $columns = $this->fetchModelProperties($this->table);

        if (!$columns) {
            die("Génération impossible ! Vérifiez si la table existe et qu'elle contient au minimum une colonne.");
        }

        $className = $this->convertTableNameToClassName($this->table);
        $code = $this->generateClassCode($className, $columns);
        $path = 'Models/';
        $filename = "$className.php";
        file_put_contents($path.$filename, $code);
        chmod($path.$filename, 0666);

        echo "Classe $className générée dans le fichier $filename.\n";
    }

    private function fetchModelProperties()
    {
        $stmt = $this->pdo->prepare("SELECT column_name FROM information_schema.columns WHERE table_name = :table_name");
        $stmt->execute(['table_name' => DB_PREFIX . $this->table]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function convertTableNameToClassName()
    {
        $className = ucwords(str_replace('_', ' ', $this->table));
        $className = str_replace(' ', '', $className);
        return $className;
    }

    private function generateClassCode($className, $columns)
    {
        $code = "<?php\n\n";
        $code .= "namespace App\Models;\n\n";
        $code .= "use App\Core\SQL;\n\n";
        $code .= "class $className extends SQL\n";
        $code .= "{\n";

        foreach ($columns as $column) {
            $code .= "    protected \$$column;\n";
        }

        $code .= "\n";

        foreach ($columns as $column) {
            $camelColumn = snakeToCamelCase($column);

            $code .= "    public function get$camelColumn()\n";
            $code .= "    {\n";
            $code .= "        return \$this->$column;\n";
            $code .= "    }\n";

            $code .= "\n";

            $code .= "    public function set$camelColumn(\$$column)\n";
            $code .= "    {\n";
            $code .= "        \$this->$column = \$$column;\n";
            $code .= "    }\n";

            $code .= "\n";
        }

        $code .= "}\n";

        return $code;
    }

}