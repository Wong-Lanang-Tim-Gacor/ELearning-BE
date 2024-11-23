<?php

namespace App\Contracts\Interface\Eloquent;

interface UpdateInterface
{
    public function update(mixed $id, array $data);
}
