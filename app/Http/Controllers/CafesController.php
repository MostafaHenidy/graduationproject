<?php

namespace App\Http\Controllers;

use App\Models\Cafes;
use App\Http\Requests\StoreCafesRequest;
use App\Http\Requests\UpdateCafesRequest;
use App\Http\Resources\Place\CafeResource;
use Symfony\Component\HttpFoundation\Response;

class CafesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cafes = Cafes::paginate(20);
        return response(CafeResource::collection($cafes));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCafesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCafesRequest $request)
    {
        $validated = $request->validated();
        $cafe = Cafes::create($validated);
        return response(new CafeResource($cafe),Response::HTTP_CREATED);
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
        return new CafeResource($cafe);
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
        return response(new CafeResource($cafe),Response::HTTP_OK);;
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
        return response()->json(['message','cafe deleted successfully',],Response::HTTP_NO_CONTENT);
    }
}
