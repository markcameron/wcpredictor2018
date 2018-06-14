<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthenticatedController;

use App\Models\Match;
use App\Models\User;

class DashboardController extends AuthenticatedController {

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('admin');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    return view('admin.dashboard.index');
  }

  public function matchesCanPredictFalse() {
    Match::where('can_predict', 1)
         ->update(['can_predict' => 0]);

    return redirect()->back();
  }

  public function matchesCanPredictTrue() {
    Match::where('can_predict', 0)
         ->update(['can_predict' => 1]);

    return redirect()->back();
  }

  public function usersCanPredictFalse() {
    User::where('can_predict', 1)
         ->update(['can_predict' => 0]);

    return redirect()->back();
  }

  public function usersCanPredictTrue() {
    User::where('can_predict', 0)
         ->update(['can_predict' => 1]);

    return redirect()->back();
  }

}
