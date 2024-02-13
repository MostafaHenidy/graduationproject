<?php

namespace Tests\Feature;

use App\Http\Resources\Place\HospitalResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Hospitals;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
class HospitalTest extends TestCase
{
    use RefreshDatabase;
    private $hospitals;
    public function setUp(): void
    {
        parent::setUP();
        $this->hospitals = Hospitals::factory()->count(3)->create();
        if ($this->hospitals->count() < 3) {
            $this->markTestSkipped('Not enough hospitals in the database to run this test.');
        }
    }

    public function testHospitalindex()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get('/api/hospitals');
        $response->assertOk();
        foreach ($this->hospitals as $hospital) {
            $resource = new HospitalResource($hospital);
            $transfomedHospital = $resource->toArray(request());
            $response->assertJsonFragment($transfomedHospital);
        }
    }
    public function testhospitalstore()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $newhospitalData = [
            'title' => 'new hospital',
            'address' => '123 new hospital street',
            'body' => 'this is new hospital body',
            'info' => 123,
            'user_id' => $user->id,
            'cover_image' => 'new-hospital.jpg',

        ];
        $response = $this->postJson('/api/hospitals', $newhospitalData);
        $response->assertCreated();
        $this->assertDatabaseHas('hospitals', $newhospitalData);
        
    }
    public function testHospitalshow()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->hospitals as $hospital) {
            $response = $this->get('/api/hospitals/' . $hospital->id);
            $response->assertOk();
            $resource = new HospitalResource($hospital);
            $transfomedHospital = $resource->toArray(request());
            $response->assertJsonFragment($transfomedHospital);
        }
    }
    public function testHospitalupdate()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->hospitals as $hospital) {
            $newData = [
                'title' => 'new Hospital title' . $hospital->id,
                'body' => 'new body fucccccck',
                'info' => 123,
                'address' => 'new address',
                'cover_image' => 'new cover image',
            ];
            $response = $this->patch('/api/hospitals/' . $hospital->id, $newData);
            $response->assertSuccessful();
            $this->assertDatabaseHas('hospitals', $newData);
        }
    }
    public function testHospitaldelete()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->hospitals as $hospital) {
            $response = $this->delete('/api/hospitals/' . $hospital->id);
            $response->assertNoContent();
            $this->assertDatabaseMissing('hospitals', ['id' => $hospital->id]);
        }
    }
}
