<?php

namespace Acme\Task\Model\Entity;

use \PHPUnit_Framework_TestCase;

class TagTest extends PHPUnit_Framework_TestCase
{
    public function testMustBeInstanceOfTag()
    {
        $tag = new Tag();

        $this->assertInstanceOf('Acme\Task\Model\Entity\Tag', $tag);
    }

    public function testMustSetAndGetAttributes()
    {
        $tag = new Tag();
        $tag->setId(10);
        $tag->setTitle('Hello world!');
        $tag->setColor('Hello world!');

        $this->assertEquals(10, $tag->getId());
        $this->assertEquals('Hello world!', $tag->getTitle());
        $this->assertEquals('Hello world!', $tag->getColor());
    }
}
