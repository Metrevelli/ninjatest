<?php

namespace App\Console\Commands;

use App\Models\UserToken;
use Illuminate\Console\Command;

class DeleteExpiredAccessTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:expired-access-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all expired access tokens';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        UserToken::expired()->delete();
    }
}
