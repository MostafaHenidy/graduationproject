<?php

namespace Tests\Feature;

use App\Http\Resources\Place\JobResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Jobs;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class JobTest extends TestCase
{
    use RefreshDatabase;

    private $jobs;
    public function setUp(): void
    {
        parent::setUP();
        $this->jobs = Jobs::factory()->count(3)->create();
        if ($this->jobs->count() < 3) {
            $this->markTestSkipped('Not enough jobs in the database to run this test.');
        }
    }
    public function testJobindex()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get('/api/jobs');
        $response->assertOk();
        foreach ($this->jobs as $job) {
            $resource = new JobResource($job);
            $transfomedjob = $resource->toArray(request());
            $response->assertJsonFragment($transfomedjob);
        }
    }
    public function testjobstore()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $newjobData = [
            'title' => 'new job',
            'address' => '123 new job street',
            'body' => 'this is new job body',
            'info' => 123,
            'user_id' => $user->id,
            'cover_image' => 'new-job.jpg',

        ];
        $response = $this->postJson('/api/jobs', $newjobData);
        $response->assertCreated();
        $this->assertDatabaseHas('jobs', $newjobData);
    }
    public function testjobshow()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->jobs as $job) {
            $response = $this->get('/api/jobs/' . $job->id);
            $response->assertOk();
            $resource = new JobResource($job);
            $transfomedjob = $resource->toArray(request());
            $response->assertJsonFragment($transfomedjob);
        }
    }
    public function testJobupdate()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->jobs as $job) {
            $newData = [
                'title' => 'new job title' . $job->id,
                'body' => 'new body fucccccck',
                'info' => 123,
                'address' => 'new address',
                'cover_image' => 'new cover image',
            ];
            $response = $this->patch('/api/jobs/' . $job->id, $newData);
            $response->assertSuccessful();
            $this->assertDatabaseHas('jobs', $newData);
        }
    }
    public function testJobdelete()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        foreach ($this->jobs as $job) {
            $response = $this->delete('/api/jobs/' . $job->id);
            $response->assertNoContent();
            $this->assertDatabaseMissing('jobs', ['id' => $job->id]);
        }
    }
}
