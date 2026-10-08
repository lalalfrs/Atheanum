<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_primary_pages_render_successfully(): void
    {
        $this->seed();

        $this->get('/')->assertStatus(200);
        $this->get('/books')->assertStatus(200);
        $this->get('/books/create')->assertStatus(200);
        $this->get('/books/1')->assertStatus(200);
        $this->get('/books/1/edit')->assertStatus(200);
        $this->get('/categories')->assertStatus(200);
        $this->get('/inventory')->assertStatus(200);
        $this->get('/laravel-studio')->assertStatus(200);
        $this->get('/settings')->assertStatus(200);
        $this->get('/export/csv')->assertStatus(200);
        $this->get('/export/sql')->assertStatus(200);
    }
}
