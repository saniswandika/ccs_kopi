<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page)
    {
        // Retrieve the latest 10 users and paginate them
        $data = User::latest()->paginate(10);
        $roles = DB::table('roles')->get();
    
        // Check if the view for the given page exists
        if (view()->exists("pages.{$page}")) {
            // Pass the $data and $roles variables to the view
            return view("pages.{$page}", [
                'data' => $data,
                'roles' => $roles
            ])->with('i', (request()->input('page', 1) - 1) * 5);
        }
    
        // If the view does not exist, return a 404 error
        return abort(404);
    }
    
    

    public function vr()
    {
        return view("pages.virtual-reality");
    }

    public function rtl()
    {
        return view("pages.rtl");
    }

    public function profile()
    {
        return view("pages.profile-static");
    }

    public function signin()
    {
        return view("pages.sign-in-static");
    }

    public function signup()
    {
        return view("pages.sign-up-static");
    }
}
