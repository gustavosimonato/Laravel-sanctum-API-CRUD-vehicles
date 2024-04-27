<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class VehicleService
{
    public function getAllVehiclesByUser()
    {
        try {
            $vehicles = Vehicle::where('user_id', Auth::id())->get();
            return $vehicles;
        } catch (Throwable $throw) {
            throw $throw;
        }
    }

    public function createVehicle(array $vehicleData)
    {
        try {
            DB::beginTransaction();

            $vehicle = new Vehicle();
            $vehicle->user_id = Auth::id();
            $vehicle->manufacturer = $vehicleData['manufacturer'];
            $vehicle->model = $vehicleData['model'];
            $vehicle->year = $vehicleData['year'];
            $vehicle->color = $vehicleData['color'];
            $vehicle->plate = $vehicleData['plate'];
            $vehicle->type = $vehicleData['type'];
            $vehicle->save();

            DB::commit();

            return [
                'message' => 'Vehicle created successfully',
                'vehicle' => $vehicle
            ];
        } catch (Throwable $throw) {
            DB::rollBack();
            throw $throw;
        }
    }

    public function getVehicleById($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            return $vehicle;
        } catch (Throwable $throw) {
            throw $throw;
        }
    }

    public function updateVehicle($id, array $vehicleData)
    {
        try {
            DB::beginTransaction();

            $vehicle = Vehicle::findOrFail($id);
            $vehicle->manufacturer = $vehicleData['manufacturer'];
            $vehicle->model = $vehicleData['model'];
            $vehicle->year = $vehicleData['year'];
            $vehicle->color = $vehicleData['color'];
            $vehicle->plate = $vehicleData['plate'];
            $vehicle->type = $vehicleData['type'];
            $vehicle->save();

            DB::commit();

            return [
                'message' => 'Vehicle updated successfully',
                'vehicle' => $vehicle
            ];
        } catch (Throwable $throw) {
            DB::rollBack();
            throw $throw;
        }
    }

    public function deleteVehicle($id)
    {
        try {
            DB::beginTransaction();

            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();

            DB::commit();
        } catch (Throwable $throw) {
            DB::rollBack();
            throw $throw;
        }
    }

}
