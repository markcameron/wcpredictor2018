<?php

use Illuminate\Database\Seeder;
use App\Models\Match;
use App\Models\Stadium;
use App\Models\Team;
use Carbon\Carbon;

class RoundOf8MatchesTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    if (Match::count() > 56) {
      return;
    }

    $teams = Team::get();
    $stadiums = Stadium::get();
    $matches = [
      // July 6th
      [
        'home_team_id' => $teams->where('name', 'Uruguay')->first()->id,
        'away_team_id' => $teams->where('name', 'France')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Nizhny Novgorod Stadium')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 6, 14, 0, 0, 0)->timezone('UTC')->toDateTimeString(),
      ],
      [
        'home_team_id' => $teams->where('name', 'Brazil')->first()->id,
        'away_team_id' => $teams->where('name', 'Belgium')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Kazan Arena')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 6, 18, 0, 0, 0)->timezone('UTC')->toDateTimeString(),
      ],

      // July 7th
      [
        'home_team_id' => $teams->where('name', 'Sweden')->first()->id,
        'away_team_id' => $teams->where('name', 'England')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Cosmos Arena')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 7, 14, 0, 0, 0)->timezone('UTC')->toDateTimeString(),
      ],
      [
        'home_team_id' => $teams->where('name', 'Russia')->first()->id,
        'away_team_id' => $teams->where('name', 'Croatia')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Fisht Olympic Stadium')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 7, 18, 0, 0, 0)->timezone('UTC')->toDateTimeString(),
      ],
    ];

    foreach ($matches as $match) {
      Match::create($match);
    }
  }

}
