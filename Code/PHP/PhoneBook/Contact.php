<?php
class Contact
{
    private $name;
    private $phone ;
    private $address;
    private $notes ;

    private function isValid($var, $min_limit)
    {
        if(strlen(trim($var)) >= $min_limit) {
            return true;
        }
        return false;
    }

    public function __construct($name, $phone, $address='', $notes='')
    {
        if($this->isValid($name, 3)&& $this->isValid($phone, 3)) {
            $this->name    = addslashes(trim($name));
            $this->phone   = addslashes(trim($phone));
            $this->address = addslashes(trim($address));
            $this->notes   = addslashes(trim($notes));
        } else if (!$this->isValid($name, 3)) {
            throw new Exception('The name is too short.');
        } else if (!$this->isValid($phone, 3)) {
            throw new Exception('The phone number is too short.');
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public static function printTable($sql)
    {
        $temp = DataBaseActions::run_q($sql);
        while($row = mysql_fetch_assoc($temp))
        {
            $tmp='<tr class="content"><td>'.$row['name'].'</td><td>'.$row['phone'].'</td>
                  <td>'.$row['address'].'</td><td>'.$row['notes'].'</td>
                  <td class="try"><a href="index.php?mode=edit&id='.$row['contact_id'].'">Edit</a></td>
                  <td class="try"><a href="index.php?mode=delete&id='.$row['contact_id'].'">Delete</a></td></tr>';
            echo $tmp;
        }
    }
}
