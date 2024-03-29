<?php

namespace Tests\Feature;

use App\Http\Resources\Place\CafeResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cafes;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class Cafetest extends TestCase
{
    use RefreshDatabase;

    private $cafes;
    public function setUp(): void
    {
        parent::setUP();
        $this->cafes = Cafes::factory()->count(3)->create();
        if ($this->cafes->count() < 3) {
            $this->markTestSkipped('Not enough cafes in the database to run this test.');
        }
    }
    public function testCafeindex()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get('/api/cafes');
        $response->assertOk();
        foreach ($this->cafes as $cafe) {
            $resource = new CafeResource($cafe);
            $transfomedcafe = $resource->toArray(request());
            $response->assertJsonFragment($transfomedcafe);
        }
    }
    public function testCafetore()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $newcafeData = [
            'title' => 'new cafe',
            'address' => '123 new cafe street',
            'body' => 'this is new cafe body',
            'info' => 123,
            'user_id' => $user->id,
            'cover_image' => 'new-cafe.jpg',

        ];
        $response = $this->postJson('/api/cafes', $newcafeData);
        $response->assertCreated();
        $this->assertDatabaseHas('cafes', $newcafeData);
    }
    public function testCafeshow()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        foreach ($this->cafes as $cafe) {
            $response = $this->get('/api/cafes/' . $cafe->id);
            $response->assertOk();
            $resource = new CafeResource($cafe);
            $transfomedcafe = $resource->toArray(request());
            $response->assertJsonFragment($transfomedcafe);
        }
    }
    public function testCafeupdate()
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->cafes as $cafe) {
            $newData = [
                'title' => 'new Hospital title' . $cafe->id,
                'body' => 'new body fucccccck',
                'info' => 123,
                'address' => 'new address',
                'cover_image' => 'new cover image',
            ];
            $response = $this->patch('/api/cafes/' . $cafe->id, $newData);
            $response->assertSuccessful();
            $this->assertDatabaseHas('cafes', $newData);
        }
    }
    public function testCafedelete()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->cafes as $cafe) {
            $response = $this->delete('/api/cafes/' . $cafe->id);
            $response->assertNoContent();
            $this->assertDatabaseMissing('cafes', ['id' => $cafe->id]);
        }
    }
}
