<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database
{
    // Singleton instance of this class
    protected static $_object = null;
    // Riferimento all'oggetto `mysqli`
    protected $_db = null;

    public static function connect()
    {
        if (Database::$_object === null) {
            Database::$_object = new Database();
        }
        return Database::$_object;
    }

    /**
     * Costruttore
     */
    protected function __construct()
    {
        $configfile = __DIR__ . "/database.ini";
        if (is_file($configfile)) {
            // Load config from file
            $config = parse_ini_file($configfile);
            $mysqli = new mysqli(
                $config["host"],
                $config["username"],
                $config["password"],
                $config["database"]
            );
            if (!$mysqli->connect_errno) {
                $this->_db = $mysqli;
            }
        }
    }

    /**
     * Distruttore
     *
     * Chiudo la connessione.
     */
    public function __destruct()
    {
        if ($this->_db) {
            $this->_db->close();
        }
        $this->_db = null;
    }

    /**
     * Eseguo la query
     * @param  string $query Query da eseguire
     * @return        Esito della query
     */
    public function query($query)
    {
        if ($this->_db) {
            return $this->_db->query($query);
        }
        return null;
    }

    /**
     * Ottiene l'ultimo id inserito in caso di query `INSERT INTO`
     * @return int
     */
    public function get_last_id()
    {
        if ($this->_db) {
            return $this->_db->insert_id;
        }
        return null;
    }

    /**
     * Ottiene il numero di righe modificate o eliminate in caso di query `UPDATE` o `DELETE`
     * @return int
     */
    public function get_affected()
    {
        if ($this->_db) {
            return $this->_db->affected_rows;
        }
        return null;
    }

    /**
     * Applica l'escape ai caratteri
     * @param  string $string
     * @return string
     */
    public function clean($string)
    {
        if ($this->_db) {
            return $this->_db->real_escape_string($string);
        }
        return $string;
    }
}
