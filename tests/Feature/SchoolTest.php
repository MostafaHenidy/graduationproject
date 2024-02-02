<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Schools;

class SchoolTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $schools = Schools::factory()->count(3)->create();
        $response = $this->get('/api/schools');
        $response->assertStatus(200);
        foreach ($schools as $school) {
            $response->assertJsonFragment($school->toArray());
        }
    }
    public function testSchoolshow()
    {
        $schools = Schools::factory()->count(3)->create();
        if ($schools->count() < 3) {
            $this->markTestSkipped('Not enough schools in the database to run this test.');
        }
        foreach ($schools as $school) {
            $response = $this->get('/api/schools/' . $school->id);
            $response->assertStatus(200);
            $response->assertJsonFragment($school->toArray());
        }
    }
    public function testSchoolupdate()
    {
        $schools = Schools::factory()->count(3)->create();
        if ($schools->count() < 3) {
            $this->markTestSkipped('Not enough schools in the database to run this test.');
        }
        foreach ($schools as $school) {
            $newData = [
                'title' => 'new school title' . $school->id,
                'body' => 'new body fucccccck',
                'info' => 123,
                'address' => 'new address',
                'cover_image' => 'new cover image',
            ];
            $response = $this->patch('/api/schools/' . $school->id, $newData);
            $response->assertStatus(200);
            $this->assertDatabaseHas('schools', $newData);
        }
    }
    public function testSchooldelete()
    {
        $schools = Schools::factory()->count(3)->create();
        if ($schools->count() < 3) {
            $this->markTestSkipped('Not enough schools in the database to run this test.');
        }
        foreach ($schools as $school) {
            $response = $this->delete('/api/schools/' . $school->id);
            $response->assertStatus(200);
            $this->assertDatabaseMissing('schools', ['id' => $school->id]);
        }
    }
}
