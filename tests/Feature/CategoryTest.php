<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    protected $endpoint = '/categories';

    /**
     * Get all categories
     *
     * @return void
     */
    public function test_get_all_categories()
    {
        Category::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);
        $response->assertJsonCount(6, 'data');
        
        $response->assertStatus(200);
    }

    /**
     * Error get single category
     * 
     * @return void
     */
    public function test_error_get_single_category()
    {
        $category = 'fake-url';
        $response = $this->getJson("{$this->endpoint}/{$category}");

        $response->assertStatus(404);
    }

    /**
     * Get single category
     * 
     * @return void
     */
    public function test_get_single_category()
    {
        $category = Category::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$category->url}");

        $response->assertStatus(200);
    }

    /**
     * Validation store category
     * 
     * @return void
     */
    public function test_validation_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => '',
            'description' => ''
        ]);

        $response->dump();

        $response->assertStatus(422);
    }

    /**
     * Store category
     * 
     * @return void
     */
    public function test_store_category()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => 'Category 01',
            'description' => 'Description of category'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Update category
     * 
     * @return void
     */
    public function test_update_category()
    {
        $category = Category::factory()->create();

        $data = [
            'title' => 'Title Updated',
            'description' => 'Description Updated'
        ];

        $response = $this->putJson("{$this->endpoint}/fake-category", $data);
        $response->assertStatus(404);

        $response = $this->putJson("{$this->endpoint}/fake-category", []);
        $response->assertStatus(422);

        $response = $this->putJson("{$this->endpoint}/{$category->url}", $data);
        $response->assertStatus(200);
    }
}
