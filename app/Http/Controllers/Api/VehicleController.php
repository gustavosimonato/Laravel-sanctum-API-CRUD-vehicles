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
        try {
            $vehicles = $this->vehicleService->getAllVehiclesByUser();
            return response()->json($vehicles, Response::HTTP_OK);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Internal server error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(VehicleCreateRequest $request): JsonResponse
    {
        try {
            $vehicle = $this->vehicleService->createVehicle($request->validated());
            return response()->json($vehicle, Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Internal server error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $vehicle = $this->vehicleService->getVehicleById($id);
            return response()->json($vehicle, Response::HTTP_OK);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Internal server error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(VehicleCreateRequest $request, $id): JsonResponse
    {
        try {
            $vehicle = $this->vehicleService->updateVehicle($id, $request->validated());
            return response()->json($vehicle, Response::HTTP_OK);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Internal server error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->vehicleService->deleteVehicle($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Internal server error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
