<?php
include 'DataBaseActions.php';

class Pagination
{
    private $limit;
    private static $all = 0;
    private $last_page;
    private $page;

    public function __construct($limit = 5, $page = 0)
    {
        $this->limit     = $limit;
        $this->page      = $page;
        $this->last_page = ceil(Pagination::$all / $this->limit);
    }

    public function setAll($sql)
    {
        $temp            = DataBaseActions::run_q($sql);
        Pagination::$all = mysql_num_rows($temp);
        $this->last_page = ceil(Pagination::$all / $this->limit);
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function pageQuery($sql)
    {
        $newsql = $sql.' LIMIT '.$this->page*$this->limit.','.$this->limit;
        return $newsql;
     }

    public function printPages()
    {
        if($this->page > 0) {
            echo '<a href="index.php?page='.($this->page).'">Previous</a>';
        }

        echo ' | ';
        for($i = 0; $i < $this->last_page; $i++) {
            if($i == $this->page) {
                echo ($i + 1);
            } else {
                echo '<a href="index.php?page='.($i + 1).'">'.($i + 1).' </a>';
            }
            echo ' | ';
        }

        if($this->page < ($this->last_page - 1)) {
            echo '<a href="index.php?page='.($this->page + 2).'"> Next</a><br>';
        }
    }
}
