<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Hospitals;

class HospitalTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $hospitals = Hospitals::factory()->count(3)->create();
        $response = $this->get('/api/hospitals');
        $response->assertStatus(200);
        foreach ($hospitals as $hospital) {
            $response->assertJsonFragment($hospital->toArray());
        }
    }
    public function testHospitalshow()
    {
        $hospitals = Hospitals::factory()->count(3)->create();
        if ($hospitals->count() < 3) {
            $this->markTestSkipped('Not enough hospitals in the database to run this test.');
        }
        foreach ($hospitals as $hospital) {
            $response = $this->get('/api/hospitals/' . $hospital->id);
            $response->assertStatus(200);
            $response->assertJsonFragment($hospital->toArray());
        }
    }
    public function testHospitalupdate()
    {
        $hospitals = Hospitals::factory()->count(3)->create();
        if ($hospitals->count() < 3) {
            $this->markTestSkipped('Not enough hospitals in the database to run this test.');
        }
        foreach ($hospitals as $hospital) {
            $newData = [
                'title' => 'new Hospital title' . $hospital->id,
                'body' => 'new body fucccccck',
                'info' => 123,
                'address' => 'new address',
                'cover_image' => 'new cover image',
            ];
            $response = $this->patch('/api/hospitals/' . $hospital->id, $newData);
            $response->assertStatus(200);
            $this->assertDatabaseHas('hospitals', $newData);
        }
    }
    public function testHospitaldelete()
    {
        $hospitals = Hospitals::factory()->count(3)->create();
        if ($hospitals->count() < 3) {
            $this->markTestSkipped('Not enough hospitals in the database to run this test.');
        }
        foreach ($hospitals as $hospital) {
            $response = $this->delete('/api/hospitals/' . $hospital->id);
            $response->assertStatus(200);
            $this->assertDatabaseMissing('hospitals', ['id' => $hospital->id]);
        }
    }
}
