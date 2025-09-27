<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bill;
use App\Models\Boarder;
use Carbon\Carbon;

class GenerateMonthlyBills extends Command
{
    protected $signature = 'bills:generate-monthly';
    protected $description = 'Generate monthly bills for all boarders';

    public function handle()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $boarders = Boarder::all();
        foreach ($boarders as $boarder) {
            Bill::create([
                'boarder_id' => $boarder->id,
                'type' => 'other', // e.g. rent, you can adjust
                'amount' => 3000,  // adjust dynamically if needed
                'period_start' => $start,
                'period_end' => $end,
                'is_auto_generated' => true,
                'is_paid' => false,
            ]);
        }

        $this->info('Monthly bills generated successfully.');
    }
}
