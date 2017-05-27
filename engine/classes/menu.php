<?php
/**
* 
*/
class Menu
{
    public $sidebar_menu;

    public function get_sidebar_menu()
    {
        return '<ul class="sidebar-menu list-unstyled">' . $this->sidebar_menu . '</ul>';
    }

    public function get_custom_menu($classes = null)
    {
        return '<ul class="' . $classes . '">' . $this->sidebar_menu . '</ul>';
    }

    public function set_sidebar_menu($list, $link_prefix = null)
    {
        $this->set($this->sidebar_menu, $list, $link_prefix);
    }

    private function set(&$value, $list, $link_prefix = null)
    {
        foreach ($list as $val) {
            $value .= '<li'
                .(isset($val['active']) && $val['active'] ? ' class="active"' : '').
                '><a href="'
                .(isset($link_prefix) ? $link_prefix : '').$val['link'].
                '">'.$val['name'].'</a></li>';
        }
    }
}
$menu = new Menu;
