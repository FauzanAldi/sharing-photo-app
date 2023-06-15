<?php

namespace App\Http\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;

use App\Http\Auth\Request\RefreshTokenRequest;
use App\Http\Auth\Request\LoginRequest;

use App\Http\Resources\MessageErrorResource;
use App\Http\Auth\Resources\AuthCollection;
use App\Http\Auth\Resources\AuthUserCollection;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $requestData = $request->validated();

        $data = (new User)->actionlogin($requestData['username'], $requestData['password']);

        if(count($data)==0){
            return $this->fail_attempt('AUTH_WRONG','Username or Password Wrong');
        }

        return $this->respondWithToken($data['access_token'], $data['refresh_token'], auth()->user());

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {

        return new AuthUserCollection(auth()->user());

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(RefreshTokenRequest $request)
    {

        try {

            $request->validated();

            $data = (new User)->action_refresh_token($request['refresh_token']);

            return $this->respondWithToken($data['access_token'], $data['refresh_token'], $data['user']);

        } catch (\Throwable $th) {
            return $this->fail_attempt('REFRESH_TOKEN_NOT_VALID','Refresh Token Not Valid');
        }
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken($token, $refresh_token, $users)
    {
        return new AuthCollection([
            'access_token' => $token,
            'refresh_token' => $refresh_token,
            'user' => $users
        ]);
    }

    protected function fail_attempt($code, $message)
    {

        return (new MessageErrorResource([
            'code' => $code,
            'message' => $message
        ]))->response()
           ->setStatusCode(400);

    }

}
