<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, LogsActivity, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the wishlist items for the user.
    //  */
    // public function wishlists()
    // {
    //     return $this->hasMany(Wishlist::class);
    // }

    // /**
    //  * Get the stock requests made by this user.
    //  */
    // public function stockRequests()
    // {
    //     return $this->hasMany(StockRequest::class, 'requested_by');
    // }

    // /**
    //  * Get the e-commerce products in the user's wishlist.
    //  */
    // public function wishlistProducts()
    // {
    //     return $this->belongsToMany(EcommerceProduct::class, 'wishlists', 'user_id', 'ecommerce_product_id')
    //         ->withTimestamps();
    // }

    // /**
    //  * Get the cart items for the user.
    //  */
    // public function carts()
    // {
    //     return $this->hasMany(Cart::class);
    // }

    // /**
    //  * Get the e-commerce products in the user's cart.
    //  */
    // public function cartProducts()
    // {
    //     return $this->belongsToMany(EcommerceProduct::class, 'carts', 'user_id', 'ecommerce_product_id')
    //         ->withPivot('quantity')
    //         ->withTimestamps();
    // }

    // /**
    //  * Get the user's addresses.
    //  */
    // public function addresses()
    // {
    //     return $this->hasMany(UserAddress::class);
    // }

    // /**
    //  * Get the user's e-commerce orders.
    //  */
    // public function ecommerceOrders()
    // {
    //     return $this->hasMany(EcommerceOrder::class);
    // }

    // /**
    //  * Get the user's default shipping address.
    //  */
    // public function defaultShippingAddress()
    // {
    //     return $this->hasOne(UserAddress::class)
    //         ->where('address_type', 'shipping')
    //         ->where('is_default', true);
    // }

    // /**
    //  * Get the user's default billing address.
    //  */
    // public function defaultBillingAddress()
    // {
    //     return $this->hasOne(UserAddress::class)
    //         ->where('address_type', 'billing')
    //         ->where('is_default', true);
    // }

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => "User {$eventName}");
    }
}
