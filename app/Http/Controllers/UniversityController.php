<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Http\Requests\StoreUniversityRequest;
use App\Http\Requests\UpdateUniversityRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(University::with('country')->orderBy('name', 'ASC')->get());
    }

    public function getCampuses(University $university): JsonResponse
    {
        return response()->json($university->campuses);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUniversityRequest $request
     * @param int $university
     * @return JsonResponse
     */
    public function update(UpdateUniversityRequest $request, int $university): JsonResponse
    {
        University::patch(
            $university,
            $request
        );
        return response()->json(['message' => 'Universidad creada exitosamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param University $university
     * @return Response
     */
    public function destroy(University $university)
    {
        $university->delete();
        return response()->json(['message' => 'Universidad borrada exitosamente']);

    }
}
