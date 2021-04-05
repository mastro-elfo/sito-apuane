<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Query
{
    // SQL method [SELECT, INSERT INTO, UPDATE, DELETE]
    protected $_method = null;
    // The table name for INSERT INTO, UPDATE
    protected $_table = null;
    // The FROM statement for SELECT and DELETE
    protected $_from = "";
    // The WHERE statement
    protected $_where = null;
    // The ORDER BY statement
    protected $_order = [];
    // The LIMIT statement
    protected $_limit = null;
    // List of columns for SELECT
    protected $_selectCols = null;
    // List of columns for INSERT INTO and UPDATE
    protected $_columns = [];
    // List of values for INSERT INTO
    protected $_values = [];
    // List of column=value for UPDATE
    protected $_set = [];
    // List of inner joins
    protected $_joins = [];

    /**
     * This is where all the magic happens.
     *
     * This method creates a query string when the object is cast to a string (`(string) $query`).
     * @return string
     */
    public function __toString()
    {
        $query = "$this->_method";

        if ($this->_selectCols) {
            if (is_array($this->_selectCols)) {
                $query .= " " . implode(", ", $this->_selectCols);
            } else {
                $query .= " $this->_selectCols";
            }
        }

        if ($this->_from) {
            $query .= " FROM $this->_from";
        }

        if ($this->_table) {
            $query .= " $this->_table";
        }

        if ($this->_columns) {
            $query .= " (" . implode(", ", $this->_columns) . ")";
        }

        if ($this->_values) {
            $query .= " VALUES (" . implode(", ", $this->_values) . ")";
        }

        if ($this->_set) {
            $query .= " SET " . implode(", ", $this->_set);
        }

        foreach ($this->_joins as $join => $on) {
            $query .= " INNER JOIN $join ON $on";
        }

        if ($this->_where) {
            $query .= " WHERE $this->_where";
        }

        if ($this->_order) {
            $query .= " ORDER BY " . implode(", ", $this->_order);
        }

        if ($this->_limit) {
            $query .= " LIMIT $this->_limit";
        }

        return $query;
    }

    /**
     * Sets "SELECT" statement
     * @param  string|array $cols The string "*", or a comma separated list of columns, or a list of columns
     * @return Query
     */
    public function select($cols = "*")
    {
        $this->_selectCols = $cols;
        $this->_method     = "SELECT";
        return $this;
    }

    /**
     * Sets "INSERT INTO" method
     * @param  string $table
     * @return Query
     */
    public function insert($table)
    {
        $this->_table  = $table;
        $this->_method = "INSERT INTO";
        return $this;
    }

    /**
     * Sets method "UPDATE"
     * @param  string $table
     * @return Query
     */
    public function update($table)
    {
        $this->_table  = $table;
        $this->_method = "UPDATE";
        return $this;
    }

    /**
     * Sets method "DELETE"
     * @return Query
     */
    public function delete()
    {
        $this->_method = "DELETE";
        return $this;
    }

    /**
     * Sets "SET" statement
     * @param array $cols Associative array like `["column" => <value>, ...]`
     * @return Query
     */
    public function set($cols = [])
    {
        $this->_set = array_merge($this->_set, array_map(
            fn($k, $v) => "$k = $v",
            array_keys($cols),
            array_values($cols)
        ));
        return $this;
    }

    /**
     * Sets values for "INSERT INTO" statement
     * @param  array  $cols Associative array like `["column" => <value>, ...]`
     * @return Query
     */
    public function values($cols = [])
    {
        // $this->_columns = implode(", ", array_keys($cols));
        // $this->_values  = implode(", ", array_values($cols));
        $this->_columns = array_merge($this->_columns, array_keys($cols));
        $this->_values  = array_merge($this->_values, array_values($cols));
        return $this;
    }

    /**
     * Sets "FROM" statement
     * @param  string|array $table Table's name, or a list of tables' names
     * @return Query
     */
    public function from($table)
    {
        $this->_from = $table;
        return $this;
    }

    /**
     * Set "INNER JOIN" table/condition statement
     * @param  string $join table
     * @param  string $on   condition
     * @return Query
     */
    public function join($join, $on)
    {
        $this->_joins[$join] = $on;
        return $this;
    }

    /**
     * Sets "ORDER BY" statement
     * @param  array $condition Associative array like `["column" => "ASC|DESC", ...]`
     * @return Query
     */
    public function order($condition)
    {
        if (is_string($condition)) {
            array_push($this->_order, $condition);
        } else {
            $this->_order = array_merge($this->_order, $condition);
        }
        return $this;
    }

    /**
     * Sets "LIMIT" statement
     * @param  int $offset
     * @param  int $limit   If `null`, `$offset` becomes the limit
     * @return Query
     */
    public function limit($offset, $limit = null)
    {
        if (is_null($limit)) {
            $this->_limit = " $offset";
        } else {
            $this->_limit = " $offset, $limit";
        }
        return $this;
    }

    /**
     * Sets "WHERE" statement
     * @param  string $condition
     * @return Query
     */
    public function where($condition)
    {
        $this->_where = $condition;
        return $this;
    }

    /**
     * Sets an "AND" condition
     * @param  string $condition
     * @return Query
     */
    function  and ($condition) {
        if (is_string($condition)) {
            $this->_where .= " AND $condition";
        } elseif (is_array($condition) && count($condition)) {
            $this->_where .= " AND " . implode("AND", $condition);
        }
        return $this;
    }

    /**
     * Sets an "OR" condition
     * @param  string $condition
     * @return Query
     */
    function  or ($condition) {
        if (is_string($condition)) {
            $this->_where .= " OR $condition";
        } elseif (is_array($condition) && count($condition)) {
            $this->_where .= " OR " . implode(" OR ", $condition);
        }
        return $this;
    }
}
