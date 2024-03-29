<?php

namespace Tests\Feature;

use App\Http\Requests\StoreSchoolsRequest;
use App\Http\Resources\Place\SchoolResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Schools;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
class SchoolTest extends TestCase
{
    use RefreshDatabase;

    private $schools;
    public function setUp(): void
    {
        parent::setUP();
        $this->schools = schools::factory()->count(3)->create();
        if ($this->schools->count() < 3) {
            $this->markTestSkipped('Not enough schools in the database to run this test.');
        }
    }

    public function testSchoolindex()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get('/api/schools');
        $response->assertOk();
        foreach ($this->schools as $school) {
            $resource = new SchoolResource($school);
            $transfomedschool = $resource->toArray(request());
            $response->assertJsonFragment($transfomedschool);
        }
    }
    public function testSchoolshow()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->schools as $school) {
            $response = $this->get('/api/schools/' . $school->id);
            $response->assertOK();
            $resource = new SchoolResource($school);
            $transfomedschool = $resource->toArray(request());
            $response->assertJsonFragment($transfomedschool);
        }
    }
    public function testschoolstore()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $newschoolData = [
            'title' => 'new school',
            'address' => '123 new school street',
            'body' => 'this is new school body',
            'info' => 123,
            'user_id' => $user->id,
            'cover_image' => 'new-school.jpg',

        ];
        $response = $this->postJson('/api/schools', $newschoolData);
        $response->assertCreated();
        $this->assertDatabaseHas('schools', $newschoolData);
    }
    public function testSchoolupdate()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->schools as $school) {
            $newData = [
                'title' => 'new school title' . $school->id,
                'body' => 'new body fucccccck',
                'info' => 123,
                'address' => 'new address',
                'cover_image' => 'new cover image',
            ];
            $response = $this->patch('/api/schools/' . $school->id, $newData);
            $response->assertOK();
            $this->assertDatabaseHas('schools', $newData);
        }
    }
    public function testSchooldelete()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->schools as $school) {
            $response = $this->delete('/api/schools/' . $school->id);
            $response->assertNoContent();
            $this->assertDatabaseMissing('schools', ['id' => $school->id]);
        }
    }
}
