<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_courses(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        Course::factory(5)->create();

        $response = $this->getJson('/api/courses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => ['status', 'message'],
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'category_id',
                        'title',
                        'thumbnail',
                        'description',
                    ],
                ],
            ]);
    }

    public function test_can_create_course(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $category = Category::factory()->create();
        $data = [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'New Course',
            'thumbnail' => 'https://example.com/image.jpg',
            'description' => 'This is a test course.',
        ];

        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(201)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Course created successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('courses', $data);
    }

    public function test_can_show_course(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $course = Course::factory()->create();

        $response = $this->getJson("/api/courses/{$course->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Course retrieved successfully.',
                ],
                'data' => [
                    'id' => $course->id,
                    'title' => $course->title,
                ],
            ]);
    }

    public function test_can_update_course(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $course = Course::factory()->create();
        $data = [
            'user_id' => $user->id,
            'category_id' => $course->category_id,
            'title' => 'Updated Course Title',
            'description' => 'Updated description.',
        ];

        $response = $this->putJson("/api/courses/{$course->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Course updated successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('courses', array_merge(['id' => $course->id], $data));
    }


    public function test_can_delete_course(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $course = Course::factory()->create();

        $response = $this->deleteJson("/api/courses/{$course->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Course deleted successfully.',
                ],
            ]);

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_create_course_with_invalid_data(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $data = [
            'user_id' => null,
            'category_id' => null,
            'title' => '',
            
        ];

        $response = $this->postJson('/api/courses', $data);

        // Assert: Pastikan status HTTP adalah 422
        $response->assertStatus(422);

        // Assert: Periksa struktur respons
        $response->assertJson([
            'meta' => [
                'status' => 'error',
                'message' => 'Validation failed.',
            ],
            'data' => [
                'user_id' => ['The user id field is required.'],
                'category_id' => ['The category id field is required.'],
                'title' => ['The title field is required.'],
              
            ],
        ]);
    }
}
