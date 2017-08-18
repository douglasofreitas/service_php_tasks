<?php

namespace Acme\Task\Model;

use \PHPUnit_Framework_TestCase;
use GuzzleHttp\Client;

class TagControllerTest extends PHPUnit_Framework_TestCase
{
    protected $httpClient;

    protected function setUp()
    {
        $this->httpClient = new Client([
            'base_uri' => 'http://127.0.0.1',
            'http_errors' => false,
        ]);
    }

    public function testMustAddTagWithSuccess()
    {
        $title = 'The tag - ' . date('U');
        $color = 'red';
        $response = $this->httpClient->post('/tags', [
            'json' => [
                'title' => $title,
                'color' => $color
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('color', $data);
        $this->assertEquals($title, $data['title']);
        $this->assertEquals($color, $data['color']);
    }

    public function testMustUpdateTagWithSuccess()
    {
        $title = 'The tag - ' . date('U');
        $color = 'blue';
        
        $response = $this->httpClient->put('/tags/1', [
            'json' => [
                'title' => $title,
                'color' => $color
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('color', $data);
        $this->assertEquals($title, $data['title']);
        $this->assertEquals($color, $data['color']);
    }

}
