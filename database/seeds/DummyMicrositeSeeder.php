<?php

use Illuminate\Database\Seeder;
use App\MicrositeMenu;
use App\MicrositeOptions;
use App\MicrositePage;
use Faker\Factory as Faker;

class DummyMicrositeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MicrositeInfo::class, 50)->create()->each(function ($data) {

            $faker = Faker::create('id_ID');
            $microsite_opts = new MicrositeOptions;
            $microsite_opts->site_id = $data->id;
            $microsite_opts->option_name = 'home_slider_images';
            $microsite_opts->value = json_encode([
                $faker->imageUrl(),
                $faker->imageUrl(),
                $faker->imageUrl()
            ]);
            $microsite_opts->save();

            $microsite_opts = new MicrositeOptions;
            $microsite_opts->site_id = $data->id;
            $microsite_opts->option_name = 'home_content';
            $microsite_opts->value = json_encode([
                'title' => $faker->word(),
                'subtitle' => $faker->sentence(),
                'info' => $faker->text(200)
            ]);
            $microsite_opts->save();
            
            $microsite_opts = new MicrositeOptions;
            $microsite_opts->site_id = $data->id;
            $microsite_opts->option_name = 'footer_buttons';
            $microsite_opts->value = json_encode([
                [
                    'title' => 'Link Alternatif',
                    'url' => $faker->url
                ], [
                    'title' => 'Live Chat',
                    'url' => $faker->url
                ]
            ]);
            $microsite_opts->save();
            
            for ($i=0; $i < 3; $i++) { 
                $menu = new MicrositeMenu;
                $menu->site_id = $data->id;
                $menu->title = $faker->words(3, true);
                $menu->url = $faker->url;
                $menu->is_external = 1;
                $menu->save();
            }

            $microsite_opts = new MicrositeOptions;
            $microsite_opts->site_id = $data->id;
            $microsite_opts->option_name = 'menu_order';
            $microsite_opts->value = json_encode(
                $data->menus()->inRandomOrder()->select('id')->get()
            );
            $microsite_opts->save();

            for ($i=0; $i < 3; $i++) { 
                $title = $faker->sentence;
                $microsite_page = new MicrositePage;
                $microsite_page->site_id = $data->id;
                $microsite_page->title = $title;
                $microsite_page->slug = str_slug($title);
                $microsite_page->content = $faker->text;
                $microsite_page->save();
            }

        });
    }
}
