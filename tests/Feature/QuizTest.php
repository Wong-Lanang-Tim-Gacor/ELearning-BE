<?php

namespace Tests\Feature;

use App\Models\CourseModule;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_quizzes(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        Quiz::factory(1)->create();

        $response = $this->getJson('/api/quizzes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => ['status', 'message'],
                'data' => [
                    '*' => ['id', 'course_module_id', 'question', 'correct_choice_id'],
                ],
            ]);
    }

    public function test_can_create_quiz_with_null_choice(): void
    {
        $user = User::factory()->create();
        $course_module = CourseModule::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $data = [
            'course_module_id' => $course_module->id,
            'question' => 'A quiz about basic math.',
            'correct_choice_id' => null,
        ];

        $response = $this->postJson('/api/quizzes', $data);

        $response->assertStatus(201)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Quiz created successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('quizzes', $data);
    }

    public function test_can_show_quiz(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $quiz = Quiz::factory()->create();

        $response = $this->getJson("/api/quizzes/{$quiz->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Quiz retrieved successfully.',
                ],
                'data' => [
                    'id' => $quiz->id,
                    'course_module_id' => $quiz->course_module_id,
                    'question' => $quiz->question,
                    'correct_choice_id' => $quiz->correct_choice_id,
                ],
            ]);
    }

    public function test_can_update_quiz(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $quiz = Quiz::factory()->create();
        $data = [
            'course_module_id' => $quiz->course_module_id,
            'question' => "update question",
            'correct_choice_id' => $quiz->correct_choice_id,
        ];

        $response = $this->putJson("/api/quizzes/{$quiz->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Quiz updated successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('quizzes', array_merge(['id' => $quiz->id], $data));
    }

    public function test_can_delete_quiz(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $quiz = Quiz::factory()->create();

        $response = $this->deleteJson("/api/quizzes/{$quiz->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Quiz deleted successfully.',
                ],
            ]);

        $this->assertDatabaseMissing('quizzes', ['id' => $quiz->id]);
    }

    public function test_create_quiz_with_invalid_data_returns_validation_error()
    {
        $data = [
            'course_module_id' => null, // Tidak valid
            'question' => null,         // Tidak valid
            'correct_choice_id' => null, // Valid (nullable)
        ];

        $response = $this->postJson('/api/quizzes', $data);

        $response->assertStatus(422)
            ->assertJson([
                'meta' => [
                    'status' => 'error',
                    'message' => 'Validation failed.',
                ],
                'data' => [
                    'course_module_id' => ['The course module id field is required.'],
                    'question' => ['The question field is required.'],
                ],
            ]);
    }
}