<?php

use App\Models\Page;

if (!function_exists('resize')) {
    function resize($file, $width, $height)
    {
        $filePath = public_path('storage/' . $file);
        if (file_exists($filePath)) {
            return route('image.single', [
                'width' => $width,
                'height' => $height,
                'action' => 'resize',
                'path' => basename($filePath)
            ]);
        }
        return $file;
    }
}
if (!function_exists('menu')) {
    function menu($name = 'main')
    {
        $menu = app('menu')->where('slug_lb', $name)->first();
        if (empty($menu)) return '';
        $templates = [];
        $templates[] = 'menus.' . $menu->slug_lb;
        $templates[] = 'menus.default';
        return view()->first($templates, ['menu' => $menu]);
    }
}

if (!function_exists('option')) {
    function option($key = null, $default = '')
    {
        $key = str_replace("'", "", $key);
        $page = Page::site();
        if (!$page) {
            return !empty($default) ? $default : $key;
        }
        if ($key == 'name') {
            return $page->title_lb;
        }
        $option = $page->metas->where('key_lb', $key)->first();

        return !empty($option['value_lb'])?$option['value_lb']:$default;
    }
}
if (!function_exists('current_theme')) {

    function current_theme() {

    }
}

if (!function_exists('theme_dir_view')) {
    function theme_dir_view($path = '') {
        return resource_path("themes/" . config('site.theme') . '/template/' . $path);
    }
}

if (!function_exists('do_shortcode')) {
    function do_shortcode($html) {
        return app('shortcode')->doShortcodes($html);
    }
}

if (!function_exists('truncate')) {
    function truncate($string, $limit = 20, $end = ' (...)') {
        return  \Illuminate\Support\Str::limit($string, $limit, $end);
    }
}
