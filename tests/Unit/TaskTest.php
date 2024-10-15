<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatePost()
    {
        $response = $this->get('/task');

        $response->assertStatus(201);
    }
}
