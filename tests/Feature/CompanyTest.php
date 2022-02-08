<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected $endpoint = '/companies';

    /**
     * Get all companies
     *
     * @return void
     */
    public function test_get_all_companies()
    {
        Company::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);
        $response->assertJsonCount(6, 'data');
        
        $response->assertStatus(200);
    }

    /**
     * Error get single company
     * 
     * @return void
     */
    public function test_error_get_single_company()
    {
        $company = 'fake-uuid';
        $response = $this->getJson("{$this->endpoint}/{$company}");

        $response->assertStatus(404);
    }

    /**
     * Get single company
     * 
     * @return void
     */
    public function test_get_single_company()
    {
        $company = company::factory()->create();
        $response = $this->getJson("{$this->endpoint}/{$company->uuid}");

        $response->assertStatus(200);
    }

    /**
     * Validation store company
     * 
     * @return void
     */
    public function test_validation_store_company()
    {
        $response = $this->postJson($this->endpoint, [
            'title' => '',
            'description' => ''
        ]);

        $response->dump();

        $response->assertStatus(422);
    }

    /**
     * Store company
     * 
     * @return void
     */
    public function test_store_company()
    {
        $category = Category::factory()->create();
        $response = $this->postJson($this->endpoint, [
            'category_id' => $category->id,
            'name' => 'Matheus ME',
            'email' => 'contato@teste.com.br',
            'whatsapp' => '999999999',
            'phone' => '999999999'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Update company
     * 
     * @return void
     */
    public function test_update_company()
    {
        $company = company::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'category_id' => $category->id,
            'name' => 'Matheus ME',
            'email' => 'contato@teste.com.br',
            'phone' => '999999999',
            'whatsapp' => '999999999'
        ];

        $response = $this->putJson("{$this->endpoint}/fake-company", $data);
        $response->assertStatus(404);

        $response = $this->putJson("{$this->endpoint}/{$company->uuid}", []);
        $response->assertStatus(422);

        $response = $this->putJson("{$this->endpoint}/{$company->uuid}", $data);
        $response->assertStatus(200);
    }

    /**
     * delete company
     * 
     * @return void
     */
    public function test_delete_company()
    {
        $company = company::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/fake-company");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$company->uuid}");
        $response->assertStatus(204);
    }
}
