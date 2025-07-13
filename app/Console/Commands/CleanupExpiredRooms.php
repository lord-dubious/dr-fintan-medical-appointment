<?php

namespace App\Console\Commands;

use App\Services\DailyService;
use Illuminate\Console\Command;

class CleanupExpiredRooms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:cleanup-rooms {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired Daily.co rooms for completed appointments';

    /**
     * Execute the console command.
     */
    public function handle(DailyService $dailyService): int
    {
        $this->info('Starting Daily.co room cleanup...');

        try {
            if ($this->option('dry-run')) {
                $this->warn('DRY RUN MODE - No rooms will actually be deleted');

                $expiredRooms = $dailyService->getExpiredRooms();
                if (count($expiredRooms) > 0) {
                    $this->info('Would delete ' . count($expiredRooms) . ' expired room(s):');
                    foreach ($expiredRooms as $room) {
                        $this->line("  - {$room['name']} (appointment #{$room['appointment_id']})");
                    }
                } else {
                    $this->info('No expired rooms found to delete.');
                }

                return 0;
            }

            $deletedCount = $dailyService->cleanupExpiredRooms();
            
            if ($deletedCount > 0) {
                $this->info("Successfully deleted {$deletedCount} expired room(s).");
            } else {
                $this->info('No expired rooms found to delete.');
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to cleanup rooms: ' . $e->getMessage());
            return 1;
        }
    }
}
