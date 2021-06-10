<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\ChangePasswordAPIRequest;
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
    public function signup(Request $request)
    {
        $data = $request->all();
        $email_validate = User::where('email', $data['email'])->first();
        $name_validate = User::where('name', $data['name'])->first();
        if ($email_validate) {
            return $this->sendError('ER002', 400);
        }
        if ($name_validate) {
            return $this->sendError('ER003', 400);
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 0
        ]);

        return $this->sendResponse($user, 'Successfully created user!');
    }

    /**
     * Login user and create token
     *
     * @param UserRequest $request
     * @return JsonResponse [string] access_token
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'ER001'
            ], 401);
        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
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

    public function changePassword(ChangePasswordAPIRequest $request)
    {
        $user = $request->user();
        $input = $request->except(['skip', 'limit']);
        if (!(Hash::check($input['current_password'], $user->password))) {
            return $this->sendError('Nhập mật khẩu hiện tại không đúng.');
        } else if ((Hash::check($input['new_password'], $user->password))) {
            return $this->sendError('Password mới trùng password cũ.');
        } else if ($input['new_password'] != $input['new_confirm_password']) {
            return $this->sendError('Password mới và confirm password không khớp.');
        }
        $user->update(['password' => Hash::make($input['new_password'])]);

        return $this->sendSuccess('Thay đổi mật khẩu thành công');
    }

    public function forgetPassword(Request $request)
    {
        $input = $request->except(['skip', 'limit']);
        $user = User::where('email', $input['email'])->first();
        if (!is_null($user)) {
            if ($input['new_password'] != $input['new_confirm_password']) {
                return $this->sendError('Password mới và confirm password không khớp.');
            }
            $user->update(['password' => Hash::make($input['new_password'])]);
            return $this->sendSuccess("thay đổi giao diện thành công.");
        }
        return $this->sendError("Tài khoản không tồn tại");
    }
}
