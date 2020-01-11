<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('By doing this, data on microsite_info, microsite_options, microsite_page, microsite_menus will be wiped out, are you sure you want to run this command?')) {
            App\MicrositeInfo::truncate();
            App\MicrositeOptions::truncate();
            App\MicrositePage::truncate();
            App\MicrositeMenu::truncate();
            $this->call(DummyMicrositeSeeder::class);
        }
    }
}
