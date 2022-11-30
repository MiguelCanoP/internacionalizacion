<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Http\Requests\StoreCampusRequest;
use App\Http\Requests\UpdateCampusRequest;
use App\Models\University;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function indexView(University $university)
    {
        return Inertia::render('Universities/Campus', ['university' => $university]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCampusRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Campus $campus
     * @return \Illuminate\Http\Response
     */
    public function show(Campus $campus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Campus $campus
     * @return \Illuminate\Http\Response
     */
    public function edit(Campus $campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCampusRequest $request
     * @param int $campus
     * @return JsonResponse
     */
    public function update(UpdateCampusRequest $request, int $campus): JsonResponse
    {
        Campus::patch(
            $campus,
            $request
        );
        return response()->json(['message' => 'Campus actualizado exitosamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campus $campus
     * @return JsonResponse
     */
    public function destroy(Campus $campus): JsonResponse
    {
        $campus->delete();
        return response()->json(['message' => 'Campus eliminado exitosamente']);
    }
}
