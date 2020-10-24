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
        $pageStore = Page::getStore();
        $keyCache = Page::cachePrefix('site');
        if (!Page::enableCache()) {
            $page = Page::site();
        }else {
            if (!$pageStore->has($keyCache)) {
                $page = Page::site();
                $page->forever($page);
            }
            $page = $pageStore->get($keyCache);
        }
        if ($key == 'name') {
            return $page->title_lb;
        }
        $option = $page->metas->where('key_lb', $key)->first();
        if ($option && isset($option['value_lb'])) {
            return $option['value_lb'];
        }
        return !empty($default) ? $default : $key;
    }
}
