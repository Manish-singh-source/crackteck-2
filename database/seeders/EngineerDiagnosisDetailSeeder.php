<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestProduct;
use App\Models\AssignedEngineer;

class EngineerDiagnosisDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // pick some completed/assigned service requests
        $requests = ServiceRequest::inRandomOrder()->limit(10)->get();

        if ($requests->isEmpty()) {
            return;
        }

        $diagnoses = [];

        foreach ($requests as $req) {
            // pick one product if exists
            $srProduct = ServiceRequestProduct::where('service_requests_id', $req->id)->inRandomOrder()->first();
            if (! $srProduct) {
                continue; // cannot create diagnosis without a product
            }

            // try to find a linked assigned engineer (assignment record)
            $assignment = AssignedEngineer::where('service_request_id', $req->id)->inRandomOrder()->first();
            if (! $assignment) {
                continue; // assignment required (assigned_engineer_id references assigned_engineers table)
            }

            // Determine covered item id: prefer srProduct->item_code_id, else try to pick any covered item
            $coveredItemId = $srProduct->item_code_id ?? null;
            if (! $coveredItemId) {
                $covered = DB::table('covered_items')->inRandomOrder()->first();
                $coveredItemId = $covered ? $covered->id : null;
            }

            if (! $coveredItemId) {
                continue; // covered_item_id is required by the schema
            }

            $diagnoses[] = [
                'service_request_id' => $req->id,
                'service_request_product_id' => $srProduct->id,
                'assigned_engineer_id' => $assignment->id,
                'covered_item_id' => $coveredItemId,
                'diagnosis_list' => json_encode(['visual_inspection', 'power_test']),
                'diagnosis_photos' => json_encode(['diag_' . $req->id . '.jpg']),
                'diagnosis_videos' => json_encode([]),
                'diagnosis_notes' => json_encode('Seeder diagnosis notes. Unit shows intermittent power issue.'),
                'diagnosis_report' => null,
                'after_photos' => json_encode([]),
                'before_photos' => json_encode(['before_' . $req->id . '.jpg']),
                'completed_at' => $now->subDays(rand(0, 10))->toDateTimeString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($diagnoses)) {
            DB::table('engineer_diagnosis_details')->insert($diagnoses);
        }
    }
}
