<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CourseModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_course_modules(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $course = Course::factory()->create();
        CourseModule::factory(5)->create(['course_id' => $course->id]);

        // Act
        $response = $this->getJson('/api/course-modules');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => ['status', 'message'],
                'data' => [
                    '*' => ['id', 'course_id', 'title', 'description', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_can_create_course_module(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $course = Course::factory()->create();
        $data = [
            'course_id' => $course->id,
            'title' => 'New Module',
            'description' => 'This is a new module.',
        ];

        // Act
        $response = $this->postJson('/api/course-modules', $data);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Course module created successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('course_modules', $data);
    }

    public function test_can_show_course_module(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $module = CourseModule::factory()->create();

        // Act
        $response = $this->getJson("/api/course-modules/{$module->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Course module retrieved successfully.',
                ],
                'data' => [
                    'id' => $module->id,
                    'title' => $module->title,
                    'description' => $module->description,
                ],
            ]);
    }

    public function test_can_update_course_module(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $course = Course::factory()->create();

        $module = CourseModule::factory()->create();
        $data = [
            'course_id' => $course->id,
            'title' => 'Updated Module Title',
            'description' => 'Updated module description.',
        ];

        // Act
        $response = $this->putJson("/api/course-modules/{$module->id}", $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Course module updated successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('course_modules', array_merge(['id' => $module->id], $data));
    }

    public function test_can_delete_course_module(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $module = CourseModule::factory()->create();

        // Act
        $response = $this->deleteJson("/api/course-modules/{$module->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Course module deleted successfully.',
                ],
            ]);

        $this->assertDatabaseMissing('course_modules', ['id' => $module->id]);
    }

    public function test_create_course_module_with_invalid_data(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $data = [
            'course_id' => null,
            'title' => '',
            'description' => '',
        ];

        $response = $this->postJson('/api/course-modules', $data);

        // Assert: Pastikan status HTTP adalah 422
        $response->assertStatus(422);

        // Assert: Periksa struktur respons
        $response->assertJson([
            'meta' => [
                'status' => 'error',
                'message' => 'Validation failed.',
            ],
            'data' => [
                'course_id' => ['The course id field is required.'],
                'title' => ['The title field is required.'],
            ],
        ]);
    }
}
