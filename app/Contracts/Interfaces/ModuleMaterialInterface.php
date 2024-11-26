<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;

interface ModuleMaterialInterface extends GetInterface, StoreInterface, UpdateInterface, DeleteInterface
{
}
