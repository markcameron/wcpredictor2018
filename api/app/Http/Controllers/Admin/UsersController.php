<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Match;
use Response;
use App\Http\Controllers\AuthenticatedController;

class UsersController extends AuthenticatedController {

  /**
   * init Class
   */
  function __construct() {
    parent::__construct();

    $this->middleware('admin');
  }

  /**
   * Retrieve all the matches
   *
   * @return json
   */
  public function index() {
    $users = User::with('predictions')
                 ->get();

    $match_count = Match::count();

    return view('admin.users.index')->withUsers($users)
                                    ->with('match_count', $match_count);
  }

}
