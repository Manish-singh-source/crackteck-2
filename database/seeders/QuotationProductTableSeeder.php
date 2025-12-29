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
        $quotations = Quotation::all();
        //
        QuotationProduct::factory()->count(10)->make()->each(function ($quotationProduct) use ($quotations) {
            $quotation = $quotations->random();
            $quotationProduct->quotation_id = $quotation->id;
            $quotationProduct->save();
        });
    }
}
