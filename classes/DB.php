<?php

class DB
{

    private $conn;
    public $pdo;

    public function __construct()
    {
        // gobal $conn mi permette di creare una connessione globale per tutto il progetto
        global $conn;
        $this->conn = $conn;
        if (mysqli_connect_errno()) {
            echo 'Failed to connect to Mysql' . mysqli_connect_errno();
            die;
        }
        $this->pdo = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
    // per stampare le eccezioni quando si utilizza l'oggetto PDO
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // metodo di query GET generale che restituisce un array di risultati
    public function query($sql)
    {
        // try {
            $q = $this->pdo->query($sql);
            if (!$q) {
                // se la query è ha essore quindi è falsa mi crea una eccezione
                // throw new Exception("Error executing query...");
                return;
            }
            // se la query è andata a buon fine mi preleva i dati e li inserisce nell'oggetto $data
            $data = $q->fetchAll();
            return $data;
        // } catch (Exception $e) {
        //     throw $e;
        // }
    }

    // metodo di chiamata PUT generale che esegue l'inserimento dei dati nel DB quando non voglio ricevere nulla di riscontro, per esempio una query di update 
    public function execute($sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    // metodo select_all dove passo un nome della tabella e un array di colonne
    public function select_all(string $tableName, $columns = array())
    {

        $query = 'SELECT ';

        $strCol = implode(', ', $columns);

        $query .= $strCol . ' FROM ' . $tableName;

        $result = mysqli_query($this->conn, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_free_result($result);
        return $resultArray;
    }


    public function select_one(string $tableName, $columns, $id)
    {

        $strCol = implode(',', $columns);
        $query = "SELECT $strCol FROM $tableName WHERE id = $id";

        $result = mysqli_query($this->conn, $query);
        $resultArray = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        return $resultArray;
    }

    public function delete_one($tableName, $id)
    {
        $query = "DELETE FROM $tableName WHERE id = $id";

        if (mysqli_query($this->conn, $query)) {
            $rowsAffected = mysqli_affected_rows($this->conn);

            return $rowsAffected;
        } else {
            return -1;
        }
    }

    public function update_one(string $tableName, array $columns, int $id)
    {

        $strCol = '';
        foreach ($columns as $colName => $colValue) {
            $strCol .= " " . $colName . " = '$colValue' , ";
        }
        $strCol = substr($strCol, 0, -1);



        $query = "UPDATE $tableName SET $strCol WHERE id = $id";
        $query = str_replace("'NULL'", "NULL", $query);
        // var_dump($query); die;
        if (mysqli_query($this->conn, $query)) {
            $rowsAffected = mysqli_affected_rows($this->conn);

            return $rowsAffected;
        } else {
            return -1;
        }
    }

    public function insert_one($tableName, $columns = array())
    {

        $strColValue = '';
        $colNames = '';
        foreach ($columns as $colName => $colValue) {
            $strColValue .= " '" . $colValue . "' ,";
            $colNames .= " `" . $colName . "` ,";
        }
        $strColValue = substr($strColValue, 0, -1);
        $colNames = substr($colNames, 0, -1);

        // $colNames = implode(',', array_keys($columns));
        // $strColValue = implode(',' . array_fill(0, count($columns), '?'));

        $query = "INSERT INTO $tableName ($colNames) VALUES ($strColValue)";


        if (mysqli_query($this->conn, $query)) {
            $lastId = mysqli_insert_id($this->conn);

            return $lastId;
        } else -1;
    }
}

class DBManager
{
    protected $db;
    protected $columns;
    protected $tableName;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function get($id)
    {
        $resultArr = $this->db->select_one($this->tableName, $this->columns, (int)$id);
        return (object) $resultArr;
    }

    public function getAll()
    {
        $results = $this->db->select_all($this->tableName, $this->columns);
        $objects = array();
        foreach ($results as $result) {
            array_push($objects, (object)$result);
        }
        return $objects;
    }

    public function create($obj)
    {
        $newId = $this->db->insert_one($this->tableName, (array) $obj);
        return $newId;
    }

    public function delete($id)
    {
        $rowsDeleted = $this->db->delete_one($this->tableName, (int)$id);
        return (int) $rowsDeleted;
    }

    public function update($obj, $id)
    {
        $rowsUpdated = $this->db->update_one($this->tableName, (array) $obj, (int) $id);
        return (int) $rowsUpdated;
    }
}
