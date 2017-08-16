<?php

namespace Acme\Task\Controller;

use Acme\Task\Model\Entity\Task;
use Acme\Task\Model\Manager\TaskManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class TaskController implements ControllerProviderInterface {

    /**
     * @var TaskManager
    */ 
    protected $taskManager;

    function __construct(){
      $this->taskManager = new TaskManager();
    }
    

    public function connect(Application $app) {
        $factory = $app['controllers_factory'];
        $factory->get('/tasks','Acme\Task\Controller\TaskController::listAction');
        $factory->post('/tasks','Acme\Task\Controller\TaskController::createAction');
        return $factory;
    }

    public function listAction()
    {      
        $results = $this->taskManager->findAll();
        $response = array(
            'tasks' => [],
        );

        foreach ($results as $t) {
            $response['tasks'][] = array(
                'id' => $t['id'],
                'title' => $t['description'],
            );
        }

        return new JsonResponse($response);
    }

    public function createAction()
    {
        $raw_data = file_get_contents("php://input");

        $data = json_decode($raw_data, TRUE);

        $title = isset($data['title']) ? $data['title'] : NULL;

        if (strlen($title) < 3) {
            return new JsonResponse([
                'message' => 'The title field must have 3 or more characters'
            ], 422);
        } else {
            $task = new Task();
            $task->setDescription($title);

            $results = $this->taskManager->insert($task);

            $task->setId($this->taskManager->lastInsertId());

            return new JsonResponse([
                'id' => $task->getId(),
                'title' => $task->getDescription(),
            ], 201);
        }
    }
}
