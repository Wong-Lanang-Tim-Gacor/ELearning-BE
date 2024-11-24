<?php

namespace App\Contracts\Repository;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public Model $model;
    

    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function getAll(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }


    public function findById($id, array $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }


    public function create(array $data)
    {
        return $this->model->create($data);
    }


    public function update($id, array $data)
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record;
    }


    public function delete($id)
    {
        $record = $this->findById($id);
        $record->delete();
        return true;
    }
}
