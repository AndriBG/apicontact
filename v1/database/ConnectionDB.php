<?php 

    include_once '../FileHandler/JsonFileHandler.php';

    class ConnectionDB {

        public $db;
        private $fileHandler;
    
        public function __construct($directory){
            // instancia un objeto de manejador de json.
            $this->fileHandler = new JsonFileHandler($directory,'configuration');
            $configuration = $this->fileHandler->readFile();
            // var_dump($configuration->server);die;

            $this->db = new mysqli($configuration->server,$configuration->user,$configuration->password,$configuration->database);

            if($this->db->connect_error){
                exit('Error conectando a la base de datos');
            }
        }

    }





















    // function connect($db) 
    // {
    //     try {
    //         $con = new PDO("mysql:host={$db['host']};dbname={$db['database']}", $db['username'], $db['password']);
    //         $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //     } catch (PDOException $ex) {
    //         exit($ex->getMessage());
    //     }
    // }

    function getParams($input) 
    {
        $filterParams = [];
        foreach($input as $param => $value) 
        {
            $filterParams[] = "$param=:$param";
        }

        return implode(', ', $filterParams);
    }

    function bindAllValues($statement, $params) 
    {
        foreach($params as $param => $value) 
        {
            $statement->bindValue(':'.$param,$value);
        }

        return $statement;
    }

?>