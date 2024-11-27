<?php

namespace Database\Factories;

use App\Models\CourseModule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'course_module_id' => CourseModule::factory(),
            'question' => $this->faker->sentence(),
            'correct_choice_id' => null, // Inisialisasi null dulu, bisa diupdate nanti
        ];
    }
}
