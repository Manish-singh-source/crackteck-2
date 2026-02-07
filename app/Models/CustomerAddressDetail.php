<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class CustomerAddressDetail extends Model
{
    protected $table = 'customer_address_details';

    protected $fillable = [
        'customer_id',
        'branch_name',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'pincode',
        'is_primary',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
