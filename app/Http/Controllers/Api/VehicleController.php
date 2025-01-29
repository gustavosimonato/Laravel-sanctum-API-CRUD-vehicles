<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VehicleCreateRequest;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class VehicleController extends Controller
{
    protected $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function index(): JsonResponse
    {
        $vehicles = $this->vehicleService->getAllVehiclesByUser();
        return response()->json($vehicles, Response::HTTP_OK);
    }

    public function store(VehicleCreateRequest $request): JsonResponse
    {
        $vehicle = $this->vehicleService->createVehicle($request->validated());
        return response()->json($vehicle, Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $vehicle = $this->vehicleService->getVehicleById($id);
        return response()->json($vehicle, Response::HTTP_OK);
    }

    public function update(VehicleCreateRequest $request, $id): JsonResponse
    {
        $vehicle = $this->vehicleService->updateVehicle($id, $request->validated());
        return response()->json($vehicle, Response::HTTP_OK);

    }

    public function destroy($id): JsonResponse
    {
        $this->vehicleService->deleteVehicle($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
