<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\User;

class TicketCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $tickets = Ticket::inRandomOrder()->limit(30)->get();
        if ($tickets->isEmpty()) {
            return;
        }

        $users = User::inRandomOrder()->limit(5)->get();

        $comments = [];

        foreach ($tickets as $ticket) {
            $num = rand(1, 3);
            for ($i = 0; $i < $num; $i++) {
                $isInternal = rand(0, 4) === 0 ? 1 : 0; // ~20% internal
                $creator = $users->isNotEmpty() ? $users->random()->id : null;

                $attachments = [];
                if (rand(0, 3) === 0) {
                    $attachments[] = 'screenshot_' . rand(1, 10) . '.png';
                }

                $comments[] = [
                    'ticket_id' => $ticket->id,
                    'created_by' => $creator,
                    'comment' => $isInternal ? 'Internal note: follow up with vendor.' : 'Customer comment: please assist with the issue.',
                    'attachments' => !empty($attachments) ? json_encode($attachments) : null,
                    'is_internal' => $isInternal,
                    'created_at' => $now->subDays(rand(0, 30))->subMinutes(rand(0, 1440))->toDateTimeString(),
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($comments)) {
            DB::table('ticket_comments')->insert($comments);
        }
    }
}
