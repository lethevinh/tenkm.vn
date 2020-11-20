<?php

namespace App\View\Components;

use Illuminate\Container\Container;
use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Menu as ModelMenu;
use Psr\SimpleCache\InvalidArgumentException;

class Menu extends Component
{
    public $name;

    public $template;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param string $template
     */
    public function __construct($name, $template = 'default')
    {
        $this->name = $name;

        $this->template = $template;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     * @throws InvalidArgumentException
     */
    public function render()
    {
        $locale = session()->get('locale', config('site.locale_default'));
        $allMenu = ModelMenu::getCacheByName($this->name, [
            'template' => $this->template,
            'locale' => $locale
        ]);
        $menu = collect($allMenu)->where('slug_lb', $this->name)->first();
        if (!$menu) {
            return '';
        }
        return view('menus.'.$this->template, ['menu' => $menu]);
    }
}
