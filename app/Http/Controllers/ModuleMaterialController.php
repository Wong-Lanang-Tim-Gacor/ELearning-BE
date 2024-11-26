<?php

namespace App\Http\Controllers;

use App\Contracts\Repository\ModuleMaterialRepository;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ModuleMaterialRequest;
use Illuminate\Http\JsonResponse;

class ModuleMaterialController extends Controller
{
    private ModuleMaterialRepository $moduleMaterialRepository;

    public function __construct(ModuleMaterialRepository $moduleMaterialRepository)
    {
        $this->moduleMaterialRepository = $moduleMaterialRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $materials = $this->moduleMaterialRepository->get();
            return ResponseHelper::success($materials, 'Module materials retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(ModuleMaterialRequest $request): JsonResponse
    {
        try {
            $material = $this->moduleMaterialRepository->store($request->validated());
            return ResponseHelper::success($material, 'Module material created successfully.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $material = $this->moduleMaterialRepository->show($id);
            return ResponseHelper::success($material, 'Module material retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($id, $e->getMessage());
        }
    }

    public function update(ModuleMaterialRequest $request, $id): JsonResponse
    {
        try {
            $this->moduleMaterialRepository->update($id, $request->validated());
            return ResponseHelper::success($request->all(), 'Module material updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($id, $e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->moduleMaterialRepository->delete($id);
            if (!$result) {
                return ResponseHelper::error('Cannot delete module material as it is linked to other data.', 400);
            }

            return ResponseHelper::success(null, 'Module material deleted successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
}
