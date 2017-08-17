<?php

namespace Acme\Task\Model\Manager;

use Acme\Task\Model\Entity\Tag;
use Acme\Util\Database;

class TagManager 
{

  protected $connection;

  function __construct(){
		$this->connection = Database::getConnection();
	}

  function findAll(){
    return $this->connection->query('SELECT * FROM tags');
  }

  function insert($tag){
    $sql = "INSERT INTO tags (title, color) VALUES (:title, :color)";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':title', $tag->getTitle());
    $stmt->bindParam(':color', $tag->getColor());
    return $stmt->execute();
  }

  function save($tag){
    $sql = 'SELECT * FROM tags WHERE title = "'.$tag->getTitle().'"';
    $result = $this->connection->query($sql);
    if(!empty($result)){
      //update tag
      $sqlUpdate = "UPDATE tags set title = :title, color = :color WHERE id = :id ";
      $stmt = $this->connection->prepare($sqlUpdate);
      $stmt->bindParam(':title', $tag->getTitle());
      $stmt->bindParam(':color', $tag->getColor());
      $stmt->bindParam(':id', $tag->getId());
      return $this->insert($tag);
    }else{
      //insert tag
      $sqlInsert = "INSERT INTO tags (title, color) VALUES (:title, :color)";
      $stmt = $this->connection->prepare($sqlInsert);
      $stmt->bindParam(':title', $tag->getTitle());
      $stmt->bindParam(':color', $tag->getColor());
      return $stmt->execute();
    }
    return $stmt->execute();
  }

  function lastInsertId(){
    return $this->connection->lastInsertId();
  }
}
