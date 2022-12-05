<?php

namespace App\Console\Commands;

use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use PhpParser\Node\Stmt\TryCatch;

class ExpiredRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired:requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que cambia el estado de las solicitudes vencidas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            ServiceRequest::where('expiration_date', '<',Carbon::now())->update(["status"=>"Expirado"]);

            echo "Actualizado correctamente";
        } catch (\Exception $e) {
            return $e;
        }

    }
}
