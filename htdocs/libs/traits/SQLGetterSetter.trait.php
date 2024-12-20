<?php

/**
 * To use this trait, the PHP Object's constructor should have 
 * #id, $conn, $table variables set
 * 
 * $id - the ID of the MySQL Table Row
 * $conn - The MySQL Connection
 * $table - the MySQL Table Name
 */
trait SQLGetterSetter
{
    public function __call($name, $arguments)
    {
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));

        if (substr($name, 0, 3) == "get") {
            return $this->_get_data($property);
        } elseif (substr($name, 0, 3) == "set") {
            return $this->_set_data($property, $arguments[0]);
        } else {
            throw new Exception(__CLASS__ . "::__call()-> $name, function unavalaible.");
        }
    }
    //this function helps to retrieve data from the database
    private function _get_data($var)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "SELECT `$var` FROM `$this->table` WHERE `id` = $this->id";
        $result = $this->conn->query($sql);
        if ($result and $result->num_rows == 1) {
            return $result->fetch_assoc()["$var"];
        } else {
            error_log(__CLASS__ . "::__call()-> $var, field unavalaible.");
            return false;
            // throw new Exception(__CLASS__ . "::__call()-> $var, field unavalaible.");
        }
    }

    //This function helps to  set the data in the database
    private function _set_data($var, $data)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            if ($data === 'INCREMENT') {
                $sql = "UPDATE `$this->table` SET `$var` = `$var` + 1 WHERE `id` = $this->id;";
            } elseif ($data === 'DECREMENT') {
                $sql = "UPDATE `$this->table` SET `$var` = `$var` - 1 WHERE `id` = $this->id;";
            } else {
                $sql = "UPDATE `$this->table` SET `$var` = '$data' WHERE `id` = $this->id;";
            }

            if ($this->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::__call()-> $var, data unavalaible.");
        }
    }
    public function delete()
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            $sql = "DELETE FROM `$this->table` WHERE `id`=$this->id;";
            if ($this->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::delete, data unavailable.");
        }
    }
}
