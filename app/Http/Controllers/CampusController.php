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

    public function indexView(University $university)
    {
        return Inertia::render('Universities/Campus', ['university' => $university]);
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
