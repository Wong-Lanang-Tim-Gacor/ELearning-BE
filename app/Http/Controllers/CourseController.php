<?php

namespace App\Http\Controllers;

use App\Contracts\Repository\CourseRepository;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $courses = $this->courseRepository->get();
            return ResponseHelper::success($courses, 'Courses retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(CourseRequest $request): JsonResponse
    {
        try {
            $course = $this->courseRepository->store($request->validated());
            return ResponseHelper::success($course, 'Course created successfully.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $course = $this->courseRepository->show($id);
            return ResponseHelper::success($course, 'Course retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function update(CourseRequest $request, $id): JsonResponse
    {
        try {
            $this->courseRepository->update($id, $request->validated());
            return ResponseHelper::success($request->all(), 'Course updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->courseRepository->delete($id);
            if (!$result) {
                return ResponseHelper::error('Cannot delete course as it is linked to other data.', 400);
            }

            return ResponseHelper::success(null, 'Course deleted successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }
}
