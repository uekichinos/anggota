<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use App\Setting;

class Maintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable and disable maintenance based on maintenance module setting';

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
     * @return mixed
     */
    public function handle()
    {
        $settings = Setting::where('param', 'LIKE', 'maintenance_%')->get();
        if(count($settings) > 0) {
            $config = [];
            foreach ($settings as $key => $setting) {
                $config[$setting->param] = $setting->value;
            }

            if(count($config) > 0) {
                $mode = $config['maintenance_mode'];
                $retry = $config['maintenance_retry'];
                $allow = $config['maintenance_allow'];
                $msg = $config['maintenance_msg'];
                $down_file = storage_path().'/framework/down';

                if($mode == 'yes' && !file_exists($down_file)) {
                    Artisan::queue('down --message="'.$msg.'" --retry='.$retry);
                }
                elseif($mode == 'no' && file_exists($down_file)) {
                    Artisan::queue('up');
                }
            }
        }
    }
}
