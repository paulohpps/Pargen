<?php

namespace App\Console\Commands;

use App\Services\AtualizarDatabaseService;
use Illuminate\Console\Command;

class AtualizarDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        AtualizarDatabaseService::atualizar();
    }
}
