<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\EcommerceOrder;
use App\Models\EcommerceOrderItem;
use App\Models\EcommerceProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected $product;

    protected $ecommerceProduct;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);

        // Create a test warehouse product
        $this->product = Product::create([
            'product_name' => 'Test Product',
            'selling_price' => 100.00,
            'sku' => 'TEST-001',
            'stock_quantity' => 10,
            'status' => 'Active',
        ]);

        // Create a test ecommerce product
        $this->ecommerceProduct = EcommerceProduct::create([
            'warehouse_product_id' => $this->product->id,
            'sku' => 'EC-TEST-001',
            'ecommerce_status' => 'active',
            'shipping_charges' => 50.00,
        ]);
    }

    /** @test */
    public function user_can_access_checkout_page_when_authenticated()
    {
        // Add item to cart
        Cart::create([
            'user_id' => $this->user->id,
            'ecommerce_product_id' => $this->ecommerceProduct->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('checkout'));

        $response->assertStatus(200);
        $response->assertViewIs('frontend.checkout');
        $response->assertViewHas(['checkoutData', 'userAddresses', 'totals', 'user']);
    }

    /** @test */
    public function guest_cannot_access_checkout_page()
    {
        $response = $this->get(route('checkout'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_address()
    {
        $addressData = [
            'user_id' => $this->user->id,
            'address_type' => 'both',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'country' => 'India',
            'state' => 'Maharashtra',
            'city' => 'Mumbai',
            'zipcode' => '400001',
            'address_line_1' => '123 Test Street',
            'address_line_2' => 'Apt 4B',
            'is_default' => true,
        ];

        $address = UserAddress::create($addressData);

        $this->assertDatabaseHas('user_addresses', [
            'user_id' => $this->user->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'city' => 'Mumbai',
        ]);

        $this->assertEquals('John Doe', $address->full_name);
        $this->assertStringContainsString('123 Test Street', $address->formatted_address);
    }

    /** @test */
    public function order_number_is_generated_automatically()
    {
        $order = EcommerceOrder::create([
            'user_id' => $this->user->id,
            'order_source' => 'cart',
            'email' => $this->user->email,
            'shipping_first_name' => 'John',
            'shipping_last_name' => 'Doe',
            'shipping_country' => 'India',
            'shipping_state' => 'Maharashtra',
            'shipping_city' => 'Mumbai',
            'shipping_zipcode' => '400001',
            'shipping_address_line_1' => '123 Test Street',
            'payment_method' => 'cod',
            'subtotal' => 200.00,
            'shipping_charges' => 50.00,
            'total_amount' => 250.00,
        ]);

        $this->assertNotNull($order->order_number);
        $this->assertStringStartsWith('ORD-'.date('Y'), $order->order_number);
    }

    /** @test */
    public function order_item_calculates_total_price_automatically()
    {
        $order = EcommerceOrder::create([
            'user_id' => $this->user->id,
            'order_source' => 'cart',
            'email' => $this->user->email,
            'shipping_first_name' => 'John',
            'shipping_last_name' => 'Doe',
            'shipping_country' => 'India',
            'shipping_state' => 'Maharashtra',
            'shipping_city' => 'Mumbai',
            'shipping_zipcode' => '400001',
            'shipping_address_line_1' => '123 Test Street',
            'payment_method' => 'cod',
            'subtotal' => 200.00,
            'shipping_charges' => 50.00,
            'total_amount' => 250.00,
        ]);

        $orderItem = EcommerceOrderItem::create([
            'ecommerce_order_id' => $order->id,
            'ecommerce_product_id' => $this->ecommerceProduct->id,
            'product_name' => $this->product->product_name,
            'unit_price' => 100.00,
            'quantity' => 2,
            'shipping_charges' => 50.00,
        ]);

        $this->assertEquals(200.00, $orderItem->total_price);
    }
}
