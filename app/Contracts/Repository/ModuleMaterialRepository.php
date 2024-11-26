<?php

namespace App\Contracts\Repository;

use App\Contracts\Interfaces\ModuleMaterialInterface;
use App\Models\ModuleMaterial;

class ModuleMaterialRepository extends BaseRepository implements ModuleMaterialInterface
{
    public function __construct(ModuleMaterial $moduleMaterial)
    {
        $this->model = $moduleMaterial;
    }

    public function get(): mixed
    {
        return $this->model->query()->with('courseModule')->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()->with('courseModule')->findOrFail($id);
    }

    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    public function update(mixed $id, array $data): mixed
    {
        $moduleMaterial = $this->show($id);
        $moduleMaterial->update($data);

        return $moduleMaterial;
    }

    public function delete(mixed $id): bool
    {
        $moduleMaterial = $this->show($id);
        return $moduleMaterial->delete();
    }
}
