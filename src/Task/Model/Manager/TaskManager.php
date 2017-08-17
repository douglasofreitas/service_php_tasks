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
    $results = [];
    $tasks = $this->connection->query('SELECT * FROM tasks ');
    foreach ($tasks as $t) {
      $tagsFormat = [];
      $tags = $this->connection->query('SELECT tg.* FROM tags tg 
        INNER JOIN task_tag tt ON tt.tag_id = tg.id
        WHERE tt.task_id = '.$t['id']);
      foreach ($tags as $t) {
        $tagsFormat[] = array(
          'id' => $t['id'],
          'title' => $t['title'],
          'color' => $t['color']
        );
      }

      $results[] = array(
        'id' => $t['id'],
        'title' => $t['description'],
        'tags' => $tagsFormat
      );
    }
    return $results;
  }

  function insert($task){
    $sql = "INSERT INTO tasks (description) VALUES (:title)";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':title', $task->getDescription());
    $stmt->execute();
    $id = $this->connection->lastInsertId();

    // associate tags to task
    if(!empty($task->getTags())){
        foreach($task->getTags() as $item){
            $tag = new Tag();
            $tag->setTitle($item['title']);
            if(!empty($item['color']) )$tag->setColor($item['color']);
            $tagId = $this->tagManager->insert($tag);
            // insert relation
            $this->insertTag($id, $tagId);
        }
    }

    return $id;
  }

  function insertTag($taskId, $tagId){
    $sql = "INSERT INTO task_tag (task_id, tag_id) VALUES (:task_id, :tag_id)";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':task_id', $taskId);
    $stmt->bindParam(':tag_id', $tagId);
    $stmt->execute();
    return $this->connection->lastInsertId();
  }

  function lastInsertId(){
    return $this->connection->lastInsertId();
  }
}
