<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\EcommerceProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected $product;

    protected $ecommerceProduct;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test user
        $this->user = User::factory()->create();

        // Create test brand
        $brand = Brand::factory()->create();

        // Create test warehouse product
        $this->product = Product::factory()->create([
            'brand_id' => $brand->id,
            'selling_price' => 100.00,
            'product_name' => 'Test Product',
        ]);

        // Create test ecommerce product
        $this->ecommerceProduct = EcommerceProduct::factory()->create([
            'warehouse_product_id' => $this->product->id,
            'ecommerce_status' => 'active',
        ]);
    }

    /** @test */
    public function user_can_view_cart_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('shop-cart'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.shop-cart');
    }

    /** @test */
    public function user_can_add_product_to_cart()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('cart.add'), [
                'ecommerce_product_id' => $this->ecommerceProduct->id,
                'quantity' => 2,
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'action' => 'added',
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $this->user->id,
            'ecommerce_product_id' => $this->ecommerceProduct->id,
            'quantity' => 2,
        ]);
    }

    /** @test */
    public function user_can_update_cart_quantity()
    {
        // First add item to cart
        $cartItem = Cart::create([
            'user_id' => $this->user->id,
            'ecommerce_product_id' => $this->ecommerceProduct->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)
            ->putJson(route('cart.update', $cartItem->id), [
                'quantity' => 3,
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'item_price' => 100.00,
        ]);

        $this->assertDatabaseHas('carts', [
            'id' => $cartItem->id,
            'quantity' => 3,
        ]);
    }

    /** @test */
    public function cart_total_calculation_is_correct()
    {
        // Add multiple items to cart
        Cart::create([
            'user_id' => $this->user->id,
            'ecommerce_product_id' => $this->ecommerceProduct->id,
            'quantity' => 2,
        ]);

        $total = Cart::getCartTotal($this->user->id);

        // 2 items * 100.00 price = 200.00
        $this->assertEquals(200.00, $total);
    }

    /** @test */
    public function user_can_remove_item_from_cart()
    {
        $cartItem = Cart::create([
            'user_id' => $this->user->id,
            'ecommerce_product_id' => $this->ecommerceProduct->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson(route('cart.remove', $cartItem->id));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('carts', [
            'id' => $cartItem->id,
        ]);
    }
}
