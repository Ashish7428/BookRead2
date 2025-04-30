<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReadingProgress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AutoSaveReadingProgress extends Command
{
    protected $signature = 'reading:auto-save';
    protected $description = 'Auto save reading progress for active users';

    public function handle()
    {
        Log::info('AutoSaveReadingProgress started at: ' . now());
        
        try {
            $activeReaders = ReadingProgress::where('status', 'reading')
                ->where(function($query) {
                    $query->where('last_activity', '>=', Carbon::now()->subMinutes(15))
                          ->orWhereNull('last_activity');
                })
                ->get();
            
            Log::info('Found ' . $activeReaders->count() . ' active readers');
            
            foreach ($activeReaders as $progress) {
                try {
                    // Update last_activity and touched timestamps
                    $progress->update([
                        'last_activity' => now(),
                        'updated_at' => now()
                    ]);
                    
                    Log::info("Successfully saved progress for user {$progress->user_id} reading book {$progress->book_id}", [
                        'user_id' => $progress->user_id,
                        'book_id' => $progress->book_id,
                        'progress' => $progress->progress,
                        'last_activity' => $progress->last_activity
                    ]);
                } catch (\Exception $e) {
                    Log::error("Error saving individual progress: " . $e->getMessage(), [
                        'user_id' => $progress->user_id,
                        'book_id' => $progress->book_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Critical error in AutoSaveReadingProgress: " . $e->getMessage());
            return 1;
        }

        Log::info('AutoSaveReadingProgress completed at: ' . now());
        return 0;
    }
}

