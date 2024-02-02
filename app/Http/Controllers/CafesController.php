<?php

namespace App\Http\Controllers;

use App\Models\Cafes;
use App\Http\Requests\StoreCafesRequest;
use App\Http\Requests\UpdateCafesRequest;

class CafesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cafe = Cafes::paginate(20);
        return response()->json(['data' => $cafe]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCafesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCafesRequest $request)
    {
        $request->validated();
        $cafe = Cafes::create($request);
        return response()->json(['message' => 'cafe added successfully', 'data' => $cafe], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cafes  $cafes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cafe = Cafes::find($id);
        return response()->json(['data' => $cafe]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCafesRequest  $request
     * @param  \App\Models\Cafes  $cafes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCafesRequest $request, $id)
    {
        $request ->validated();
        $cafe = Cafes::findOrFail($id);
        $cafe ->update($request->all());
        return response()->json(['message'=>'cafe updated successfully','data'=>$cafe],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cafes  $cafes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cafe = Cafes::findOrFail($id);
        $cafe->delete();
        return response()->json(['message','cafe deleted successfully',],200);
    }
}
