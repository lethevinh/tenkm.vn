<?php
namespace App\database\seeds;

use Illuminate\Database\Seeder;

class ViPackageBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\ContactsSeeder::class);
        $this->call(\PostCategoriesSeeder::class);
        $this->call(\Tagseeder::class);
        $this->call(\PagesSeeder::class);
        $this->call(\MenusSeeder::class);
        $this->call(\ReactionsSeeder::class);
        $this->call(\PostsSeeder::class);
        $this->call(\ProductCategorySeeder::class);
        $this->call(\ProjectCategorySeeder::class);
        $this->call(\AmenitySeeder::class);
        $this->call(\ProductSeeder::class);
        $this->call(\ProjectSeeder::class);
        $this->call(\UsersSeeder::class);
        $this->call(\LocationsSeeder::class);
    }
}
