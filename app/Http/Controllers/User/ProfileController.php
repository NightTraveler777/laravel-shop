<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
        return view('user.profile');
    }

    public function switch($type) {
        $profile = Profile::where('user_id', '=', auth()->user()->id)
            ->where('type', '=', $type)->first();

        auth()->user()->switch_profile($profile->id);
        return back()->with('success', 'Тип профиля был изменен');
    }
}
