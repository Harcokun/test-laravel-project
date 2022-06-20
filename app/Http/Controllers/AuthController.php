<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }

  public function register(Request $request)
  {
    $rules = [
      'firstname' => ['required', 'string', 'max:255'],
      'lastname' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8']
    ];

    $messages = [
      'required' => 'The :attribute field is required.',
      'unique' => 'The :attribute field must be unique.',
      'min' => 'The :attribute field length should be at least 8.',
      'max' => 'The :attribute field length should not be more than 255.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return response()->json($validator->messages(), 400);
    }

    $user = User::create([
      'firstname' => $request->firstname,
      'lastname' => $request->lastname,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    //$token = auth()->login($user);
    $token = $user->createToken('Personal Access Token')->accessToken;

    //return $this->respondWithToken($token);
    return response()->json(['token' => $token, 'user' => $user], 200);
  }

  /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
    //$credentials = request(['email', 'password']);
    // //return response()->json($credentials);
    // if (!$token = auth()->attempt($credentials)) {
    //   return response()->json(['error' => 'Unauthorized'], 401);
    // }

    // return $this->respondWithToken($token);

    $rules = [
      'email' => ['required', 'email'],
      'password' => ['required'],
    ];

    $messages = [
      'required' => 'The :attribute field is required.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return response()->json($validator->messages(), 400);
    }

    $user = User::where('email', $request->email)->firstOrFail();
    if(!$user) {
      return response()->json('Cannot find the user with this email', 404);
    }
    if (!Hash::check($request->password, $user->password)) {
      return response()->json('Password is incorrect', 403);
    }
    $token = $user->createToken('Personal Access Token')->accessToken;
    return response()->json(['token' => $token, 'user' => $user], 200);
  }

  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {
    return response()->json(Auth::user());
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout(Request $request)
  {
    $accessToken = auth()->user()->token();
    $token= $request->user()->tokens->find($accessToken);
    $token->revoke();
    return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    return $this->respondWithToken(auth()->refresh());
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth('api')->factory()->getTTL() * 60
    ]);
  }
}
