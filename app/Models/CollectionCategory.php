<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionCategory extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'collection_id',
        'category_id',
        'sort_order',
    ];
}
