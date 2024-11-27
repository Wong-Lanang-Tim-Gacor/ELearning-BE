<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\QuizOptionInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\QuizOptionRequest;
use Illuminate\Http\Request;

class QuizOptionsController extends Controller
{
    private QuizOptionInterface $quizOption;
    public function __construct(
        QuizOptionInterface $quizOption
    )
    {
        $this->quizOption = $quizOption;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizOptions = $this->quizOption->get();
        return ResponseHelper::success($quizOptions,'Quiz retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizOptionRequest $request)
    {
        try {
            $this->quizOption->store($request->validated());
            return ResponseHelper::success([], 'Quiz option created successfully.');
        }catch (\Exception $exception){
            return ResponseHelper::error($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $quizOption = $this->quizOption->show($id);
            return ResponseHelper::success($quizOption,'Quiz retrieved successfully.');
        }catch (\Exception $exception){
            return ResponseHelper::error($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizOptionRequest $request, string $id)
    {
        try {
            $this->quizOption->update($id, $request->validated());
            return ResponseHelper::success([], 'Quiz option updated successfully.');
        }catch (\Exception $exception){
            return ResponseHelper::error($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $this->quizOption->delete($id);
            return ResponseHelper::success([], 'Quiz option deleted successfully.');
        } catch (\Exception $exception){
            return ResponseHelper::error($exception->getMessage());
        }
    }
}
