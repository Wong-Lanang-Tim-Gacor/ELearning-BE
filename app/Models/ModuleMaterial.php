<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleMaterial extends Model
{
    /** @use HasFactory<\Database\Factories\ModuleMaterialFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function courseModule()
    {
        return $this->belongsTo(CourseModule::class);
    }
}
