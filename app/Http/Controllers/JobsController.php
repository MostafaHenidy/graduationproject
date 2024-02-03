<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Http\Requests\StoreJobsRequest;
use App\Http\Requests\UpdateJobsRequest;
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
        $job = Jobs::paginate(20);
        return response()->json(['data' => $job]);
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
        return response()->json(['message' => 'job added successfully', 'data' => $job], Response::HTTP_CREATED);
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
        return response()->json(['data' => $job]);
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
        return response()->json(['message' => 'job updated successfully', 'data' => $job], Response::HTTP_OK);
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
