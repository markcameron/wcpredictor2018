<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();
      $table->datetime('last_seen')->nullable();
      $table->boolean('is_admin')->default(FALSE);
      $table->boolean('can_predict')->default(TRUE);
      $table->string('nickname')->nullable()->default(NULL);
      $table->string('last_name');
      $table->string('first_name');
      $table->string('email')->unique();
      $table->integer('active')->default(0);
      $table->string('password');
      $table->string('activation_code')->nullable()->default(NULL);
      $table->rememberToken();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('users');
  }

}
