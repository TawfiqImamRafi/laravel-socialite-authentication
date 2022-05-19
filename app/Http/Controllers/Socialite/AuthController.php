<?php

namespace App\Http\Controllers\Socialite;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $userSocial= Socialite::driver('google')->stateless()->user();
        $users=User::where(['email' => $userSocial->getEmail()])->first();
        if($users)
            {
                Auth::login($users);
                return redirect()->route('dashboard');
            }else{
                $user = User::create([
                'name'=> $userSocial->getName(),
                'email'=> $userSocial->getEmail(),
                ]);
                return redirect()->route('dashboard');
            }
    }
}
