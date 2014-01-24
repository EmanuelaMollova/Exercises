<?php
class DataBaseActions
{
    private $db_name     = 'phonebook';
    private $db_username = 'Emanuela';
    private $db_host     = 'localhost';

    public function connect()
    {
        mysql_connect($this->db_host, $this->db_username) or die('Error with the database.');
        mysql_select_db($this->db_name) or die ('Error with the database.');
    }

    public static function run_q($sql)
    {
        mysql_query('SET NAMES utf8');
        return mysql_query($sql);
    }

    public function insert($obj)
    {
        DataBaseActions::run_q(
            'INSERT INTO contacts (name, address, phone, notes)
            VALUES ("'.addslashes($obj->getName()).'", "'.addslashes($obj->getAddress()).'",
            "'.addslashes($obj->getPhone()).'", "'.addslashes($obj->getNotes()).'")'
        );
    }

    public function update($obj, $id)
    {
        DataBaseActions::run_q(
            'UPDATE contacts SET name="'.$obj->getName().'",
            address="'.$obj->getAddress().'", phone="'.$obj->getPhone().'",
            notes="'.$obj->getNotes().'" WHERE contact_id='.$id
        );
    }

    public function delete($id)
    {
        DataBaseActions::run_q('DELETE FROM contacts WHERE contact_id='.$id);
    }

   public function sortTable($field, $mode)
    {
        $sql='SELECT * FROM contacts ORDER BY `'.$field.'`'.$mode;
        return $sql;
    }

    public function search($field, $value)
    {
        $keywords = explode(' ', $value);
        $query = 'SELECT * FROM contacts WHERE';
        foreach ($keywords as $key) {
            $query .= ' `'.$field.'` LIKE "%'.$key.'%" AND';
        }
        $query = rtrim($query,' AND');
        return $query;
    }
}

/*
public function search($field, $value)
     {
          $sql = DataBaseActions::run_q("SELECT * FROM contacts WHERE MATCH(".$field.") AGAINST('$value')");
          echo mysql_error();
          return $sql;
     }
*/
