<?php

namespace App\Http\Controllers;

use App\Contracts\Repository\CategoryRepository;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $categories = $this->categoryRepository->get();
            return ResponseHelper::success($categories, 'Categories retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->categoryRepository->store($request->validated());
            return ResponseHelper::success($category, 'Category created successfully.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $category = $this->categoryRepository->show($id);
            return ResponseHelper::success($category, 'Category retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function update(CategoryRequest $request, $id): JsonResponse
    {
        try {
            $category = $this->categoryRepository->update($id, $request->validated());
            return ResponseHelper::success($category, 'Category updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->categoryRepository->delete($id);
            if (!$result) {
                return ResponseHelper::error('Cannot delete category as it is linked to other data.', 400);
            }

            return ResponseHelper::success(null, 'Category deleted successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
}