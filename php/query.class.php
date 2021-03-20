<?php

class Query
{
    protected $_method = null;
    protected $_table  = null;
    protected $_from   = null;
    protected $_where  = null;
    protected $_order  = null;
    protected $_limit  = null;

    __toString() {return "";}function select()
    {
        $this->_method = "SELECT";
        return $this;
    }

    function insert()
    {
        $this->_method = "INSERT INTO";
        return $this;
    }

    function update()
    {
        $this->_method = "UPDATE";
        return $this;
    }

    function delete()
    {
        $this->_method = "DELETE";
        return $this;
    }

    function table($t)
    {
        $this->_table("`$t`");
        return $this;
    }

    function from($t)
    {
        if (is_string($t)) {
            $this->_from = "`$t`";
        } elseif (is_array($t)) {
            $this->_from = implode(", ", array_map(fn($i) => "`$i`", $t));
        }
        return $this;
    }

    function order($o)
    {
        $this->_order = implode(", ", array_map(fn($i, $k) => "$i $k"), array_values($o), array_keys($o));
        return $this;
    }
}
