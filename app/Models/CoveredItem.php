<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CoveredItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item_code',
        'service_type',
        'image',
        'service_name',
        'service_charge',
        'status',
        'diagnosis_list',
        'device_specific_diagnosis_id',
    ];

    protected $casts = [
        'diagnosis_list' => 'array',
    ];


    public static function generateItemCode($typeCode): string
    {
        $typeName = $typeCode;          // e.g. "Installation"
        $typeSlug = Str::upper(Str::slug($typeName, ''));           // "INSTALLATION"

        $random = Str::upper(Str::random(4));                     // 4 random chars

        return 'CI'.'-'.$typeSlug.'-'.$random;                    // e.g. CIINSTALLATION-AB3X
    }
}
