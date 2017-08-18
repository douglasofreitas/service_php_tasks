<?php

namespace Acme\Task\Model\Entity;

use \PHPUnit_Framework_TestCase;

class TaskTest extends PHPUnit_Framework_TestCase
{
    public function testMustBeInstanceOfTask()
    {
        $task = new Task();

        $this->assertInstanceOf('Acme\Task\Model\Entity\Task', $task);
    }

    public function testMustSetAndGetAttributes()
    {
        $tags = array(    
            (Object) array(
                'title' => $colorTitle,
                'color' => 'red'
            )
        );

        $task = new Task();
        $task->setId(10);
        $task->setDescription('Hello world!');
        $task->setTags($tags);

        $this->assertEquals(10, $task->getId());
        $this->assertEquals('Hello world!', $task->getDescription());
        $this->assertEquals($tags, $task->getTags());
    }
}
