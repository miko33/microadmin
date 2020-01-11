<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MicrositeOptions;

class migrateslider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:slider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Slider';
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
        $sliders = MicrositeOptions::where('option_name', 'home_slider_images')->get();
        foreach ($sliders as $key => $value) {
            $data = json_decode($value->value);
            foreach ($data as $key2 => $value2) {
                if(is_string($value2)) {
                    $data[$key2] = [
                        'url' => $value2,
                        'alt' => ''
                    ];
                }
            }
            $value->value = json_encode($data);
            $value->save();
        }
    }
}
