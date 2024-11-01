<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use  App\Models\User;
use  App\Models\Category;
use  App\Models\Service;
use  App\Models\Order;
use  App\Models\Balance;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*$users = User::count();
        $categories = Category::whereNull('parent_id')->count();
        $subcategories = Category::whereNotNull('parent_id')->count();

        return view('dashboard', compact('users','categories','subcategories'));*/
    }



}
