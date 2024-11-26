<?php

namespace App\Http\Controllers;

use App\Contracts\Repository\CourseModuleRepository;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CourseModuleRequest;
use Illuminate\Http\JsonResponse;

class CourseModuleController extends Controller
{
    private CourseModuleRepository $courseModuleRepository;

    public function __construct(CourseModuleRepository $courseModuleRepository)
    {
        $this->courseModuleRepository = $courseModuleRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $modules = $this->courseModuleRepository->get();
            return ResponseHelper::success($modules, 'Course modules retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(CourseModuleRequest $request): JsonResponse
    {
        try {
            $module = $this->courseModuleRepository->store($request->validated());
            return ResponseHelper::success($module, 'Course module created successfully.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $module = $this->courseModuleRepository->show($id);
            return ResponseHelper::success($module, 'Course module retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($id, $e->getMessage());
        }
    }

    public function update(CourseModuleRequest $request, $id): JsonResponse
    {
        try {
            $this->courseModuleRepository->update($id, $request->validated());
            return ResponseHelper::success($request->all(), 'Course module updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($id, $e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->courseModuleRepository->delete($id);
            if (!$result) {
                return ResponseHelper::error('Cannot delete module as it is linked to other data.', 400);
            }

            return ResponseHelper::success(null, 'Course module deleted successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
}
