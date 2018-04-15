<?php

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Group;

// composer require laracasts/testdummy
//use Laracasts\TestDummy\Factory as TestDummy;

class TeamsTableSeeder extends Seeder {

  public function run() {
    if (Team::count()) {
      return;
    }

    $teams = [
      'A' => [
        [
          'name' => 'Russia',
          'code' => 'ru',
        ],
        [
          'name' => 'Saudi Arabia',
          'code' => 'sa',
        ],
        [
          'name' => 'Egypt',
          'code' => 'eg',
        ],
        [
          'name' => 'Uruguay',
          'code' => 'uy',
        ],
      ],
      'B' => [
        [
          'name' => 'Portugal',
          'code' => 'pt',
        ],
        [
          'name' => 'Spain',
          'code' => 'es',
        ],
        [
          'name' => 'Morocco',
          'code' => 'ma',
        ],
        [
          'name' => 'Iran',
          'code' => 'ir',
        ],
      ],
      'C' => [
        [
          'name' => 'France',
          'code' => 'fr',
        ],
        [
          'name' => 'Australia',
          'code' => 'au',
        ],
        [
          'name' => 'Peru',
          'code' => 'pe',
        ],
        [
          'name' => 'Denmark',
          'code' => 'dk',
        ],
      ],
      'D' => [
        [
          'name' => 'Argentina',
          'code' => 'ar',
        ],
        [
          'name' => 'Iceland',
          'code' => 'is',
        ],
        [
          'name' => 'Croatia',
          'code' => 'hr',
        ],
        [
          'name' => 'Nigeria',
          'code' => 'ng',
        ],
      ],
      'E' => [
        [
          'name' => 'Brazil',
          'code' => 'br',
        ],
        [
          'name' => 'Switzerland',
          'code' => 'ch',
        ],
        [
          'name' => 'Costa Rica',
          'code' => 'cr',
        ],
        [
          'name' => 'Serbia',
          'code' => 'rs',
        ],
      ],
      'F' => [
        [
          'name' => 'Germany',
          'code' => 'de',
        ],
        [
          'name' => 'Mexico',
          'code' => 'mx',
        ],
        [
          'name' => 'Sweden',
          'code' => 'se',
        ],
        [
          'name' => 'South Korea',
          'code' => 'kr',
        ],
      ],
      'G' => [
        [
          'name' => 'Belgium',
          'code' => 'be',
        ],
        [
          'name' => 'Panama',
          'code' => 'pa',
        ],
        [
          'name' => 'Tunisia',
          'code' => 'tn',
        ],
        [
          'name' => 'England',
          'code' => 'gb-eng',
        ],
      ],
      'H' => [
        [
          'name' => 'Poland',
          'code' => 'pl',
        ],
        [
          'name' => 'Senegal',
          'code' => 'sn',
        ],
        [
          'name' => 'Colombia',
          'code' => 'co',
        ],
        [
          'name' => 'Japan',
          'code' => 'jp',
        ],
      ],
    ];

    foreach ($teams as $group => $teams) {
      $group = Group::whereName($group)->first();

      foreach ($teams as $team) {
        $team = Team::create(
          [
            'name' => $team['name'],
            'code' => $team['code'],
            'group_id' => $group->id,
          ]
        );
      }
    }

  }

}
