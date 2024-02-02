<?php

namespace App\Http\Controllers;

use App\Models\Schools;
use App\Http\Requests\StoreSchoolsRequest;
use App\Http\Requests\UpdateSchoolsRequest;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school = Schools::paginate(20);
        return response()->json(['data' => $school]);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSchoolsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolsRequest $request)
    {
        $request->validated();
        $school = schools::create($request);
        return response()->json(['message' => 'school added successfully', 'data' => $school], 201);
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
        return response()->json(['data'=>$school]);
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
        return response()->json(['message'=>'school updated successfully','data'=>$school],200);
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
        return response()->json(['message','school deleted successfully',],200);
    }
}
