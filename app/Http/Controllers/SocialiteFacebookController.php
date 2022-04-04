<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteFacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        try {
            $facebook = Socialite::driver('facebook')->user();
            $user     = UserModel::where('email', $facebook->email)->first();

            if (!$user) {
                $user = UserModel::create([
                    'role_id'  => 4,
                    'name'     => $facebook->name,
                    'email'    => $facebook->email,
                    'password' => $facebook->id,
                ]);
            }

            Auth::loginUsingId($user->id, true);

            return redirect('/');
        } catch (\Exception $e) {
            abort(401);
        }
    }
}