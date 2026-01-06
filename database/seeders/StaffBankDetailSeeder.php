<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\StaffBankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffBankDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffBankDetail::truncate();

        $banks = ['State Bank of India', 'HDFC Bank', 'ICICI Bank', 'Axis Bank', 'Kotak Mahindra Bank', 'Punjab National Bank'];

        Staff::chunk(50, function ($staffs) use ($banks) {
            foreach ($staffs as $staff) {
                $bank = $banks[array_rand($banks)];
                $ifsc = strtoupper(substr(str_replace(' ', '', $bank), 0, 4)) . '0' . str_pad((string)rand(0, 999999), 6, '0', STR_PAD_LEFT);
                StaffBankDetail::create([
                    'staff_id' => $staff->id,
                    'bank_acc_holder_name' => trim($staff->first_name . ' ' . $staff->last_name),
                    'bank_acc_number' => (string) rand(100000000000, 999999999999),
                    'bank_name' => $bank,
                    'ifsc_code' => $ifsc,
                    'passbook_pic' => "uploads/passbook/passbook_{$staff->id}.jpg",
                ]);
            }
        });
    }
}
