<?php

/**
 * Check if the user predicted the correct score of the game
 *
 * @param Prediction $prediction
 * The prediction Eloquent object
 *
 * @return bool
 * TRUE if prediction is correct, otherwise FALSE
 */
function predictedCorrectScore($prediction) {
  //    print_r($prediction->score_home .":". $prediction->match->score_home ." | ". $prediction->score_away .":". $prediction->match->score_away);

  if ($prediction->score_home === $prediction->match->score_home
                               && $prediction->score_away === $prediction->match->score_away) {
    //      print_r(" - 5\n");
    return TRUE;
  }

  //    print_r("\n");
  return FALSE;
}

/**
 * Check if the user predicted the correct goal difference of the game
 *
 * @param Prediction $prediction
 * The prediction Eloquent object
 *
 * @return bool
 * TRUE if prediction is correct, otherwise FALSE
 */
function predictedCorrectDifference($prediction) {
  if (is_null($prediction->match->score_home) && is_null($prediction->match->score_away)) {
    return FALSE;
  }

  $predicted_difference = $prediction->score_home - $prediction->score_away;
  $match_difference = $prediction->match->score_home - $prediction->match->score_away;

  //    print_r($predicted_difference ." | ". $match_difference);

  if ($predicted_difference == $match_difference) {
    //      print_r(" - 3\n");
    return TRUE;
  }

  //    print_r("\n");
  return FALSE;
}

/**
 * Check if the user predicted the correct winner of the game
 *
 * @param Prediction $prediction
 * The prediction Eloquent object
 *
 * @return bool
 * TRUE if prediction is correct, otherwise FALSE
 */
function predictedCorrectWinner($prediction) {
  if (is_null($prediction->match->score_home) && is_null($prediction->match->score_away)) {
    return FALSE;
  }

  $predicted_difference = $prediction->score_home - $prediction->score_away;
  $match_difference = $prediction->match->score_home - $prediction->match->score_away;

  //    print_r($predicted_difference ." | ". $match_difference);

  if ($predicted_difference < 0 && $match_difference < 0 || $predicted_difference > 0 && $match_difference > 0) {
    //      print_r(" - 1\n");
    return TRUE;
  }

  //    print_r("\n");
  return FALSE;
}
