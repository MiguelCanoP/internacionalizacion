<?php

namespace App\Http\Controllers;

use App\Models\AgreementType;
use App\Http\Requests\StoreAgreementTypeRequest;
use App\Http\Requests\UpdateAgreementTypeRequest;

class AgreementTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreAgreementTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgreementTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgreementType  $agreementType
     * @return \Illuminate\Http\Response
     */
    public function show(AgreementType $agreementType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgreementType  $agreementType
     * @return \Illuminate\Http\Response
     */
    public function edit(AgreementType $agreementType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgreementTypeRequest  $request
     * @param  \App\Models\AgreementType  $agreementType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgreementTypeRequest $request, AgreementType $agreementType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgreementType  $agreementType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgreementType $agreementType)
    {
        //
    }
}
