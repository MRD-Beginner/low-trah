<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trah;
use App\Models\User;

class AdminController extends Controller
{
    public function route(){
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.keluarga');
        }if ($user->role === 'user') {
            return redirect()->route('user.keluarga');
        }
    }

    public function keluarga(){
        $user = auth()->user();
        $trah =Trah::all();
        return view('admin.dashboard', compact('user', 'trah'));
    }

    public function users(){
        $user = auth()->user();
        $users = User::all();
        return view('admin.users', compact('user', 'users'));
    }
}
