<?php

namespace App\Console\Commands;

use App\Models\ClientContract;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;

class UpdateContractStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policy:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates expired policies\' status';

    /**
     * @var int
     */
    const EXPIRED = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ClientContract::expired()->chunkById(100, function (Collection $contracts) {
            $contracts->each(function (ClientContract $contract) {
                $contract->update(['status' => self::EXPIRED]);
            });
        });
    }
}
