<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Hospitals;
use App\Models\User;

class HospitalTest extends TestCase
{
    // use RefreshDatabase;
    private $hospitals;
    public function setUp(): void
    {
        parent::setUP();
        $this->hospitals = Hospitals::factory()->count(3)->create();
        if ($this->hospitals->count() < 3) {
            $this->markTestSkipped('Not enough hospitals in the database to run this test.');
        }
    }

    public function test_example()
    {
        $response = $this->get('/api/hospitals');
        $response->assertOk();
        foreach ($this->hospitals as $hospital) {
            $response->assertJsonFragment($hospital->toArray());
        }
    }
    public function testhospitalstore()
    {
        $user = User::factory()->create();
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
        foreach ($this->hospitals as $hospital) {
            $response = $this->get('/api/hospitals/' . $hospital->id);
            $response->assertOk();
            $response->assertJsonFragment($hospital->toArray());
        }
    }
    public function testHospitalupdate()
    {

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
        foreach ($this->hospitals as $hospital) {
            $response = $this->delete('/api/hospitals/' . $hospital->id);
            $response->assertNoContent();
            $this->assertDatabaseMissing('hospitals', ['id' => $hospital->id]);
        }
    }
}
