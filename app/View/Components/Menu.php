<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Menu as Menu_model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Menu extends Component
{
    /**
     * Create a new component instance.
     */
    public $cab_urls;//ключи id ролей
    public $no_cab_urls;
    public $cur_url;

    public function __construct(Request $request)
    {
        $this -> cab_urls = [
           2 => '/manager_office/',
           3 => '/provider_office/',
           4 => '/customer_office/',
           1 => '/admin_office/'
        ];

        $this -> no_cab_urls = [
            '/registration/',
            '/auth/',
            '/reg_manager/',
            '/reg_provider/'
        ];

        $path = $request->path();
        if($path == '/')
        {
            $this -> cur_url = $path;
        }
        else
        {
            $this -> cur_url = '/'.$path.'/';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $chek_auth = Auth::check();
        $menu = Menu_model::all();
        return view('components.menu', [
            'menu' => $menu,
            'chek_auth' => $chek_auth,
            'role_id' => $chek_auth ? Auth::user()->role_id : null
        ]);
    }
}
