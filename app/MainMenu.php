<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Link;

class MainMenu extends Model
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		Menu::macro('main', function() {
		    return Menu::new()
                ->setWrapperTag('nav')
                ->addClass('nav navbar-nav')
		        ->route('home', 'Home')

                // ->submenu(
                //     Link::to('#', 'User & Role Management <span class="caret"></span>')
                //         ->addClass('dropdown-toggle')
                //         ->setAttributes(['data-toggle' => 'dropdown', 'role' => 'button']),
                //     Menu::new()
                //         ->addClass('dropdown-menu')
                //         ->route('user.index', 'User')
                //         ->route('role.index', 'Role')
                //         ->route('permission.index', 'Permission')
                //         ->html('', ['role' => 'separator', 'class' => 'divider'])
                // )

                ->route('user.index', 'User')
                ->route('role.index', 'Role')
                ->route('permission.index', 'Permission')

                ->setActive(url()->current());
		});
    }
}
