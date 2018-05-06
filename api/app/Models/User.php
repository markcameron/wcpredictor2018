<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

  use HasApiTokens, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'nickname',
    'first_name',
    'last_name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function getFullNameAttribute() {
    return $this->first_name .' '. $this->last_name;
  }

  public function getInitialsAttribute() {
    return substr(ucfirst($this->first_name), 0, 1) . substr(ucfirst($this->last_name), 0, 1) ;
  }

  public function predictions() {
    return $this->hasMany('App\Models\Prediction');
  }

}
