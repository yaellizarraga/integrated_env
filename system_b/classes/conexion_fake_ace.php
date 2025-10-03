<?php 

class Conexion
{
  protected $host;
  protected $user;
  protected $password;
  public $database;
  protected $port;
  public $con;
  public $result;

  public function conectar()
  {
    $this->host = 'localhost';
    $this->user = 'root';
    $this->password = '';
    $this->database = 'fake_ace_core';
    $this->port = 3306;
    try {
      $this->con = mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port);
      mysqli_query($this->con, "set session sql_mode=''");
      return $this->con;
    } catch (mysqli_sql_exception  $e) {
      throw $e;
    }
  }
  public function query($sql)
  {
    mysqli_query($this->con, "SET NAMES 'utf8';");
    if ($this->result = mysqli_query($this->con, $sql)) {
      return $this->result;
    } else {
      return false;
    }
  }
  public function desconectar($conexion)
  {
    try {
      mysqli_close($conexion);
    } catch (mysqli_sql_exception $e) {
      throw $e;
    }
  }
}
