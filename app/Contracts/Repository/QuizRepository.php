<?php

namespace App\Contracts\Repository;

use App\Contracts\Interfaces\QuizInterface;
use App\Models\Quiz;
use Illuminate\Database\QueryException;

class QuizRepository extends BaseRepository implements QuizInterface
{
    public function __construct(Quiz $quiz)
    {
        $this->model = $quiz;
    }

    public function get(): mixed
    {
        return $this->model->query()
            ->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()
            ->findOrFail($id);
    }

    public function store(array $data): mixed
    {
        return $this->model->query()
            ->create($data);
    }

    public function update(mixed $id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }

    public function delete(mixed $id): mixed
    {
        try {
            return $this->show($id)->delete();
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) return false;
        }

        return true;
    }

    public function getByCourseModule($courseModuleId): mixed
    {
        return $this->model->query()
            ->where('course_module_id', $courseModuleId)
            ->get();
    }
}
