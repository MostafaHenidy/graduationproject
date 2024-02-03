<?php

namespace App\Http\Controllers;

use App\Models\Schools;
use App\Http\Requests\StoreSchoolsRequest;
use App\Http\Requests\UpdateSchoolsRequest;
use App\Http\Resources\Place\SchoolResource;
use Symfony\Component\HttpFoundation\Response;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = Schools::paginate(20);
        return response(SchoolResource::collection($schools));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSchoolsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolsRequest $request)
    {
        $validated = $request->validated();
        $school = Schools::create($validated);
        return response(new SchoolResource($school),Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school = Schools::findOrFail($id);
        return response(new SchoolResource($school));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSchoolsRequest  $request
     * @param  \App\Models\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolsRequest $request, $id)
    {
        $request ->validated();
        $school = Schools::findOrFail($id);
        $school ->update($request->all());
        return response(new SchoolResource($school),Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schools  $schools
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = schools::findOrFail($id);
        $school->delete();
        return response()->json(['message','school deleted successfully',],Response::HTTP_NO_CONTENT);
    }
}
