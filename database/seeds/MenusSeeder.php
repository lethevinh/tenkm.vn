<?php

use Dcat\Admin\Models\Menu as MenuAdmin;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Page;
use \Dcat\Admin\Models\Administrator;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Menu::class, 10)->create();
        $admin = Administrator::first();
        $site = Page::create([
            'title_lb'      =>  'site',
            'status_sl' => 'private'
        ]);
        $home = Page::create([
            'title_lb' => __('site.home'),
            'template_lb' => 'home'
        ]);
        if ($site) {
            $site->addField([
                'name_lb'=> 'email',
                'default_lb' => 'abc@osa.com',
                'label_lb' => 'Email Site',
                'type_lb' => 'email'
            ]);
            $site->setMeta([
                'key_lb' => 'email',
                'value_lb' => 'abc@osa.com'
            ]);
            $site->addField([
                'name_lb'=> 'phone',
                'default_lb' => '0394037182',
                'label_lb' => 'Phone Site',
                'type_lb' => 'mobile'
            ]);
            $site->setMeta([
                'key_lb' => 'phone',
                'value_lb' => '0394037182'
            ]);
            $site->addField([
                'name_lb'=> 'theme',
                'default_lb' => config('site.theme'),
                'label_lb' => 'Theme Site',
                'type_lb' => 'text'
            ]);
            $site->setMeta([
                'key_lb' => 'theme',
                'value_lb' => config('site.theme')
            ]);
            $site->addField([
                'name_lb'=> 'logo',
                'default_lb' => 'images/logo.png',
                'label_lb' => 'Logo Site',
                'type_lb' => 'media_image'
            ]);
            $site->setMeta([
                'key_lb' => 'logo',
                'value_lb' => 'images/logo.png'
            ]);
            $site->addField([
                'name_lb'=> 'home_id',
                'default_lb' => $home->id,
                'label_lb' => 'Page Home',
                'type_lb' => 'select_page'
            ]);
            $site->setMeta([
                'key_lb' => 'home',
                'value_lb' => $home->id
            ]);
            $site->addField([
                'name_lb'=> 'address',
                'default_lb' => '67 Le Loi Ho Chi Minh',
                'label_lb' => 'Address Site',
                'type_lb' => 'text'
            ]);
            $site->setMeta([
                'key_lb' => 'address',
                'value_lb' => '67 Le Loi Ho Chi Minh'
            ]);
            $site->addField([
                'name_lb'=> 'description',
                'default_lb' => 'Welcome to My Website',
                'label_lb' => 'Description Site',
                'type_lb' => 'textarea'
            ]);
            $site->setMeta([
                'key_lb' => 'description',
                'value_lb' => 'Welcome to My Website'
            ]);
            $site->addField([
                'name_lb'=> 'facebook_page_id',
                'default_lb' => 'Facebook App ID',
                'label_lb' => 'Facebook App ID',
                'type_lb' => 'text'
            ]);
            $site->addField([
                'name_lb'=> 'facebook',
                'default_lb' => 'Facebook.com',
                'label_lb' => 'Facebook Link',
                'type_lb' => 'text'
            ]);
            $site->addField([
                'name_lb'=> 'youtube',
                'default_lb' => 'youtube.com',
                'label_lb' => 'Youtube Link',
                'type_lb' => 'text'
            ]);
        }
        $main = Menu::create([
            'title_lb'      =>  __('site.main'),
            'url_lb'        => route('home.show'),
            'order_nb'      => 1,
            'parent_id'     => 0,
            'status_sl'     => 'public',
            'updated_by'    => $admin->id,
            'created_by'    => $admin->id,
        ]);
        $about = Page::create([
            'title_lb'      =>  __('site.about'),
            'template_lb' => 'about'
        ]);
        $blogPage = Page::create([
            'title_lb'      =>  __('site.blog'),
            'template_lb' => 'blog'
        ]);
        $contact = Page::create([
            'title_lb'      =>  __('site.contact'),
            'template_lb' => 'contact'
        ]);
        $product = Page::create([
            'title_lb'      =>  __('site.product'),
            'template_lb' => 'product'
        ]);
        $project = Page::create([
            'title_lb'      =>  __('site.project'),
            'template_lb' => 'project'
        ]);
        if ($main) {
            Menu::create([
                'title_lb'      =>  __('site.home'),
                'url_lb'        => route('home.show'),
                'order_nb'      => 1,
                'parent_id'     => $main->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
            Menu::create([
                'title_lb'      =>  __('site.about'),
                'url_lb'        => $about->link,
                'order_nb'      => 2,
                'parent_id'     => $main->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
            $blog = Menu::create([
                'title_lb'      =>  __('site.post'),
                'url_lb'        => $blogPage->link,
                'order_nb'      => 5,
                'parent_id'     => $main->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
            if ($blog) {
                Menu::create([
                    'title_lb'      =>  __('site.blog'),
                    'url_lb'        => route('post.index'),
                    'order_nb'      => 1,
                    'parent_id'     => $blog->id,
                    'status_sl'     => 'public',
                    'updated_by'    => $admin->id,
                    'created_by'    => $admin->id,
                ]);
            }
            if ($product) {
                Menu::create([
                    'title_lb'      =>  __('site.product'),
                    'url_lb'        => route('product.index'),
                    'order_nb'      => 1,
                    'parent_id'     => $main->id,
                    'status_sl'     => 'public',
                    'updated_by'    => $admin->id,
                    'created_by'    => $admin->id,
                ]);
            }
            if ($project) {
                Menu::create([
                    'title_lb'      =>  __('site.project'),
                    'url_lb'        => route('project.index'),
                    'order_nb'      => 1,
                    'parent_id'     => $main->id,
                    'status_sl'     => 'public',
                    'updated_by'    => $admin->id,
                    'created_by'    => $admin->id,
                ]);
            }
            Menu::create([
                'title_lb'      =>  __('site.contact'),
                'url_lb'        => $contact->link,
                'order_nb'      => 6,
                'parent_id'     => $main->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
        }

        $footer = Menu::create([
            'title_lb'      =>  __('site.footer'),
            'url_lb'        => '#',
            'order_nb'      => 2,
            'parent_id'     => 0,
            'status_sl'     => 'public',
            'updated_by'    => $admin->id,
            'created_by'    => $admin->id,
        ]);
        if ($footer) {
            Menu::create([
                'title_lb'      =>  __('site.home'),
                'url_lb'        => route('home.show'),
                'order_nb'      => 1,
                'parent_id'     => $footer->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
            Menu::create([
                'title_lb'      =>  __('site.about'),
                'url_lb'        => $about->link,
                'order_nb'      => 2,
                'parent_id'     => $footer->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
            Menu::create([
                'title_lb'      =>  __('site.blog'),
                'url_lb'        => route('post.index'),
                'order_nb'      => 1,
                'parent_id'     => $footer->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
            Menu::create([
                'title_lb'      =>  __('site.contact'),
                'url_lb'        => $contact->link,
                'order_nb'      => 6,
                'parent_id'     => $footer->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
        }
        $privacy = Menu::create([
            'title_lb'      =>  __('site.privacy'),
            'url_lb'        => '#',
            'order_nb'      => 2,
            'parent_id'     => 0,
            'status_sl'     => 'public',
            'updated_by'    => $admin->id,
            'created_by'    => $admin->id,
        ]);
        if ($privacy) {
            $sitemap = Page::create([
                'title_lb'      =>  __('site.sitemap'),
                'template_lb' => 'sitemap'
            ]);
            Menu::create([
                'title_lb'      =>  __('site.sitemap'),
                'url_lb'        => $sitemap->link,
                'order_nb'      => 1,
                'parent_id'     => $privacy->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
            $policy = Page::create([
                'title_lb'      =>  __('site.policy'),
                'template_lb' => 'policy'
            ]);
            Menu::create([
                'title_lb'      =>  __('site.policy'),
                'url_lb'        => $policy->link,
                'order_nb'      => 1,
                'parent_id'     => $privacy->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
            $private = Page::create([
                'title_lb'      =>  __('site.private'),
                'template_lb' => 'private'
            ]);
            Menu::create([
                'title_lb'      =>  __('site.private'),
                'url_lb'        => $private->link,
                'order_nb'      => 1,
                'parent_id'     => $privacy->id,
                'status_sl'     => 'public',
                'updated_by'    => $admin->id,
                'created_by'    => $admin->id,
            ]);
        }
        MenuAdmin::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     => __('admin.menu'),
            'icon'      => 'fa-bars',
            'uri'       => 'menus',
        ]);
    }
}
