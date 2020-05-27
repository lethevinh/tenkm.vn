<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
class AuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
        $user = $this->createUser($getInfo, $provider);
        $user->createToken($user->username)->plainTextToken;
        auth()->login($user);
        return redirect()->to(route('home.show'));
    }

    function createUser($getInfo, $provider)
    {
        $user = User::where('provider_id', $getInfo->id)->first();
        if (!$user) {
            $user = User::create([
                'name' => $getInfo->name,
                'username' => Str::slug($getInfo->name),
                'avatar' => $getInfo->avatar,
                'email' => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);
        }
        return $user;
    }
}
