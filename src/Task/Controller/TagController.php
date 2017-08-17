<?php

namespace Acme\Task\Controller;

use Acme\Task\Model\Entity\Tag;
use Acme\Task\Model\Manager\TagManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class TagController implements ControllerProviderInterface {

    /**
     * @var TagManager
    */ 
    protected $tagManager;

    function __construct(){
      $this->tagManager = new TagManager();
    }
    

    public function connect(Application $app) {
        $factory = $app['controllers_factory'];
        $factory->get('/tags','Acme\Task\Controller\TagController::listAction');
        $factory->post('/tags','Acme\Task\Controller\TagController::createAction');
        $factory->put('/tags/{id}','Acme\Task\Controller\TagController::updateAction');
        return $factory;
    }

    public function listAction()
    {      
        $results = $this->tagManager->findAll();
        $response = array(
            'tags' => [],
        );

        foreach ($results as $t) {
            $response['tags'][] = array(
                'id' => $t['id'],
                'title' => $t['title'],
                'color' => $t['color'],
            );
        }

        return new JsonResponse($response);
    }

    public function createAction()
    {
        $raw_data = file_get_contents("php://input");

        $data = json_decode($raw_data, TRUE);

        $title = isset($data['title']) ? $data['title'] : NULL;
        $color = isset($data['color']) ? $data['color'] : NULL;

        if (strlen($title) < 3) {
            return new JsonResponse([
                'message' => 'The title field must have 3 or more characters'
            ], 422);
        } else {
            $tag = new Tag();
            $tag->setTitle($title);
            $tag->setColor($color);

            $results = $this->tagManager->insert($tag);
            $tagId = $this->tagManager->lastInsertId();
            $tag->setId($tagId);

            return new JsonResponse([
                'id' => $tag->getId(),
                'title' => $tag->getTitle(),
                'color' => $tag->getColor(),
            ], 201);
        }
    }

    public function updateAction($id)
    {
        $raw_data = file_get_contents("php://input");

        $data = json_decode($raw_data, TRUE);

        $title = isset($data['title']) ? $data['title'] : NULL;
        $color = isset($data['color']) ? $data['color'] : NULL;

        if (strlen($title) < 3) {
            return new JsonResponse([
                'message' => 'The title field must have 3 or more characters'
            ], 422);
        } else {
            $tag = new Tag();
            $tag->setId($id);
            $tag->setTitle($title);
            $tag->setColor($color);

            $results = $this->tagManager->update($tag);

            return new JsonResponse([
                'id' => $id,
                'title' => $tag->getTitle(),
                'color' => $tag->getColor(),
            ], 201);
        }
    }
}
