<?php

namespace App\Http\Controllers;

use App\Models\Hospitals;
use App\Http\Requests\StoreHospitalsRequest;
use App\Http\Requests\UpdateHospitalsRequest;

class HospitalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Hospitals::paginate(20);
        return response()->json(['data' => $hospitals]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHospitalsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHospitalsRequest $request)
    {
        $request->validated();
        $hospital = Hospitals::create($request);
        return response()->json(['message' => 'Hospital added successfully', 'data' => $hospital], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hospitals  $hospitals
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hospital = Hospitals::find($id);
        return response()->json(['data' => $hospital]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHospitalsRequest  $request
     * @param  \App\Models\Hospitals  $hospitals
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHospitalsRequest $request, $id)
    {
        $request->validated();

        $hospital = Hospitals::findOrFail($id);
        $hospital->update($request->all());

        return response()->json(['message' => 'Hospital updated successfully', 'data' => $hospital], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hospitals  $hospitals
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hospital = Hospitals::findOrFail($id);
        $hospital->delete();
        return response()->json(['message', 'Hospital deleted successfully',], 200);
    }
}
