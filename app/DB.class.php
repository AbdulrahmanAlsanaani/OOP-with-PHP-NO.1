<?php
class DB{
    private $name;
    private $conn = mysqli_connect('localhost', 'root', '', 'e-store');
    private $host;
    private $username;
    private $password;
    private $db_name;

    public function __construct(
        $host='localhost',
        $username='root',
        $password='',
        $db_name='e-store'
    )
    {
        $this->host=$host;
        $this->username=$username;
        $this->password=$password;
        $this->db_name=$db_name;
        $this->conn=mysqli_connect($this->host,$this->username,$this->password,$this->db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function getConnection()
    {
        return $this->conn;
    }

}
?>