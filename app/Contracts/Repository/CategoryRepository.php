<?php

namespace App\Contracts\Repository;

use App\Contracts\Repository\BaseRepository;
use App\Models\Category;
use App\Contracts\Interfaces\CategoryInterface;
use Illuminate\Database\QueryException;

class CategoryRepository extends BaseRepository implements CategoryInterface
{
    public function __construct(Category $category)
    {
        $this->model = $category;
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
            $this->show($id)->delete($id);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451)
            if ($e->errorInfo[1] == 1451) return false;
        }

        return true;
    }
}