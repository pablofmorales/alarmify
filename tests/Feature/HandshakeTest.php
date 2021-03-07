<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HandshakeTest extends TestCase
{
    /**
     * @test
     */
    public function AValidApplicationHandShakeWithUs()
    {
        $appName = 'testDummy';
        $response = $this->get('/handshake/' . $appName);

        $response->assertStatus(202);
    }

    /**
     * @test
     */
    public function AnNonExistentAppWhantToHandShakeWithUs()
    {
        $appName = 'dummyFailTest';
        $response = $this->get('/handshake/' . $appName);
        $response->assertStatus(404);
    }
}
