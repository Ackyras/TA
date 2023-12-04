<?php

namespace Tests\Feature\Iteration1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class US1 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_new_user()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
