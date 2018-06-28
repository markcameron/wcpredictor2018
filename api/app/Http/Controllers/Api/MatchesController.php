<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;

use App\Models\Match;

class MatchesController extends Controller {

  /**
   * Retrieve all the matches
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
   * Get a single match by id
   *
   * @param int $id
   * The match ID
   *
   * @return json
   */
  public function show($id) {
    $match = Match::whereId($id)
                  ->get();

    $match = $match->map(
      function($match) {
        return $this->cleanMatch($match);
      }
    );

    return Response::json($match->first(), 200);
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

    $clean_match->goals_home = $this->getGoals($match, 'home');
    $clean_match->goals_away = $this->getGoals($match, 'away');
    $clean_match->predictions = $this->getPredictions($match);

    $clean_match->has_score = FALSE;
    if (!(is_null($match->score_home) && is_null($match->score_away))) {
      $clean_match->has_score = TRUE;
    }

    return $clean_match;
  }


  /**
   * Helper function to create a clean match object from the different relations
   *
   * @param object $match
   * The match Eloquent collection
   *
   * @return
   */
  protected function getGoals($match, $team) {
    $goals = [];

    $method = 'goals'. ucfirst($team);

    foreach ($match->$method as $goal) {
      $goals[] = [
        'minute' => $goal->minute,
        'scored_by' => $goal->scored_by,
        'link' => $goal->link,
      ];
    }

    return $goals;
  }

  /**
   * Helper object to create a clean prediction object for each users
   * predicted score
   *
   * @param Model $match
   *
   * @return array
   */
  protected function getPredictions($match) {
    $predictions = [];

    foreach ($match->predictions as $prediction) {
      $predictions[] = [
        'name' => $prediction->user->full_name,
        'initials' => $prediction->user->initials,
        'score_home' => $prediction->score_home,
        'score_away' => $prediction->score_away,
        'status' => $this->getPredictionStatus($prediction),
      ];
    }

    return $predictions;
  }

  protected function getPredictionStatus($prediction) {
    if (predictedCorrectScore($prediction)) {
      return 'exact_score';
    }

    if (predictedCorrectDifference($prediction)) {
      return 'goal_difference';
    }

    if (predictedCorrectWinner($prediction)) {
      return 'winner';
    }

    return 'loser';
  }

}
