<?php

namespace App\Console\Commands;

use App\Enums\Financeiro\FaturaEnum;
use App\Models\Faturas\Fatura;
use Illuminate\Console\Command;

class AtualizarFaturas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atualizar:faturas';

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
        $this->info('Atualizando faturas...');
        // mude o status para atrasados de todas faturas atrasadas pela data de vencimento com status Aberta ou Pago_Parcial para Atrasada
        Fatura::where('data_vencimento', '<', now()->format('Y-m-d'))
            ->whereIn('status', [FaturaEnum::Aberta, FaturaEnum::Pago_Parcial])
            ->update(['status' => FaturaEnum::Atrasada]);

        $this->info('Faturas atualizadas com sucesso!');
    }
}
