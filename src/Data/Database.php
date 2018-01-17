<?php

namespace FramePHP\Data;
use PDO;

/**
*
*/
class Database extends PDO
{
  private $provides = [
    'DB' => DataModel::class
  ];

  public function __construct($hostname,$dbname,$username,$password)
  {
    $dsn = 'mysql:host='.$hostname.';dbname='.$dbname;
    parent::__construct($dsn, $username, $password);

    try
    {
      $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
      die($e->getMessage());
    }
  }

}
