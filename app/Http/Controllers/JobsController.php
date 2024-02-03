<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Http\Requests\StoreJobsRequest;
use App\Http\Requests\UpdateJobsRequest;
use App\Http\Resources\Place\JobResource;
use Symfony\Component\HttpFoundation\Response;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Jobs::paginate(20);
        return response(JobResource::collection($jobs));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJobsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobsRequest $request)
    {
        $validated = $request->validated();
        $job = Jobs::create($validated);
        return response(new JobResource($job),Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Jobs::findOrFail($id);
        return response(new JobResource($job));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobsRequest  $request
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobsRequest $request, $id)
    {
        $request->validated();
        $job = Jobs::findOrFail($id);
        $job->update($request->all());
        return response(new JobResource($job),Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = jobs::findOrFail($id);
        $job->delete();
        return response()->json(['message', 'job deleted successfully',], Response::HTTP_NO_CONTENT);
    }
}
