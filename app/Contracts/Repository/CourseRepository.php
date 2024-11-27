<?php

namespace App\Contracts\Repository;


use App\Contracts\Interfaces\CourseInterface;
use App\Models\Course;
use Illuminate\Database\QueryException;

class CourseRepository extends BaseRepository implements CourseInterface
{
    public function __construct(Course $course)
    {
        $this->model = $course;
    }

    public function get(): mixed
    {
        return $this->model->query()
            ->with(['user', 'category'])
            ->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()
            ->with(['user', 'category'])
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
            $this->show($id)->delete($id);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) return false;
        }

        return true;
    }
}
