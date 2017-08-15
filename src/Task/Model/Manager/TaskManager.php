<?php

namespace Acme\Task\Model\Manager;

use Acme\Task\Model\Entity\Task;
use Acme\Util\Database;

class TaskManager 
{

  protected $connection;

  function __construct(){
		$this->connection = Database::getConnection();
	}

  function findAll(){
    return $this->connection->query('SELECT * FROM tasks');
  }

  function insert($task){
    $sql = "INSERT INTO tasks (description) VALUES (:title)";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':title', $task->getDescription());
    return $stmt->execute();
  }

  function lastInsertId(){
    return $this->connection->lastInsertId();
  }
}
