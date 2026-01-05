<?php

namespace Database\Seeders;

use App\Models\Quotation;
use App\Models\QuotationProduct;
use Illuminate\Database\Seeder;

class QuotationProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have quotations
        if (Quotation::count() === 0) {
            Quotation::factory()->count(10)->create();
        }

        // Create 1-5 line items per quotation
        Quotation::all()->each(function ($quotation) {
            QuotationProduct::factory()->count(rand(1, 5))->create([
                'quotation_id' => $quotation->id,
            ]);
        });
    }
}
