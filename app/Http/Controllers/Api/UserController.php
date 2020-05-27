<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Traits\ApiResponsable;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponsable, AuthenticatesUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function loginApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            // 'device_name' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return $this->respondNotFound('login_error', ['error' => $validator->errors()]);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return $this->respondNotFound('login_error', ['error' => ['username' => ['user_not_exist']]]);
        }

        if (!Hash::check($request->password, $user->password)) {
               //return $this->respondNotFound('login_error', ['error' => ['password' => ['password_incorrect']]]);
        }

        $credentials = $request->only('username', 'password');
        if (!Auth::attempt($credentials)) {
            return $this->respondNotFound('login_error', ['error' => ['password' => ['password_incorrect']]]);
        }

        return $this->respondOk('login_success', [
            'token' => $user->createToken($request->username)->plainTextToken,
            'user' => $user->toInfo()
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            // 'device_name' => ['required', 'string']
        ]);
        // 1
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        // 2
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // 3
        $token = $user->createToken($request->username)->plainTextToken;
        // 4
        return response()->json(['token' => $token], 200);
    }

    public function logoutApi(Request $request)
    {
        if (auth()->guard('web')->logout()) {
            return response()->json(['message' => 'Logged Out','token' =>  ''], 200);
        }
    }
}
