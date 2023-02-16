<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Http\Requests\StoreAgreementRequest;
use App\Http\Requests\UpdateAgreementRequest;
use Illuminate\Http\JsonResponse;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Agreement::with('university', 'agreementType', 'programs')->get());

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
     * @param \App\Http\Requests\StoreAgreementRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgreementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Agreement $agreement
     * @return \Illuminate\Http\Response
     */
    public function show(Agreement $agreement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agreement $agreement
     * @return \Illuminate\Http\Response
     */
    public function edit(Agreement $agreement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAgreementRequest $request
     * @param int $agreement
     * @return JsonResponse
     */
    public function update(UpdateAgreementRequest $request, int $agreement): JsonResponse
    {
        Agreement::patch(
            $agreement,
            $request
        );
        return response()->json(['message' => 'Universidad creada exitosamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Agreement $agreement
     * @return JsonResponse
     */
    public function destroy(Agreement $agreement)
    {
        $agreement->delete();
        return response()->json(['message' => 'convenio borrado exitosamente']);

    }
}
