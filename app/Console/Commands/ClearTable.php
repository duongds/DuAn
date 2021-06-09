<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ClearTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto clear table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        \DB::table('show_room')->where('show_time', '<', Carbon::now())->delete();
        \DB::table('shows')->where('show_date', '<', Carbon::now())->delete();
    }
}
