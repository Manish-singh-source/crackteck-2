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
        'service_name',
        'service_charge',
        'status',
        'diagnosis_list',
    ];

    protected $casts = [
        'diagnosis_list' => 'array',
    ];

    // Map numeric type to name
    public static function getServiceTypeName($typeCode): string
    {
        // for
        // amc is AMC
        // quick service is QS
        // installation is INST
        // repair is REP
        $map = [
            '0' => 'AMC',
            '1' => 'QS',
            '2' => 'INST',
            '3' => 'REP',
        ];

        $key = (string) $typeCode;

        return $map[$key] ?? 'Unknown';
    }

    public static function generateItemCode($typeCode): string
    {
        $typeName = static::getServiceTypeName($typeCode);          // e.g. "Installation"
        $typeSlug = Str::upper(Str::slug($typeName, ''));           // "INSTALLATION"

        $random = Str::upper(Str::random(4));                     // 4 random chars

        return 'CI'.'-'.$typeSlug.'-'.$random;                    // e.g. CIINSTALLATION-AB3X
    }
}
