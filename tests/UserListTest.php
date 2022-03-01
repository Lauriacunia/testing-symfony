<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserListTest extends WebTestCase
{
    public function testGetUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //$this->assertResponseIsSuccessful();
       // $this->assertSelectorTextContains('h1', 'Hello World');


    }
    // public function testMethodNotAllowed(): void
    // {
    //     $client = static::createClient();
    //     $client->request('POST', '/user');

    //     $this->assertEquals(405, $client->getResponse()->getStatusCode());
    // }

    public function testCreateUser(): void
    {
        $client = static::createClient();

        /**Se crea un cliente para simular el post */
        $client->request('POST', '/user', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode([
            'name' => 'John Doe',
            'email' => 'john@api',
            'phone' => 123456789
        ]));
        /** Se chequea que responda 201 created */
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        /** Se chequea que la response sea la esperada */
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'message' => 'User created!',
                'name' => 'John Doe',
                'email' => 'john@api',
                'phone' => 123456789
            ]),
            $client->getResponse()->getContent()
        );
    }
}
