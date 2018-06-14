<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Route;

class LoginController extends Controller {

  /*
     |--------------------------------------------------------------------------
     | Login Controller
     |--------------------------------------------------------------------------
     |
     | This controller handles authenticating users for the application and
     | redirecting them to your home screen. The controller uses a trait
     | to conveniently provide its functionality to your applications.
     |
   */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/admin';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('guest')->except('logout');
  }

  public function apiLogin(Request $request) {
    /**
     * Here we will request our app to gnerate access token
     * and refresh token for the user using its social identity by providing access token
     * and provider name of the provider. (I hope its not confusing)
     * and then it goes through social grant and which fetches providers user id then calls
     * findForPassportSocialite from your user model if it returns User object then it generates
     * oauth tokens or else will throw error message normally like other oauth requests.
     */
    $params = [
      'grant_type' => 'password',
      'client_id' => env('PASSPORT_CLIENT_ID'),
      'client_secret' => env('PASSPORT_CLIENT_SECRET'),
      'username' => $request->username,
      'password' => $request->password,
    ];

    $request->request->add($params);

    $requestToken = Request::create("oauth/token", "POST");
    $response = Route::dispatch($requestToken);

    return response()->json([
      "response" => json_decode($response->getContent())
    ]);
  }

}
