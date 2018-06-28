<?php

use Illuminate\Database\Seeder;
use App\Models\Match;
use App\Models\Stadium;
use App\Models\Team;
use Carbon\Carbon;

class RoundOf16MatchesTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    if (Match::count() > 48) {
      return;
    }

    $teams = Team::get();
    $stadiums = Stadium::get();
    $matches = [
      // 30th June
      [
        'home_team_id' => $teams->where('name', 'France')->first()->id,
        'away_team_id' => $teams->where('name', 'Argentina')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Kazan Arena')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 6, 30, 17, 0, 0, 3)->timezone('UTC')->toDateTimeString(),
      ],
      [
        'home_team_id' => $teams->where('name', 'Uruguay')->first()->id,
        'away_team_id' => $teams->where('name', 'Portugal')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Fisht Olympic Stadium')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 6, 30, 21, 0, 0, 3)->timezone('UTC')->toDateTimeString(),
      ],

      // 1st July
      [
        'home_team_id' => $teams->where('name', 'Spain')->first()->id,
        'away_team_id' => $teams->where('name', 'Russia')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Luzhniki Stadium')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 1, 17, 0, 0, 3)->timezone('UTC')->toDateTimeString(),
      ],
      [
        'home_team_id' => $teams->where('name', 'Croatia')->first()->id,
        'away_team_id' => $teams->where('name', 'Denmark')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Nizhny Novgorod Stadium')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 1, 21, 0, 0, 3)->timezone('UTC')->toDateTimeString(),
      ],

      // 2nd July
      [
        'home_team_id' => $teams->where('name', 'Brazil')->first()->id,
        'away_team_id' => $teams->where('name', 'Mexico')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Cosmos Arena')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 2, 17, 0, 0, 4)->timezone('UTC')->toDateTimeString(),
      ],
      [
        'home_team_id' => $teams->where('name', 'Belgium')->first()->id,
        'away_team_id' => $teams->where('name', 'Japan')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Rostov Arena')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 2, 21, 0, 0, 3)->timezone('UTC')->toDateTimeString(),
      ],

      // 3rd July
      [
        'home_team_id' => $teams->where('name', 'Sweden')->first()->id,
        'away_team_id' => $teams->where('name', 'Switzerland')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Krestovsky Stadium')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 3, 17, 0, 0, 3)->timezone('UTC')->toDateTimeString(),
      ],
      [
        'home_team_id' => $teams->where('name', 'Colombia')->first()->id,
        'away_team_id' => $teams->where('name', 'England')->first()->id,
        'stadium_id' => $stadiums->where('name', 'Otkritie Arena')->first()->id,
        'can_predict' => TRUE,
        'is_ko_stage' => TRUE,
        'date' => Carbon::create(2018, 7, 3, 21, 0, 0, 3)->timezone('UTC')->toDateTimeString(),
      ],

    ];

    foreach ($matches as $match) {
      Match::create($match);
    }
  }

}
