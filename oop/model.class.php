<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/database.class.php";
require_once __DIR__ . "/query.class.php";

class Model
{
    // Riferimento all'oggetto `Database`
    protected $_db = null;
    // Nome della tabella di riferimento
    protected $_table = null;
    // ID dell'oggetto
    protected $_id = null;

    /**
     * Costruttore
     * @param string $table tabella di riferimento
     * @param int $id  id dell'oggetto
     */
    public function __construct($table, $id = null)
    {
        $this->_db    = Database::connect();
        $this->_table = $table;
        $this->_id    = $id;
    }

    /**
     * Alias for `$this->_db->query`
     */
    public function query($query)
    {
        return $this->_db->query((string) $query);
    }

    /**
     * Creo una nuova riga nel db
     * @param $columns `array` associativo `["colonna" => <valore>, ...]`
     * @return int ultimo id inserito o `null` in caso di errore
     */
    public function create($columns)
    {
        $query = (new Query)
            ->insert($this->_table)
            ->values(array_combine(
                array_keys($columns),
                array_map(
                    fn($s) => $this->clean($s),
                    array_values($columns))
            ));

        $ret = $this->query($query);
        if ($ret) {
            return $this->_db->get_last_id();
        }
        return null;
    }

    /**
     * Leggo una riga dal db
     * @param  string $columns Elenco delle colonne da leggere
     * @return array dei risultati o `null` in caso di errore
     */
    public function read($columns = "*", $ands = [])
    {
        $query = (new Query)
            ->select($columns)
            ->from($this->_table)
            ->where("id = $this->_id")
            ->and("deleted = 0");
        // Add `$ands`
        foreach ($ands as $and) {
            $query->and($and);
        }
        // Query
        $ret = $this->query($query);
        if ($ret) {
            return $ret->fetch_assoc();
        }
        return null;
    }

    /**
     * Aggiorna una riga nel db
     * @param  array $columns array associativo `["colonna" => <valore>, ...]`
     * @return int numero di righe aggiornate o `null` in caso di errore
     */
    public function update($columns, $ands = [])
    {
        $query = (new Query)
            ->update($this->_table)
            ->set(array_combine(
                array_keys($columns),
                array_map(fn($s) => $this->clean($s), array_values($columns))
            ))
            ->where("id = $this->_id")
            ->and("deleted = 0");
        // Add `$ands`
        foreach ($ands as $and) {
            $query->and($and);
        }
        // Query
        $ret = $this->query($query);
        if ($ret) {
            return $this->_db->get_affected();
        }
        return null;
    }

    /**
     * Elimina una riga dal db
     * @return int numero di righe aggiornate o `null` in caso di errore
     */
    public function delete($force = false, $ands = [])
    {
        $query = (new Query);
        if ($force) {
            // Delete row from table
            $query->delete()->from($this->_table);
        } else {
            // Soft delete
            $query->update($this->_table)->set(["deleted" => 1]);
        }
        $query->where("id = $this->_id");
        // Add `$ands`
        foreach ($ands as $and) {
            $query->and($and);
        }
        // Query
        $ret = $this->query($query);
        if ($ret) {
            return $this->_db->get_affected();
        }
        return null;
    }

    /**
     * Applica `real_escape_string` a `$value`
     * @param  string $value Valore input
     * @return string
     */
    protected function clean($value)
    {
        if (is_string($value)) {
            return "'" . $this->_db->clean($value) . "'";
        }
        return $value;
    }
}
