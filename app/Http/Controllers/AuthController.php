<?php
namespace App\Http\Controllers;
use App\Models\SocialAccount;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
class AuthController extends Controller
{
    public function redirect($provider)
    {
        Session::put('url.intended', URL::previous());
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $error = request()->input('error');
        if ($error === 'access_denied') {
            return redirect()->to(Session::get('url.redirect_login'));
        }
        $getInfo = Socialite::driver($provider)->user();
        $user = $this->createOrGetUser($getInfo, $provider);
        if ($user) {
            $user->createToken($user->username)->plainTextToken;
            auth()->login($user);
            return redirect()->to(Session::get('url.redirect_login'));
        }
        return back();
    }

    public function createOrGetUser($providerUser, $provider)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {
                $username = !empty($providerUser->getNickname()) ? $providerUser->getNickname() : Str::slug($providerUser->getName()) . $providerUser->getId();
                $user = User::create([
                    'username' => $username,
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'type_lb' => 'member',
                    'password' => md5(rand(1,10000)),
                    'avatar' => $providerUser->avatar,
                ]);
            }
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider
            ]);
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
