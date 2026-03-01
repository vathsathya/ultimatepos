<?php

namespace App\Utils;

class Menu
{
    protected static $instances = [];

    public static function create($name, $callback)
    {
        // dd("Menu identity check: " . get_called_class());
        $menu = new MenuInstance($name);
        self::$instances[$name] = $menu;
        $callback($menu);
        return $menu;
    }

    public static function instance($name)
    {
        if (!isset(self::$instances[$name])) {
            self::$instances[$name] = new MenuInstance($name);
        }
        return self::$instances[$name];
    }

    public static function modify($name, $callback)
    {
        $instance = self::instance($name);
        $callback($instance);
        return $instance;
    }

    public static function render($name, $style = null)
    {
        $instance = self::instance($name);

        // Get style class from config
        $styles = config('menus.styles');
        $presenterClass = isset($styles[$style]) ? $styles[$style] : null;

        if ($presenterClass && class_exists($presenterClass)) {
            $presenter = new $presenterClass($instance);
            return $presenter->render();
        }

        return "";
    }
}

class MenuInstance
{
    public $name;
    protected $items = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function url($url, $title, $options = [])
    {
        $item = new MenuItem($url, $title, $options);
        $this->items[] = $item;
        return $item;
    }

    public function link($url, $title, $options = [])
    {
        return $this->url($url, $title, $options);
    }

    public function header($title, $options = [])
    {
        $item = new MenuItem('#', $title, $options);
        $item->setType('header');
        $this->items[] = $item;
        return $item;
    }

    public function divider($options = [])
    {
        $item = new MenuItem('#', '', $options);
        $item->setType('divider');
        $this->items[] = $item;
        return $item;
    }

    public function add($options)
    {
        $url = isset($options['url']) ? $options['url'] : '#';
        $title = isset($options['title']) ? $options['title'] : '';
        return $this->url($url, $title, $options);
    }

    public function dropdown($title, $callback, $options = [])
    {
        $item = new MenuItem('#', $title, $options);
        $item->setIsDropdown(true);
        $callback($item);
        $this->items[] = $item;
        return $item;
    }

    public function getItems()
    {
        // Sort items by order
        usort($this->items, function ($a, $b) {
            return $a->order - $b->order;
        });
        return $this->items;
    }

    // For Nwidart compatibility in AdminlteCustomPresenter if it calls getChilds on the root (it doesn't usually, it calls it on items)
    public function getChilds()
    {
        return $this->getItems();
    }

    // Compatibility for whereTitle used in modules
    public function whereTitle($title, $callback)
    {
        foreach ($this->items as $item) {
            if ($item->title == $title) {
                $callback($item);
                break;
            }
        }
        return $this;
    }
}

class MenuItem
{
    public $url;
    public $title;
    public $icon;
    public $options;
    public $order = 0;
    protected $type = 'url';
    protected $isDropdown = false;
    protected $childs = [];

    public function __construct($url, $title, $options = [])
    {
        $this->url = $url;
        $this->title = $title;
        $this->options = $options;
        $this->icon = isset($options['icon']) ? $options['icon'] : '';
        $this->order = isset($options['order']) ? $options['order'] : 0;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    public function setIsDropdown($value)
    {
        $this->isDropdown = $value;
        return $this;
    }

    public function url($url, $title, $options = [])
    {
        $item = new MenuItem($url, $title, $options);
        $this->childs[] = $item;
        return $item;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getAttributes()
    {
        $attrs = '';
        if (isset($this->options['id'])) {
            $attrs .= ' id="' . $this->options['id'] . '"';
        }
        // Add more as needed
        return $attrs;
    }

    public function isActive()
    {
        if (isset($this->options['active'])) {
            return $this->options['active'];
        }
        return request()->fullUrlIs($this->url) || request()->url() == $this->url;
    }

    public function hasActiveOnChild()
    {
        foreach ($this->childs as $child) {
            if ($child->isActive() || $child->hasActiveOnChild()) {
                return true;
            }
        }
        return false;
    }

    public function getChilds()
    {
        usort($this->childs, function ($a, $b) {
            return $a->order - $b->order;
        });
        return $this->childs;
    }
}
