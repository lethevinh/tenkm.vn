<?php

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Menu;

class ReactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(\App\Models\Reaction::class, 10)->create();
        $reactions = [
            [
                'name' => 'like',
            ],
            [
                'name' => 'dislike',
            ]
        ];
        foreach ($reactions as $reaction) {
            \App\Models\Reaction::create([
                'title_lb' => $reaction['name'],
                'status_sl' => 'public'
            ]);
        }
    }
}
