<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;

use App\Models\Match;
use App\Models\Prediction;

class PredictionsController extends Controller {

  /**
   * Retrieve the predictions for current user
   *
   * @return json
   */
  public function list() {
    $matches = Match::orderBy('date', 'DESC')->get();

    $matches = $matches->map(
      function($match) {
        return $this->cleanMatch($match);
      }
    );

    return Response::json($matches, 200);
  }

  /**
   * Insert the users predictions for the match score over the match object
   *
   * @param object $match
   * The match Eloquent collection
   *
   * @return
   */
  protected function cleanMatch($match) {
    $clean_match = parent::cleanMatch($match);

    $user_prediction = $match->userPrediction->first();

    if (is_null($user_prediction)) {
      $clean_match->score_home = null;
      $clean_match->score_away = null;
    }
    else {
      $clean_match->score_home = $user_prediction->score_home;
      $clean_match->score_away = $user_prediction->score_away;
    }

    return $clean_match;
  }

}
