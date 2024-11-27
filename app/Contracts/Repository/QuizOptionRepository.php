<?php

namespace App\Contracts\Repository;

use App\Contracts\Interfaces\QuizOptionInterface;
use App\Models\Choice;

class QuizOptionRepository extends BaseRepository implements QuizOptionInterface
{

    public function __construct(Choice $quizOptions)
    {
        $this->model = $quizOptions;
    }

    public function get()
    {
        $this->model->query()
            ->with('quiz')
            ->get();
    }

    public function show(mixed $id)
    {
        try{
            return $this->model->query()->findOrFail($id);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function store(array $data)
    {
        try {
            return $this->model->query()->create($data);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function update(mixed $id, array $data)
    {
        try{
            return $this->model->query()->findOrFail($id)->update($data);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function delete(mixed $id)
    {
        try{
            return $this->model->query()->findOrFail($id)->delete();
        } catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

}
