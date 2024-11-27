<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function courseModule()
    {
        return $this->belongsTo(CourseModule::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function correctChoice()
    {
        return $this->belongsTo(Choice::class, 'correct_choice_id');
    }
}
