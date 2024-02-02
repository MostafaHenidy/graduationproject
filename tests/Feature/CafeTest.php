<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cafes;

class Cafetest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $cafes = Cafes::factory()->count(3)->create();
        $response = $this->get('/api/cafes');
        $response->assertStatus(200);
        foreach ($cafes as $hospital) {
            $response->assertJsonFragment($hospital->toArray());
        }
    }
    public function testCafeshow()
    {
        $cafes = Cafes::factory()->count(3)->create();
        if ($cafes->count() < 3) {
            $this->markTestSkipped('Not enough cafes in the database to run this test.');
        }
        foreach ($cafes as $cafe) {
            $response = $this->get('/api/cafes/' . $cafe->id);
            $response->assertStatus(200);
            $response->assertJsonFragment($cafe->toArray());
        }
    }
    public function testCafeupdate()
    {
        $cafes = Cafes::factory()->count(3)->create();
        if ($cafes->count() < 3) {
            $this->markTestSkipped('Not enough cafes in the database to run this test.');
        }
        foreach ($cafes as $cafe) {
            $newData = [
                'title' => 'new Hospital title' . $cafe->id,
                'body' => 'new body fucccccck',
                'info' => 123,
                'address' => 'new address',
                'cover_image' => 'new cover image',
            ];
            $response = $this->patch('/api/cafes/' . $cafe->id, $newData);
            $response->assertStatus(200);
            $this->assertDatabaseHas('cafes', $newData);
        }
    }
    public function testCafedelete()
    {
        $cafes = Cafes::factory()->count(3)->create();
        if ($cafes->count() < 3) {
            $this->markTestSkipped('Not enough cafes in the database to run this test.');
        }
        foreach ($cafes as $cafe) {
            $response = $this->delete('/api/cafes/' . $cafe->id);
            $response->assertStatus(200);
            $this->assertDatabaseMissing('cafes', ['id' => $cafe->id]);
        }
    }
}
