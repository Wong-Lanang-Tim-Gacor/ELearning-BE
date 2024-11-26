<?php

namespace Tests\Feature;

use App\Models\CourseModule;
use App\Models\ModuleMaterial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ModuleMaterialTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_module_materials(): void
    {
        $module = CourseModule::factory()->create();
        ModuleMaterial::factory(5)->create(['course_module_id' => $module->id]);

        $response = $this->getJson('/api/module-materials');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => ['status', 'message'],
                'data' => [
                    '*' => ['id', 'course_module_id', 'title', 'content', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_can_create_module_material(): void
    {
        $module = CourseModule::factory()->create();
        $data = [
            'course_module_id' => $module->id,
            'title' => 'New Material',
            'content' => 'This is a test material content.',
        ];

        $response = $this->postJson('/api/module-materials', $data);

        $response->assertStatus(201)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Module material created successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('module_materials', $data);
    }

    public function test_can_show_module_material(): void
    {
        $material = ModuleMaterial::factory()->create();

        $response = $this->getJson("/api/module-materials/{$material->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Module material retrieved successfully.',
                ],
                'data' => [
                    'id' => $material->id,
                    'title' => $material->title,
                ],
            ]);
    }

    public function test_can_update_module_material(): void
    {
        $material = ModuleMaterial::factory()->create();
        $module = CourseModule::factory()->create();

        $data = [
            'course_module_id' => $module->id,
            'title' => 'Updated Material Title',
            'content' => 'Updated content.',
        ];

        $response = $this->putJson("/api/module-materials/{$material->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Module material updated successfully.',
                ],
                'data' => $data,
            ]);

        $this->assertDatabaseHas('module_materials', array_merge(['id' => $material->id], $data));
    }

    public function test_can_delete_module_material(): void
    {
        $material = ModuleMaterial::factory()->create();

        $response = $this->deleteJson("/api/module-materials/{$material->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'status' => 'success',
                    'message' => 'Module material deleted successfully.',
                ],
            ]);

        $this->assertDatabaseMissing('module_materials', ['id' => $material->id]);
    }

    public function test_create_module_material_with_invalid_data(): void
    {
        $data = [
            'course_module_id' => null,
            'title' => '',
            'content' => '',
        ];

        $response = $this->postJson('/api/module-materials', $data);

        $response->assertStatus(422)
            ->assertJson([
                'meta' => [
                    'status' => 'error',
                    'message' => 'Validation failed.',
                ],
                'data' => [
                    'course_module_id' => ['The course module id field is required.'],
                    'title' => ['The title field is required.'],
                    'content' => ['The content field is required.'],
                ],
            ]);
    }
}
