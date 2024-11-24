<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories(): void
    {
        // Arrange: Buat beberapa kategori
        Category::factory()->count(3)->create();

        // Act: Panggil endpoint GET /api/categories
        $response = $this->getJson('/api/categories');

        // Assert: Pastikan respons sukses dan struktur JSON sesuai
        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => ['code', 'status', 'message'],
                'data' => [
                    '*' => ['id', 'name', 'description', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_can_create_category(): void
    {
        // Arrange: Data untuk kategori baru
        $data = [
            'name' => 'Programming',
            'description' => 'Courses about programming.',
        ];

        // Act: Panggil endpoint POST /api/categories
        $response = $this->postJson('/api/categories', $data);

        // Assert: Pastikan respons sukses dan data tersimpan di database
        $response->assertStatus(201)
            ->assertJson([
                'meta' => [
                    'code' => 201,
                    'status' => 'success',
                    'message' => 'Category created successfully.',
                ],
                'data' => [
                    'name' => $data['name'],
                    'description' => $data['description'],
                ],
            ]);

        $this->assertDatabaseHas('categories', $data);
    }

    public function test_can_show_category(): void
    {
        // Arrange: Buat kategori
        $category = Category::factory()->create();

        // Act: Panggil endpoint GET /api/categories/{id}
        $response = $this->getJson("/api/categories/{$category->id}");

        // Assert: Pastikan respons sukses dan data sesuai
        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'code' => 200,
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
        // Arrange: Buat kategori
        $category = Category::factory()->create();

        // Data untuk pembaruan
        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated description.',
        ];

        // Act: Panggil endpoint PUT /api/categories/{id}
        $response = $this->putJson("/api/categories/{$category->id}", $data);

        // Assert: Pastikan respons sukses dan data diperbarui di database
        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Category updated successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('categories', array_merge(['id' => $category->id], $data));
    }

    public function test_can_delete_category(): void
    {
        // Arrange: Buat kategori
        $category = Category::factory()->create();

        // Act: Panggil endpoint DELETE /api/categories/{id}
        $response = $this->deleteJson("/api/categories/{$category->id}");

        // Assert: Pastikan respons sukses dan data terhapus dari database
        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Category deleted successfully.',
                ],
            ]);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
    
    public function test_create_category_with_invalid_data_returns_validation_error()
    {
        // Data invalid
        $data = [
            'name' => 'InvalidName', // Lebih dari 2 karakter
            'description' => 'Some valid description', // Valid
        ];

        // Panggil endpoint POST
        $response = $this->postJson('/api/categories', $data);

        // Pastikan status HTTP adalah 422
        $response->assertStatus(422);

        // Pastikan pesan error sesuai
        $response->assertJsonValidationErrors([
            'name' => 'The name field must not be greater than 2 characters.',
        ]);
    }
}
