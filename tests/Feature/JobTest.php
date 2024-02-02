<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Jobs;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $jobs = jobs::factory()->count(3)->create();
        $response = $this->get('/api/jobs');
        $response->assertStatus(200);
        foreach ($jobs as $job) {
            $response->assertJsonFragment($job->toArray());
        }
    }
    public function testjobshow()
    {
        $jobs = Jobs::factory()->count(3)->create();
        if ($jobs->count() < 3) {
            $this->markTestSkipped('Not enough jobs in the database to run this test.');
        }
        foreach ($jobs as $job) {
            $response = $this->get('/api/jobs/' . $job->id);
            $response->assertStatus(200);
            $response->assertJsonFragment($job->toArray());
        }
    }
    public function testJobupdate()
    {
        $jobs = Jobs::factory()->count(3)->create();
        if ($jobs->count() < 3) {
            $this->markTestSkipped('Not enough jobs in the database to run this test.');
        }
        foreach ($jobs as $job) {
            $newData = [
                'title' => 'new job title' . $job->id,
                'body' => 'new body fucccccck',
                'info' => 123,
                'address' => 'new address',
                'cover_image' => 'new cover image',
            ];
            $response = $this->patch('/api/jobs/' . $job->id, $newData);
            $response->assertStatus(200);
            $this->assertDatabaseHas('jobs', $newData);
        }
    }
    public function testJobdelete()
    {
        $jobs = jobs::factory()->count(3)->create();
        if ($jobs->count() < 3) {
            $this->markTestSkipped('Not enough jobs in the database to run this test.');
        }
        foreach ($jobs as $job) {
            $response = $this->delete('/api/jobs/' . $job->id);
            $response->assertStatus(200);
            $this->assertDatabaseMissing('jobs', ['id' => $job->id]);
        }
    }
}
