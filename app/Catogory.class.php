<?php
require_once('DB.class.php');
class Category
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getNname()
    {
        return $this->name;
    }

    public function getAllCategory()
    {
        $conn = new DB();
        $sql = "select * from category where is_active=1";
        return $conn->getConnection()->query($sql);
    }
}
