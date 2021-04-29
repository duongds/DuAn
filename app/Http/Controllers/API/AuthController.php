<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends AppBaseController
{
    /**
     * Create user
     *
     * @param UserStoreRequest $request
     * @return mixed [string] message
     */
    public function signup(UserStoreRequest $request)
    {
        $data = $request->validated();
        $user = new User([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password)
        ]);
        $user->save();
        return $this->sendResponse($user, 'Successfully created user!');
    }

    /**
     * Login user and create token
     *
     * @param UserRequest $request
     * @return JsonResponse [string] access_token
     */
    public function login(UserRequest $request)
    {
        $data = $request->validated();
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $data->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($data->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(env('SESSION_LIFETIME'));
        $token->save();
        return $this->sendResponse([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user], 200);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return mixed [json] user object
     */
    public function getUser()
    {
        $user = \Auth::user();
        return $this->sendResponse($user, 200);
    }
}
