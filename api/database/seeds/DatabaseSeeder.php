<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $this->call(GroupsTableSeeder::class);
    $this->call(TeamsTableSeeder::class);
    $this->call(StadiumsTableSeeder::class);
    $this->call(MatchesTableSeeder::class);
    $this->call(RoundOf16MatchesTableSeeder::class);
    $this->call(RoundOf8MatchesTableSeeder::class);
    $this->call(RoundOf4MatchesTableSeeder::class);
    $this->call(RoundOf2MatchesTableSeeder::class);
  }

}
