<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\EmailVerificationNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        //validation
        // $request->validate([
        //     'name'=>'required|string|max:255',
        //     'email'=>'required|email|max:255|unique:users,email',
        //     'password'=>['required', Password::min(8)->letters()->symbols()->mixedCase()->numbers()],
        //     'role'=>'required|in:user,admin'],

        //     ['password.*' => 'Password must be strong (uppercase, lowercase, number, symbol).'
        // ]);

        //to make response manual
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => ['required', Password::min(8)->letters()->symbols()->mixedCase()->numbers()],
            ],

            [
                'password.*' => 'Password must be strong (uppercase, lowercase, number, symbol).'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        //hash
        $password = Hash::make($request->password);

        //Register by Eloquent
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role'=> $request->role ?? 'user',
            'password' => $password
        ]);

        //create Token (that tken send by Authorization Bearer Token in postman to the front-end)
        $token = $user->createToken('ApiToken')->plainTextToken;

        $user->notify(new EmailVerificationNotify);  //send notification to user to verify email

        return response()->json([
            'success' => true,
            'message' => 'User Created Successfully',
            'token' => $token
        ], 201);

    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        // $user =  User::where('email', $request->email)->first();  //not need as i use Attempt

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email or Password Not Corrrect'
            ], 401);
        }

        $user = Auth::user(); //get all data of the user login

        $user->tokens()->delete();  //delete old tokens
        $token = $user->createToken('ApiToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'Token' => $token,
            'user' => new UserResource($user)
        ], 200);
    }


    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete;  //delete token of user
        return response()->json([
            'success' => true,
            'message' => 'Logged out Successfully'
        ], 200);
    }
}
