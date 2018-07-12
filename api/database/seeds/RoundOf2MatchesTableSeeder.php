<?php

use Illuminate\Database\Seeder;
use App\Models\Match;
use App\Models\Stadium;
use App\Models\Team;
use Carbon\Carbon;

class RoundOf2MatchesTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    if (Match::count() > 62) {
      return;
    }

    $teams = Team::get();
    $stadiums = Stadium::get();
    $matches = [
      // July 14th
      [
        'home_team_id' => $teams->where('name', 'Belgium')->first()->id,
        'away_team_id' => $teams->where('name', 'England')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Krestovsky Stadium')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 14, 14, 0, 0, 0)->timezone('UTC')->toDateTimeString(),
      ],

      // July 15th
      [
        'home_team_id' => $teams->where('name', 'France')->first()->id,
        'away_team_id' => $teams->where('name', 'Croatia')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Luzhniki Stadium')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 15, 15, 0, 0, 0)->timezone('UTC')->toDateTimeString(),
      ],
    ];

    foreach ($matches as $match) {
      Match::create($match);
    }
  }

}
