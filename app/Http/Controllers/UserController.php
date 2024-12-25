<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index() {

        return view('home.user.index', [
            'users' => User::where('email', '!=', auth()->user()->email)->get()
        ]);
    }
}
