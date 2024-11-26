<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        Category::factory(5)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => ['status', 'message'],
                'data' => [
                    '*' => ['id', 'name', 'description', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_can_create_category(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $data = [
            'name' => 'Programming',
            'description' => 'Courses about programming.',
        ];

        $response = $this->postJson('/api/categories', $data);

        $response->assertStatus(201)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Category created successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('categories', $data);
    }

    public function test_can_show_category(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Category retrieved successfully.',
                ],
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                ],
            ]);
    }

    public function test_can_update_category(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $category = Category::factory()->create();
        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated description.',
        ];

        $response = $this->putJson("/api/categories/{$category->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Category updated successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('categories', array_merge(['id' => $category->id], $data));
    }

    public function test_can_delete_category(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Category deleted successfully.',
                ],
            ]);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_create_category_with_invalid_data_returns_validation_error()
    {
        // Arrange: Data invalid
        $data = [];

        // Act: Panggil endpoint POST
        $response = $this->postJson('/api/categories', $data);

        // Assert: Pastikan status HTTP adalah 422
        $response->assertStatus(422);

        // Assert: Periksa struktur respons
        $response->assertJson([
            'meta' => [
                'status' => 'error',
                'message' => 'Validation failed.',
            ],
            'data' => [
                'name' => ['The name field is required.'],
            ],
        ]);
    }
}
