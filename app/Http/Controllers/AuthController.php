<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //

    /**
     * Register new user.
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->formatInputErrorResponse($validator->errors()->first());
        }

        $validatedData = $request->all();
        $validatedData['password'] = bcrypt($request->password);
        $validatedData['uuid'] = Str::uuid();

        $user = User::create($validatedData);

        $access_token = $user->createToken('authToken')->plainTextToken;

        $data = [
            'user' => $user,
            'access_token' => $access_token
        ];
        return $this->formatCreatedResponse('Registration successful', $data);
    }
}
