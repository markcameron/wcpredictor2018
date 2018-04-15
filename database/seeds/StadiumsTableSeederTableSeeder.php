<?php

use Illuminate\Database\Seeder;
use App\Models\Stadium;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class StadiumsTableSeeder extends Seeder {

  public function run() {
    if (Stadium::count()) {
      return;
    }

    $stadiums = [
      [
        'name' => 'Luzhniki Stadium',
        'city' => 'Moscow',
      ],
      [
        'name' => 'Otkritie Arena',
        'city' => 'Moscow',
      ],
      [
        'name' => 'Krestovsky Stadium',
        'city' => 'Saint Petersburg',
      ],
      [
        'name' => 'Kaliningrad Stadium',
        'city' => 'Kaliningrad',
      ],
      [
        'name' => 'Kazan Arena',
        'city' => 'Kazan',
      ],
      [
        'name' => 'Nizhny Novgorod Stadium',
        'city' => 'Nizhny Novgorod',
      ],
      [
        'name' => 'Cosmos Arena',
        'city' => 'Samara',
      ],
      [
        'name' => 'Volgograd Arena',
        'city' => 'Volgograd',
      ],
      [
        'name' => 'Mordovia Arena',
        'city' => 'Saransk',
      ],
      [
        'name' => 'Rostov Arena',
        'city' => 'Rostov-on-Don',
      ],
      [
        'name' => 'Fisht Olympic Stadium',
        'city' => 'Sochi',
      ],
      [
        'name' => 'Central Stadium',
        'city' => 'Yekaterinburg',
      ],
    ];

    foreach ($stadiums as $stadium) {
      Stadium::create($stadium);
    }
  }

}
