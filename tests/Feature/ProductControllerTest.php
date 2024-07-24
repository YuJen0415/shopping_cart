<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        // 創建一些測試產品
        Product::factory()->create([
            'name' => 'Test Product',
            'brand' => 'Test Brand',
            'sale_price' => 100,
            'official_price' => 120
        ]);

        Product::factory()->create([
            'name' => 'Another Product',
            'brand' => 'Another Brand',
            'sale_price' => 200,
            'official_price' => 220
        ]);

        Product::factory()->create([
            'name' => 'Cheap Product',
            'brand' => 'Test Brand',
            'sale_price' => 50,
            'official_price' => 60
        ]);
    }

    // 測試一般顯示狀況
    public function test_index_displays_products()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('products');
        $response->assertSee('Test Product');
        $response->assertSee('Another Product');
    }

    // 測試按名稱搜尋
    public function test_search_by_name()
    {
        $response = $this->get('/?name=Test');
        
        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertDontSee('Another Product');
    }

    // 測試按品牌搜尋
    public function test_search_by_brand()
    {
        $response = $this->get('/?brand=Test+Brand');
        
        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertSee('Cheap Product');
        $response->assertDontSee('Another Product');
    }

    // 測試按價格範圍搜尋
    public function test_search_by_price_range()
    {
        $response = $this->get('/?min_price=75&max_price=150');
        
        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertDontSee('Another Product');
        $response->assertDontSee('Cheap Product');
    }

    // 測試用多條件搜尋
    public function test_multi_criteria_search()
    {
        $response = $this->get('/?name=Test&brand=Test+Brand&min_price=75');
        
        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertDontSee('Another Product');
        $response->assertDontSee('Cheap Product');
    }

    // 測試無搜尋結果
    public function test_empty_search_result()
    {
        $response = $this->get('/?name=NonExistent');
        
        $response->assertStatus(200);
        $response->assertDontSee('Test Product');
        $response->assertDontSee('Another Product');
        $response->assertDontSee('Cheap Product');
    }

    // 測試價格邊界的結果
    public function test_price_range_boundary()
    {
        $response = $this->get('/?min_price=100&max_price=100');
        
        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertDontSee('Another Product');
        $response->assertDontSee('Cheap Product');
    }

    public function test_pagination()
    {
        // 創建10個產品以測試分頁
        Product::factory()->count(10)->create();

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('pagination');
    }
}