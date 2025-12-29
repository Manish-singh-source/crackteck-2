<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCompanyDetail extends Model
{
    //
    protected $fillable = [
        'customer_id',
        'company_name',
        'comp_address1',
        'comp_address2',
        'comp_city',
        'comp_state',
        'comp_country',
        'comp_pincode',
        'gst_no',
    ];
}
