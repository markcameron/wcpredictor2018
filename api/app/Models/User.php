<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Schedula\Laravel\PassportSocialite\User\UserSocialAccount;

class User extends Authenticatable implements UserSocialAccount {

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
    'provider',
    'provider_user_id',
    'nickname',
    'catchphrase',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'provider',
    'provider_user_id',
  ];

  /**
   * Find user using social provider's id
   *
   * @param string $provider Provider name as requested from oauth e.g. facebook
   * @param string $id User id of social provider
   *
   * @return User
   */
  public static function findForPassportSocialite($provider,$id) {
    $account = SocialAccount::where('provider', $provider)->where('provider_user_id', $id)->first();
    if($account) {
      if($account->user){
        return $account->user;
      }
    }
    return;
  }

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
