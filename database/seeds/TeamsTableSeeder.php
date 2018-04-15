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
          'code' => 'ro',
        ],
        [
          'name' => 'Egypt',
          'code' => 'al',
        ],
        [
          'name' => 'Uruguay',
          'code' => 'ch',
        ],
      ],
      'B' => [
        [
          'name' => 'Portugal',
          'code' => 'gb-eng',
        ],
        [
          'name' => 'Spain',
          'code' => 'ru',
        ],
        [
          'name' => 'Morocco',
          'code' => 'gb-wls',
        ],
        [
          'name' => 'Iran',
          'code' => 'sk',
        ],
      ],
      'C' => [
        [
          'name' => 'France',
          'code' => 'fr',
        ],
        [
          'name' => 'Australia',
          'code' => 'ua',
        ],
        [
          'name' => 'Peru',
          'code' => 'pl',
        ],
        [
          'name' => 'Denmark',
          'code' => 'gb-nir',
        ],
      ],
      'D' => [
        [
          'name' => 'Argentina',
          'code' => 'es',
        ],
        [
          'name' => 'Iceland',
          'code' => 'cz',
        ],
        [
          'name' => 'Croatia',
          'code' => 'tr',
        ],
        [
          'name' => 'Nigeria',
          'code' => 'hr',
        ],
      ],
      'E' => [
        [
          'name' => 'Brazil',
          'code' => 'be',
        ],
        [
          'name' => 'Switzerland',
          'code' => 'it',
        ],
        [
          'name' => 'Costa Rica',
          'code' => 'ie',
        ],
        [
          'name' => 'Serbia',
          'code' => 'se',
        ],
      ],
      'F' => [
        [
          'name' => 'Germany',
          'code' => 'de',
        ],
        [
          'name' => 'Mexico',
          'code' => 'is',
        ],
        [
          'name' => 'Sweden',
          'code' => 'at',
        ],
        [
          'name' => 'South Korea',
          'code' => 'hu',
        ],
      ],
      'G' => [
        [
          'name' => 'Belgium',
          'code' => 'be',
        ],
        [
          'name' => 'Panama',
          'code' => 'is',
        ],
        [
          'name' => 'Tunisia',
          'code' => 'at',
        ],
        [
          'name' => 'England',
          'code' => 'hu',
        ],
      ],
      'H' => [
        [
          'name' => 'Poland',
          'code' => 'de',
        ],
        [
          'name' => 'Senegal',
          'code' => 'is',
        ],
        [
          'name' => 'Colombia',
          'code' => 'at',
        ],
        [
          'name' => 'Japan',
          'code' => 'hu',
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
