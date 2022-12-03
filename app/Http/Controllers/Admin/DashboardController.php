<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Slider;
use App\Models\Reward;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Order;
class DashboardController extends Controller
{
    public function index(){
        $user_count = User::count();
        $menu_count = Menu::count();
        $menucat_count = MenuCategory::count();
        $slider_count = Slider::count();
        $reward_count = Reward::count();
        return view('admin.dashboard',compact('user_count','menu_count','menucat_count','slider_count','reward_count'));
    }
}
