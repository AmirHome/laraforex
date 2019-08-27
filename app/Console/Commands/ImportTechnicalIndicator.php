<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libs\AlphaVantage;

class ImportTechnicalIndicator extends Command
{
    protected $vantage;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:indicator {fnc} {sym} {interval} {period}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @param AlphaVantage $vantage
     */
    public function __construct(AlphaVantage $vantage)
    {
        $this->vantage = $vantage;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        switch ($this->argument('fnc')) {
            case 'EMA':
                // php artisan import:indicator EMA USDEUR daily 10
                $this->vantage->setEma($this->argument('sym'), $this->argument('interval'), $this->argument('period'));
                break;
        }
        echo 'End '.$this->argument('fnc');
    }
}
