<?php

namespace App\Http\Controllers;

use App\Models\AgreementType;
use App\Http\Requests\StoreAgreementTypeRequest;
use App\Http\Requests\UpdateAgreementTypeRequest;
use App\Models\Status;
use Illuminate\Http\JsonResponse;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $statuses = Status::getAvaliable();
        return response()->json($statuses);

    }

}
