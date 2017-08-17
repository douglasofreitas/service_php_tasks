<?php

namespace Acme\Task\Model\Manager;

use Acme\Task\Model\Entity\Task;
use Acme\Task\Model\Entity\Tag;
use Acme\Task\Model\Manager\TagManager;
use Acme\Util\Database;

class TaskManager 
{

  protected $connection;
  protected $tagManager;

  function __construct(){
		$this->connection = Database::getConnection();
    $this->tagManager = new TagManager();
	}

  function findAll(){
    $tag = new Tag();
    $tag->setTitle('Tag1');
    $this->tagManager->save($tag);
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
