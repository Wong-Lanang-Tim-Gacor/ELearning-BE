<?php

namespace App\Http\Controllers;

use App\Contracts\Repository\QuizRepository;
use App\Helpers\ResponseHelper;
use App\Http\Requests\QuizRequest;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    private QuizRepository $quizRepository;

    public function __construct(QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $quizzes = $this->quizRepository->get();
            return ResponseHelper::success($quizzes, 'Quizzes retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(QuizRequest $request): JsonResponse
    {
        try {
            $quiz = $this->quizRepository->store($request->validated());
            return ResponseHelper::success($quiz, 'Quiz created successfully.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $quiz = $this->quizRepository->show($id);
            return ResponseHelper::success($quiz, 'Quiz retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function update(QuizRequest $request, $id): JsonResponse
    {
        try {
            $quiz = $this->quizRepository->update($id, $request->validated());
            return ResponseHelper::success($quiz, 'Quiz updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->quizRepository->delete($id);
            return ResponseHelper::success(null, 'Quiz deleted successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function getByCourseModule($courseModuleId)
    {
        $quizzes = $this->quizRepository->getByCourseModule($courseModuleId);

        return ResponseHelper::success(
            data: $quizzes,
            message: 'Quizzes retrieved successfully.'
        );
    }
}
