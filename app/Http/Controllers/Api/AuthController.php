<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Exception;



class AuthController extends BaseController
{

    public function register(Request $request)
    {

        /*
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 401);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            DB::beginTransaction();
            try {
                User::where('email', $request->email)->update(['password' => bcrypt($request->password), 'email_verified_at' => Carbon::now(), 'activated' => '1']);

                Auth::attempt(['email' => $request->email, 'password' => $request->password]);

                $user = User::where('email', $request->email)->first();
                $user->assignRole('User');
                if (!UserProfile::where('user_id', $user->id)->exists()) {
                    UserProfile::create([
						'name' => $request->email,
						'user_id' => $user->id,
					]);
                }
                $token = $user->createToken("API TOKEN")->accessToken;

                DB::commit();
                $data = [
                    'email'    => $user->email,
                    'name'      => $user->name,
                    'phone'     => $user->phone,
                    'token'     => $token
                ];
                return $this->sendResponse($data, 'User registered', 201);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->sendError('Error.', $th->getMessage(), 500);
            }
        } else {
            return $this->sendError('Error.', "User email not found", 404);
        }

        */
    }
    public function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validator->fails()) {

                return $this->sendError('Validation Error.', $validator->errors(), 401);
            }

            $user = User::where('email', $request->email)->first();

            // if ($user->blocked) {
            //     return $this->sendError('user blocked.', ['error' => 'Unauthorised'], 403);
            // }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->sendError('Email & Password does not match with our record.', ['error' => 'Unauthorised'], 401);
            }
            
            $token = $user->createToken("API TOKEN")->plainTextToken;
            // get user profile data and send
            $data = [
                'email'    => $user->email,
                'name'      => $user->name,
                'token'     => $token
            ];

            return $this->sendResponse($data, 'User Logged In Successfully');
        } catch (\Throwable $th) {
            return $this->sendError('Error.', $th->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->sendResponse("user", 'User Logged In Successfully');
    }

    

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error.', $validator->getMessageBag(), 400);
        } else {
            $user = User::where(['email' => $request->email])->first();
            if ($user) {
                $user->update(['password'=> Hash::make(($request->password))]);
                $token = $user->createToken("API TOKEN")->accessToken;
                // get user profile data and send
                $data = [
                    'email'    => $user->email,
                    'name'      => $user->name,
                    'token'     => $token
                ];
                return $this->sendResponse($data, 'password updated successfully!');
            } else {
                return $this->sendError('Error.', 'Invalid Email id', 404);
            }
        }
    }

    

    
}
