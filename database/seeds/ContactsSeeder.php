<?php

use Dcat\Admin\Models\Menu;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Contact::class, 10)->create();
         Menu::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     => __('site.contact'),
            'icon'      => 'fa-envelope-o',
            'uri'       => 'contacts',
        ]);
    }
}
