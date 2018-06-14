<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\User;
use Response;

use App\Http\Controllers\Controller;

class LeaderboardsController extends Controller {

  const POINTS_CORRECT_SCORE = 5;
  const POINTS_CORRECT_DIFFERENCE = 3;
  const POINTS_CORRECT_WINNER = 2;

  protected $score;

  /**
   * Retrieve all the matches
   *
   * @return json
   */
  public function index() {
    $leaderboard = User::get();

    $leaderboard = $leaderboard->map(
      function($user) {
        $this->calculateScore($user);

        return (object) array_merge(
          [
            'full_name' => $user->full_name,
            'initials' => $user->initials,
            'catchphrase' => $user->catchphrase,
            'nickname' => $user->nickname,
          ], $this->score);
      }
    );

    $leaderboard = $leaderboard->sortByDesc('score');

    return Response::json($leaderboard->values(), 200);
  }

  /**
   * Loop through the users predictions and get their score
   *
   * @param User $user
   *
   * @return void
   */
  protected function calculateScore($user) {
    $this->score = [
      'exact_score' => 0,
      'correct_goal_difference' => 0,
      'correct_winner' => 0,
      'score' => 0,
    ];

    foreach ($user->predictions as $prediction) {
      $this->getMatchPoints($prediction);
    }
  }

  /**
   * Check all possible score giving outcomes and return points
   *
   * @param Prediction $prediction
   * The prediction Eloquent object
   *
   * @return int
   * The points that the users gets for the match
   */
  protected function getMatchPoints($prediction) {
    if (predictedCorrectScore($prediction)) {
      $this->score['exact_score']++;
      $this->score['score'] += self::POINTS_CORRECT_SCORE;
      return;
    }

    if (predictedCorrectDifference($prediction)) {
      $this->score['correct_goal_difference']++;
      $this->score['score'] += self::POINTS_CORRECT_DIFFERENCE;
      return;
    }

    if (predictedCorrectWinner($prediction)) {
      $this->score['correct_winner']++;
      $this->score['score'] += self::POINTS_CORRECT_WINNER;
      return;
    }
  }

}
