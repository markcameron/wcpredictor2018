<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Response;
use App\Http\Controllers\Controller;

use App\Models\Match;
use App\Models\Prediction;

use App\Http\Requests\SubmitPredictionRequest;

use Illuminate\Auth\AuthManager;

class PredictionsController extends Controller {

  /**
   * Retrieve the predictions for current user
   *
   * @return json
   */
  public function list() {
    $matches = Match::orderBy('date', 'ASC')->get();

    $matches = $matches->map(
      function($match) {
        return $this->cleanMatch($match);
      }
    );

    return Response::json($matches, 200);
  }

  /**
   * Get a single match by id
   *
   * @param int $id
   * The match ID
   *
   * @return json
   */
  public function update(AuthManager $auth, SubmitPredictionRequest $request, $match_id) {
    $this->user = $auth->user();

    $prediction = Prediction::whereMatchId($match_id)
                            ->whereUserId($this->user->id)
                            ->first();


    if (!$this->user->can_predict) {
      return Response::json(['No longer permitted to submit predictions'], 403);
    }

    if (is_null($prediction)) {
      $prediction = Prediction::create(
        [
          'user_id' => $this->user->id,
          'match_id' => $match_id,
          'score_home' => $request->score_home,
          'score_away' => $request->score_away,
        ]
      );
    }
    else {
      $prediction->score_home = $request->score_home;
      $prediction->score_away = $request->score_away;

      $prediction->update();
    }

    return Response::json(['prediction' => $prediction], 200);
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
