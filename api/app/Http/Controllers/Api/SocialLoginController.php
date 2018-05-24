<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Route;
use Socialite;

class SocialLoginController extends Controller {

  public function loginFacebook(Request $request) {
    try {
      $facebook = Socialite::driver('facebook')
                           ->userFromToken($request->accessToken);

//      return response()->json([
//        "facebook" => $facebook
//      ]);

      $user = User::where('provider', 'facebook')
                  ->where('provider_user_id', $facebook->getId())
                  ->first();

      if (is_null($user)) {
        $name = explode(' ', $facebook->getName());

        User::create([
          'first_name' => isset($name[0]) ? $name[0] : '',
          'last_name' => isset($name[1]) ? $name[1] : '',
          'email' => $facebook->getEmail(),
          'provider' => 'facebook',
          'provider_user_id' => $facebook->getId(),
        ]);
      }

      return response()->json($this->issueToken($request, 'facebook', $request->accessToken));
    }
    catch (\Exception $e) {
      return response()->json([
        "error" => $e->getMessage()
      ]);
    }

  }

  public function issueToken(Request $request, $provider, $accessToken) {
    /**
     * Here we will request our app to gnerate access token
     * and refresh token for the user using its social identity by providing access token
     * and provider name of the provider. (I hope its not confusing)
     * and then it goes through social grant and which fetches providers user id then calls
     * findForPassportSocialite from your user model if it returns User object then it generates
     * oauth tokens or else will throw error message normally like other oauth requests.
     */
    $params = [
      'grant_type' => 'social',
      'client_id' => env('PASSPORT_CLIENT_ID'),
      'client_secret' => env('PASSPORT_CLIENT_SECRET'),
      'accessToken' => $accessToken,
      'provider' => $provider,
    ];
    $request->request->add($params);

    $requestToken = Request::create("oauth/token", "POST");
    $response = Route::dispatch($requestToken);

    return response()->json([
      "response" => json_decode($response->getContent())
    ]);
  }

}
