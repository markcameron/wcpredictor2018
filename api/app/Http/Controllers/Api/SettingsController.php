<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Response;
use App\Http\Controllers\Controller;

use Illuminate\Auth\AuthManager;

class SettingsController extends Controller {

  /**
   * Retrieve all the settings
   *
   * @return json
   */
  public function Index(AuthManager $auth) {
    return Response::json($auth->user()->only(['nickname', 'catchphrase']), 200);
  }

  /**
   * Update settings
   *
   * @param int $id
   * The match ID
   *
   * @return json
   */
  public function update(AuthManager $auth, Request $request) {
    $this->user = $auth->user();

    $this->user->nickname = $request->nickname;
    $this->user->catchphrase = $request->catchphrase;
    $this->user->save();

    return Response::json($this->user->only(['nickname', 'catchphrase']), 200);
  }

}
