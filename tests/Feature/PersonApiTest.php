<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonApiTest extends TestCase
{

    use RefreshDatabase;
    /** @test */
    public function test_getAllPersons()
    {
        $response = $this->getJson('/api/persons', [
                        'name'   => 'Alexis',
                        'status' => 1,
                    ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data', 
                     'meta'  
                 ]);
    }
}