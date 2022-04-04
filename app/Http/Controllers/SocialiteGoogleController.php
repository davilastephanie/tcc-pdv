<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteGoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $google = Socialite::driver('google')->user();
            $user   = UserModel::where('email', $google->email)->first();

            if (!$user) {
                $user = UserModel::create([
                    'role_id'  => 4,
                    'name'     => $google->name,
                    'email'    => $google->email,
                    'password' => $google->id,
                ]);
            }

            Auth::loginUsingId($user->id, true);

            return redirect('/');
        } catch (\Exception $e) {
            abort(401);
        }
    }
}